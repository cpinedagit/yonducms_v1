<?php namespace App\Http\Requests\CMS;

use App\Http\Requests\Request;

class UserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'username' => 'required|max:25|min:6',
			'firstname' => 'required|max:255|min:2',
			'lastname' => 'required|max:255|min:2',
			'email' => 'required|max:255',			
			'password' => 'required|max:25|min:8',
			'passwordconfirm' => 'required|max:25|min:8'
		];
	}

}
