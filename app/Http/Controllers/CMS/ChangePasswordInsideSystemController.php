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
use View;

class ChangePasswordInsideSystemController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		//Read the settings .env set app title and tag line
		View::share('APP_TITLE', env('APP_TITLE'));
		View::share('APP_TAG_LINE', env('APP_TAG_LINE'));

		//$this->middleware('guest'); 	 //Doesn't require active user
		$this->middleware('is.allowed'); //Require require active user
	}

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cms.change_password_user.index')
					->withUsername(\Auth::user()->username);
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
		return view('cms.change_password_user.index')
					->withUsername(\Auth::user()->username);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$v = Validator::make(Input::all(), [
			'username'             => 'required', 
			'password'             => 'required',
			'new_password'         => 'required|min:6',
			'confirm_new_password' => 'required|min:6',
			'captcha'  			   => 'required|captcha',
	    ]);

		$error_msg = ""; //Default Error Message

		//Check if user exist in users table
		$credentials = Input::only('username', 'password');

		//If credentials are okay
		//Update user credentials
		//And there is no error in the input

		if (Auth::once($credentials) && $v->fails()==false)
		{
			//Update temporary password
			User::updateTemporaryPassword(Auth::user()->id, Input::only('new_password'));

			//Log-out the user
			//After successfully updating his password
			Auth::logout();

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
			//Add warning if no user found
			if(!Auth::once($credentials))
				$error_msg = "These credentials do not match our records!";

			return redirect()->back()
								->withInput(Input::only('username'))
								->withErrors(
									$v->errors()->add('error_msg', $error_msg)
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
