<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use \App\Models\cms\User;
use Input;
use Validator;
use Auth;
use DB;
use Mail;

/**
 * Change Password Controller
 * Handle changing of password outside the system
 * Prompt the user to change his Password
 * Cause he is a new user or 
 * Admin has recently reset his password
 */

class ChangePasswordController extends Controller {

	
	public function index()
	{
		return view('cms.change_password.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
			
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	//Update Outside the system
	//No Captcha Required
	public function update($id)
	{

		$v = Validator::make(Input::all(), [
	        'username' => 'required', 
			'password' => 'required',
			'new_password' => 'required|min:6',
			'confirm_new_password' => 'required|min:6',
	    ]);

		//Check if user exist in users table
		$credentials = Input::only('username', 'password');

		//If credentials are okay
		//Update user credentials
		if (Auth::once($credentials))
		{
			//Update temporary password
			User::updateTemporaryPassword(Auth::user()->id, Input::only('new_password'));

			//Promp the user to Log in 
			//After successfull change of temporary password
			return redirect('/auth/login')
						->withInput(Input::only('username'))
						->withErrors(
							$v->errors()->add('error_msg', 'Password has been changed, try to log-in again!')
						);
		}
		else
		{
			//Redirect to Change Password Page with username
			return redirect()->back()
								->withInput(Input::only('username'))
								->withErrors(
									$v->errors()->add('error_msg', 'These credentials do not match our records!')
								);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
