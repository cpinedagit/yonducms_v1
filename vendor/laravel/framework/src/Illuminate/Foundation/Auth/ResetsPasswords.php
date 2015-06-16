<?php namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \App\Models\cms\User;
use DB;
use Mail;
use Validator;

trait ResetsPasswords {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * The password broker implementation.
	 *
	 * @var PasswordBroker
	 */
	protected $passwords;

	/**
	 * Display the form to request a password reset link.
	 *
	 * @return Response
	 */

	public function getEmail()
	{
		return view('auth.password');
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function postEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$response = $this->passwords->sendResetLink($request->only('email'), function($m)
		{
			$m->subject($this->getEmailSubject());
		});

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				return redirect()->back()->with('status', trans($response));

			case PasswordBroker::INVALID_USER:
				return redirect()->back()->withErrors(['email' => trans($response)]);
		}
	}

	/**
	 * Get the e-mail subject line to be used for the reset link email.
	 *
	 * @return string
	 */
	protected function getEmailSubject()
	{
		return isset($this->subject) ? $this->subject : 'Your Password Reset Link';
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset()
	{
		return view('auth.password');
	}

	/**
	 *postRequest Forgot Password function goes here
	 */

	public function postReset(Request $request)
	{
		
		//Validate request
		$validation = Validator::make($request->all(), [
			'username' => 'required',
			'captcha'  => 'required|captcha',
		]);

		//Check if user exist
		$user = User::checkUserStatus($request->input('username'));

		//If user exist
		//dd($user);
		if(isset($user->username) && $validation->fails()==false)
		{
			//Notify System admin
			//Send email notification
			$this->notifySystemAdminAboutForgotPassword($user);
			
			//Add a flag that this user forgot his password
			//forgot_password Flag: use as backend notification
			User::addForgotPasswordFlag($user->id);

			//Return to Forgot Password Form
			//Add Success Message that his request has been sent
			return $this->redirectToForgotPasswordForm($request, $validation, 'Forgot password request has been sent to System Admin. Thank you!');
		}
		else
		{
			//If username is correct notify that captcha is incorrect
			if(isset($user->username)){
				return $this->redirectToForgotPasswordForm($request, $validation, '');
			}
			else{
				//Redirect if this user isn't found
				//Or there are error on input
				return $this->redirectToForgotPasswordForm($request, $validation, 'These credentials do not match our records!');
			}
		}
	}


	//Redirect to Forgot Password Form with Warning or Success Message
	public function redirectToForgotPasswordForm($request, $validation, $error_msg)
	{
		return redirect()->back()
						   ->withInput($request->only('username'))
						   ->withErrors($validation->errors()->add('error_msg', $error_msg));
	} 

	//Send email notification: User Forgot Password
	public function notifySystemAdminAboutForgotPassword($user)
	{
		//Set all necessary fields
		$data = array(
			'user_id'             => $user->id,
			'username'            => $user->username,
			'first_name'		  => $user->first_name,
			'last_name'		      => $user->last_name,
			'email_address'		  => $user->email,
			'admin'				  => $this->listAdminUsers()
		);

		Mail::later(10, 'cms.emails.notify_admin_forgot_password', compact('data'), function($message) use ($data)
		{
		    $message->from('yondu.cms@example.com', "Yondu Webservices Alert: Forgot password.");

		    $message->to($data['admin'])->subject('Yondu CMS System Notification');
		});
	}

	//List all active system admin
	//Notify them when account has been disbaled
	public function listAdminUsers()
	{
		$admin_emails = User::listAllAdminUsers();

		//Convert object to array
		$arr_emails = array();
		foreach ($admin_emails as $key => $value) {
			$arr_emails[] = $value->email;
		}

		return $arr_emails;
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

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
	}

}
