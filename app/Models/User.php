<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Hash;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table = 'users';

	protected $fillable = ['username', 'first_name', 'last_name', 'email', 'password', 'slug'];

	protected $hidden = ['password', 'remember_token'];
	
	public static function getAllUsers()
	{
		return DB::table('users')
				->where('is_active', '=', 1)
				->get(['id', 'username', 'first_name',
						'last_name', 'email', 'role_id', 'is_active']);
	}

	public static function getUserPerRoleCount()
	{
		return DB::table('users')
				->groupBy('role_id')
				->select(DB::raw('count(*) as c_user'), 'role_id')
				->get();
	}

	public static function getUsername($username)
	{
		return DB::table('users')
				->where('username', '=', $username)
				->select(DB::raw('count(*) as c_user'))
				->get();
	}
}
