<?php namespace App\Http\Controllers;

class MainController extends Controller {

	protected $data = array();

	public function __construct()
	{
		$this->middleware('guest');
		
	}

	public function index()
	{
		return view('main');
	}

	
}