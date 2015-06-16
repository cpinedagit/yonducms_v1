<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\UserRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Input;
use File;
use View;
use Mail;

class UserController extends Controller {

	protected $users;

	public function index()
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.user.index');
		$users = User::getAllUsers();
		$roles = Role::getActiveRoles();
		$userCounts = User::getUserPerRoleCount();
		return view('cms.user.index', compact('users', 'roles', 'userCounts'));
	}

	public function create()
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.user.create');
		$roles = Role::getActiveRoles();
		return view('cms.user.create', compact('roles'));
	}

	public function store()
	{
		$user = new User;
		$path = 'public/images/profile';		
		$file = Input::file('profile_pic');

		$v = Validator::make(Input::all(), [
				'username'		=> 'required',
				'email'			=> 'required|email',
				'first_name'	=> 'required',
				'last_name'		=> 'required',
				'password'		=> 'required|min:6'
			]);

		$userCount = User::getUsername(Input::get('username'));

		if($v->fails() == false && $userCount[0]->c_user <= 0) {				
			$user->username                 = Input::get('username');
			$user->slug                     = Input::get('username');
			$user->email                    = Input::get('email');
			$user->first_name               = Input::get('first_name');
			$user->last_name                = Input::get('last_name');
			$user->password                 = Hash::make(Input::get('password'));
			$user->role_id 					= Input::get('role_id');
			//Require to update your temporary password
			$user->reset_password           = 1; 
			//Set to timestamp
			$user->reset_password_timestamp = \Carbon\Carbon::now(); 

			if(Input::file('profile_pic') != '') {
				$user->profile_pic              = $file->getClientOriginalName();
				$file->move($path, $file->getClientOriginalName());
			}

			$user->save();
			//Send Email notification to user
			$this->sendEmailNotificationToUser($user->id, Input::get('password'), "cms.emails.new_user_notification", "Yondu Webservices Alert: New account notification.");

			return $this->index();		

		} else {
			if($userCount[0]->c_user > 0) {
				$error_msg = "Username is already in use.";
			}

			return redirect()->back()
								->withInput(Input::only('username', 'first_name', 'last_name', 'email'))
								->withErrors(
									$v->errors()->add('error_msg', $error_msg)
								);
		}

	}

	//Send Email notification to user
	public function sendEmailNotificationToUser($user_id, $temporary_password, $template, $add_message)
	{
		//Set all necessary fields
		$user = User::find($user_id);
		$data = array(
			'user_id'            => $user->id,
			'username'           => $user->username,
			'first_name'         => $user->first_name,
			'last_name'          => $user->last_name,
			'to'                 => $user->email,
			'temporary_password' => $temporary_password,
			'add_message'        => $add_message
		);

		Mail::later(5, $template, compact('data'), function($message) use ($data)
		{
		    $message->from('yondu.cms@example.com', $data['add_message']);

		    $message->to($data['to'])->subject('Yondu CMS System Notification');
		});
	}


	public function show($id)
	{

	}

	public function edit($slug)
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.user.index');
		$user = User::where('slug', '=', $slug)->firstOrFail();
		$roles = Role::getActiveRoles();
		$roleName = Role::getRoleOf($user->role_id);
		$roleName = (object) $roleName[0];
		return view('cms.user.edit', compact('user', 'roleName', 'roles'));
	}

	public function update($id)
	{
		$user             = User::find($id);
		$path = 'public/images/profile';		
		$file = Input::file('profile_pic');

		$user->username   = Input::get('username'); 
		$user->first_name = Input::get('first_name');
		$user->last_name  = Input::get('last_name');
		$user->slug       = Input::get('username');
		$user->email      = Input::get('email');
		$user->role_id    = Input::get('role_id');

		//Update password only when password field in not empty
		if(Input::get('password')!=''){
			//Send email notification to user
			$this->sendEmailNotificationToUser($user->id, Input::get('password'), "cms.emails.user_password_reset_notification", "Yondu Webservices Alert: User password change notification.");
			//Require to update your temporary password
			$user->reset_password           = 1; 
			//Set to timestamp
			$user->reset_password_timestamp = \Carbon\Carbon::now(); 
			//Set new password
			$user->password   = Hash::make(Input::get('password'));
		}else{
			$user->password   = Hash::make(Input::get('password'));	
		}

		if(Input::file('profile_pic') != '') {
			$user->profile_pic = $file->getClientOriginalName();	
			$file->move($path, $file->getClientOriginalName());
		}

		$user->save();


		return $this->index();
	}

	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();
		return $this->index();
	}

	public function profile()
	{
		return view('cms.user.profile');
	}

}
