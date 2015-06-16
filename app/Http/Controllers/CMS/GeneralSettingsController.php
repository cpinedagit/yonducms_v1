<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Storage;
use Session;
use Input;
use View;
use File;
use DateTimeZone;
use Redirect;

use App\Models\Banner;
use App\Models\Media;
use App\Models\Menu;
use App\Models\News;
use App\Models\Page;


class GeneralSettingsController extends Controller {

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
		$this->regenerateMenuSession('cms.general_settings.index', 'cms.general_settings.index');
		$env = file('.env'); 		//Open .env File input as Array
		Session::put('env', $env);		//Set it to an Session to be use later

		return view('cms.general_settings.index', compact('env'));
	}

	
	public function update($id)
	{

		//Loop into Session env and set new variables
		//Based on user inputs
		foreach (Session::get('env') as $key => $value) 
		{
			switch ($key) 
			{
				case 3:
					Session::put('env.3', 'APP_TITLE='.Input::get('APP_TITLE').PHP_EOL);
				break;
				case 4:
					Session::put('env.4', 'APP_TAG_LINE='.Input::get('APP_TAG_LINE').PHP_EOL);
				break;
				case 15:
					Session::put('env.15', 'MAIL_DRIVER='.Input::get('MAIL_DRIVER').PHP_EOL);
				break;
				case 16:
					Session::put('env.16', 'MAIL_HOST='.Input::get('MAIL_HOST').PHP_EOL);
				break;
				case 17:
					Session::put('env.17', 'MAIL_PORT='.Input::get('MAIL_PORT').PHP_EOL);
				break;
				case 18:
					Session::put('env.18', 'MAIL_USERNAME='.Input::get('MAIL_USERNAME').PHP_EOL);
				break;
				case 19:
					//If we have a new password
					if(Input::get('MAIL_PASSWORD_NEW')!='' && Input::get('MAIL_PASSWORD_NEW')!=' ') {
						Session::put('env.19', 'MAIL_PASSWORD='.Input::get('MAIL_PASSWORD_NEW').PHP_EOL);
					}
				break;
				case 21:
					Session::put('env.21', 'APP_RSS_FEED='.Input::get('APP_RSS_FEED').PHP_EOL);
				break;
				case 23:
					Session::put('env.23', 'APP_TIME_ZONE='.$this->getTimeZone(Input::get('APP_TIME_ZONE'), 'Identifier').PHP_EOL);
				break;
				case 25:
					Session::put('env.25', 'APP_MEDIA_FORMATS='.Input::get('APP_MEDIA_FORMATS').PHP_EOL);
				break;
				case 26:
					Session::put('env.26', 'APP_MEDIA_MAX_FILE_SIZE='.Input::get('APP_MEDIA_MAX_FILE_SIZE').PHP_EOL);
				break;
				case 28:
					Session::put('env.28', 'DAYS_BEFORE_PASSWORD_EXPIRES='.Input::get('DAYS_BEFORE_PASSWORD_EXPIRES').PHP_EOL);
				break;
				case 29:
					Session::put('env.29', 'DAYS_BEFORE_PASSWORD_NEEDS_TO_BE_CHANGE='.Input::get('DAYS_BEFORE_PASSWORD_NEEDS_TO_BE_CHANGE').PHP_EOL);
				break;
				case 32:
					$destinationPath = 'public/images/';		
					$file = Input::file('APP_LOGO');
					//If logo has been set
					if (Input::hasFile('APP_LOGO')){
					 	$filename           = $file->getClientOriginalName();	
					 	$file->move($destinationPath, $filename);

					 	Session::put('env.32', 'APP_LOGO='.$file->getClientOriginalName().PHP_EOL);
					}
				break;
				case 33:
					$destinationPath = 'public/images/';		
					$file = Input::file('APP_FAVICON');
					//If logo has been set
					if (Input::hasFile('APP_FAVICON')){
					 	$filename           = $file->getClientOriginalName();	
					 	$file->move($destinationPath, $filename);

					 	Session::put('env.33', 'APP_FAVICON='.$file->getClientOriginalName().PHP_EOL);
					}
				break;
				//APP_FAVICON
			}

		}

		//Write Session into .env file
		//Please check config/filesystems.php and check the root disk setting
		Storage::disk('root')->delete('.env'); 
		Storage::disk('root')->put('.env', Session::get('env'));

		//Message confirmation
		Session::flash('message', 'Settings saved.');

		//Redirect to gen setting 
		return redirect('cms/general_settings');
	
	}

	//Get TimeZone Code Based on Identifier
	public function getTimeZone($timeZone, $format)
	{
		//Remove Extra Spaces/New Line in $timeZone
		if($format=='index') 
			$timeZone = trim(preg_replace('/\s\s+/', ' ', $timeZone));
		//Get All Available timezone identifiers
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		
		//Check for each Identifier
		for ($i=0; $i<count($timezone_identifiers); $i++) {
	    	//Check in String
	    	if($format=='index'){
		    	if($timeZone==$timezone_identifiers[$i]){
		    		//Return If Index is being requested
		    		if($format=='index')
		    			return $i;
		    	}
		    }else{
		    //Check in index
		    	if($timeZone==$i){
		    		return $timezone_identifiers[$i];
		    	}
		    }
		}
	}

	public function truncateData()
	{
		Banner::truncate();
		Media::truncate();
		Menu::truncate();
		News::truncate();
		Page::truncate();

		return Redirect::route('cms.general_settings.index');
	}
}
