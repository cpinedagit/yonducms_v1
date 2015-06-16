<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
Use Feeds;
use View;

class NewsFeedsController extends Controller {

	public function __construct()
	{
		//Read the settings .env set app title and tag line
		View::share('APP_TITLE', env('APP_TITLE'));
		View::share('APP_TAG_LINE', env('APP_TAG_LINE'));

		$this->middleware('guest'); 	  //Doesn't require active user
		//$this->middleware('is.allowed'); //Require require active user
	}

	public function index()
	{
		//Add .rss link
		$feed = Feeds::make(env('APP_RSS_FEED'));
	    $data = array(
	      'title'     => $feed->get_title(),
	      'permalink' => $feed->get_permalink(),
	      'items'     => $feed->get_items(),
	    );
	   
	    return View('cms.news_feeds.index')->withData($data);	
	}

}
