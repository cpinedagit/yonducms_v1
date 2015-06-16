<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\cms\User;
use App\Models\News;
use App\Models\Page;
use App\Models\Banner;
use View;
use Feeds;
use Session;

class CMSController extends Controller {

	public function __construct()
	{
		//Read the settings .env set app title and tag line
		View::share('APP_TITLE', env('APP_TITLE'));
		View::share('APP_TAG_LINE', env('APP_TAG_LINE'));

		//Bell notifications
        View::share('bell_counter', User::bellCounter());

		//$this->middleware('guest'); 	 //Doesn't require active user
		$this->middleware('is.allowed'); //Require require active user
	}

	public function index()
	{
		$this->regenerateMenuSession('cms.index', 'cms.index');
		//Get News Feeds When requesting for dashboard
		$data['news_feeds']      = $this->getNewsFeedsFromVendor();
		//Get all users that request for password reset
		$data['user_requests']   = User::usersThatRequestForPasswordReset();
		//Get News Summary
		$data['news_summary']    = News::getNewsSummary();
		//Get Page Summary
		$data['pages_summary']   = Page::getPageSummary();
		//Get Banner Summary
		$data['banners_summary'] = Banner::getBannerSummary();

		return view('cms.news_feeds.index')->withData($data);
	}


	public function getNewsFeedsFromVendor()
	{
		//Add .rss link
		$feed = Feeds::make(env('APP_RSS_FEED_VENDOR'));
	    $data = array(
	      'title'     => $feed->get_title(),
	      'permalink' => $feed->get_permalink(),
	      'items'     => $feed->get_items(),
	    );
	   
	    return $data;	
	}
}
