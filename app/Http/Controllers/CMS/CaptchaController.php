<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\UserRequest;


class CaptchaController extends Controller {


	public function index()
	{
		//Return captcha Image 
		return response()->json(['captcha_img' => captcha_img('flat') ]);
	}

}
