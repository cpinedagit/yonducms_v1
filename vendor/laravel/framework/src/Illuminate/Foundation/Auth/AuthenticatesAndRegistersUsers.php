<?php namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use \App\Models\cms\User;
use Validator;
use Auth;
use DB;
use Mail;
use Feeds;
use Session;

trait AuthenticatesAndRegistersUsers {


	/**
	 * The Guard implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Guard
	 */
	protected $auth;

	/**
	 * The registrar implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Registrar
	 */
	protected $registrar;

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		return view('auth.register');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->auth->login($this->registrar->create($request->all()));

		return redirect($this->redirectPath());
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		return view('auth.login');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{	
		//Filter input use username and password
		$credentials = $request->only('username', 'password');

		//If credentials are okay
		//Try to Log in the user to view his credentials
		if ($this->auth->once($credentials))
		{
			
			if(Auth::user()->is_active==0)
			{      
				//Is Active User
				return $this->redirectToLogInPage($request, 'Account is currently disabled!');
			}
			elseif(Auth::user()->is_locked==1 || Auth::user()->failed_login_attemp>=3)
			{ 
				//Lock account
				//Check if username exist on database
				$this->checkUserName($request->input('username'));

				return $this->redirectToLogInPage($request, "Account locked due to ". $this->logInAttempCtr(Auth::user()->id) ." invalid login attempts!");
			}
			elseif(Auth::user()->reset_password==1)
			{ 
				//New User Or Recently Reset User's Password
				//Require the User To Update his temporary Password
				return $this->redirectToChangePasswordPage($request, "Sorry, kindly update your temporary password!");
			}
			elseif($this->checkIfPasswordExpired(Auth::user()->reset_password_timestamp)<=0 AND Auth::user()->user_type=='user')
			{ 
				//Redirect if password expired
				return $this->redirectToChangePasswordPage($request, "Your password has expired and must be changed!");
			}
			else
			{
				//Log in User
				//If no problem occur
				Auth::login(Auth::user());

				//Check if password is nearly expiring
				//Exception if Admin
				//Add notification to user
			
				if(Auth::user()->user_type=='user' AND $this->checkIfPasswordExpired(Auth::user()->reset_password_timestamp)>=1 AND $this->checkIfPasswordExpired(Auth::user()->reset_password_timestamp)<= env('DAYS_BEFORE_PASSWORD_EXPIRES')){
					
					//Add warning message when his password will expire
					Session::flash('message', "Your password will expire in less than ".$this->checkIfPasswordExpired(Auth::user()->reset_password_timestamp)." day/s. Kindly update your password!");
					
					return redirect('cms');
				}else{
					return redirect()->intended($this->redirectPath());
				}
			}
		}
		else
		{
			//Check if username exist on database
			$this->checkUserName($request->input('username'));

			return $this->redirectToLogInPage($request, 'These credentials do not match our records!');
		}
			
	}

	//Check if user's password is not yet expired
	public function checkIfPasswordExpired($reset_password_timestamp)
	{
		//Get current TimeStamp
		$currentTimeStamp = \Carbon\Carbon::now();
		//Get days before password expiration
		$dayBeforePasswordNeedChange = env('DAYS_BEFORE_PASSWORD_NEEDS_TO_BE_CHANGE');  
		//Last Reset Date + Days Before Password Need to be Change
		$lastPasswordReset = \Carbon\Carbon::parse($reset_password_timestamp)->addDays($dayBeforePasswordNeedChange);
		
		//Compute remaining days based on current timestamp
		return $currentTimeStamp->diffInDays($lastPasswordReset, false);
	}

	//If user is new or Need to change his temporary Password
	public function redirectToChangePasswordPage($request, $error_msg)
	{
		$v = Validator::make($request->only('username'), ['username' => 'required']);

		return redirect('change_password')
					->withInput($request->only('username'))
					->withErrors(
						$v->errors()->add('error_msg', $error_msg)
					);
	}

	//If user is not found or has a log in discretion
	//Redirect to Log-in page
	public function redirectToLogInPage(Request $request, $error_msg)
	{
		
		$v = Validator::make($request->all(), [
	        'username' => 'required', 
			'password' => 'required',
	    ]);

		return redirect($this->loginPath())
					->withInput($request->only('username'))
					->withErrors(
						$v->errors()->add('error_msg', $error_msg)
					);
	}

	//Check if username exist during his log in
	//If username is correct and password is not
	//Record failed log-in attemp on database
	public function checkUserName($username)
	{
		//Check if username exist 
		//Check if user
		$user = User::checkIfThisUserExist($username);

		//If user exist add 1 log-in attemp
		//Lock account if necessary
		if(isset($user->username))
		{
			//Add +1 log-in attemp
			User::addOneLogInAttempt($username, $user->failed_login_attemp);

            //If user's log in attemp reach 3 or more
            //Lock account
            $user =  User::checkUserStatus($username);//Check user status
            if($user->failed_login_attemp>=3)
            {
            	//Lock user Account
            	User::lockUserAccount($username);

            	//Send an email to admin to inform him 
            	//that user account has been disabled
            	$this->sendEmailToAdmin($user);
            }
		}
	}

	//After disabling the user account
	//System will send an email to system admin
	function sendEmailToAdmin($user)
	{
		//Set all necessary fields
		$data = array(
			'user_id'             => $user->id,
			'username'            => $user->username,
			'first_name'		  => $user->first_name,
			'last_name'		      => $user->last_name,
			'email_address'		  => $user->email,
			'failed_login_attemp' => $this->logInAttempCtr($user->id),
			'admin'				  => $this->listAdminUsers()
		);

		Mail::later(5, 'cms.emails.disabled_account', compact('data'), function($message) use ($data)
		{
		    $message->from('yondu.cms@example.com', "Yondu Webservices Alert: Account has been disabled.");

		    $message->to($data['admin'])->subject('Yondu CMS System Notification');
		});
	}

	//List all active system admin
	//Notify them when account has been disbaled
	function listAdminUsers()
	{
		$admin_emails = User::listAllAdminUsers();

		//Convert object to array
		$arr_emails = array();
		foreach ($admin_emails as $key => $value) {
			$arr_emails[] = $value->email;
		}

		return $arr_emails;
	}

	//Return Number of failed log in
	function logInAttempCtr($user_id)
	{
		return User::logInAttempCtr($user_id);
	}

	/**
	 * Get the failed login message.
	 *
	 * @return string
	 */
	protected function getFailedLoginMessage()
	{
		return 'These credentials do not match our records.';
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		$this->auth->logout();

		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/auth/login');
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/cms';
	}

	/**
	 * Get the path to the login route.
	 *
	 * @return string
	 */
	public function loginPath()
	{
		return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
	}

}
