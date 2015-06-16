<?php namespace App\Models\cms;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Request;
use Hash;
use DB;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'username', 'password', 'email'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public static function createUser()
	{
		$user           = New User;
		$user->username = Request::get('username');
		$user->password = Hash::make(Request::get('password'));
		$user->save();
	}

	//Check the username 
	//Check if account is a regular user
	public static function checkIfThisUserExist($username)
	{
		return DB::table('users')
						->where('username', $username)
						->where('user_type', 'user')
						->first();
	} 

	//Add +1 Log in failed attemp
	public static function addOneLogInAttempt($username, $failed_login_attemp)
	{
		DB::table('users')
            	->where('username', $username)
            	->update(['failed_login_attemp' => $failed_login_attemp+1]);
	}

	//Check user status
	//Return user profile
	public static function checkUserStatus($username)
	{
		return DB::table('users')->where('username', $username)->first();
	}

	//Lock user Account
	public static function lockUserAccount($username)
	{
		DB::table('users')
	            	->where('username', $username)
	            	->update(['is_locked' =>1]);
	}

	//List all active system admin
	//Notify them when account has been disbaled
	public static function listAllAdminUsers()
	{
		return DB::table('users')
							->select('email')
							->where('user_type', 'admin')
							->where('is_active', 1)
							->get();
	}

	//Return Number of failed log in
	public static function logInAttempCtr($user_id)
	{
		return DB::table('users')->where('id', $user_id)->first()->failed_login_attemp;
	}

	//Add a flag that this user forgot his password
	//forgot_password Flag: use as backend notification
	public static function addForgotPasswordFlag($user_id)
	{
		DB::table('users')
            	->where('id', $user_id)
            	->update(['forgot_password' => 1]);
	}

	//Update Temporary Password
	public static function updateTemporaryPassword($user_id, $input)
	{
		//Set new password
		//Make the reset Password disable:0
		//Set reset password current timestamp
		DB::table('users')
	            	->where('id', $user_id)
	            	->update([
							'password'                 => Hash::make($input['new_password']),
							'reset_password'           => 0,
							'reset_password_timestamp' => \Carbon\Carbon::now()
	            			]);

	}

	//List all users that request for password reset
	public static function usersThatRequestForPasswordReset()
	{
		return DB::table('users')
							->select(DB::raw('first_name, last_name, username, profile_pic'))
							->where('forgot_password', 1)
							->get();
	}

	//Return list of user that
	//request for password reset
	public static function bellCounter()
	{
		return DB::table('users')
							->select(DB::raw('count(id)'))
							->where('forgot_password', 1)
							->count();
	}

}
