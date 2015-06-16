<?php namespace App\Http\Controllers\Site;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Site\News;
use App\Models\Page;
use Request;
use DB;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use File;
use HTML; 
use Image;
use Response;
use App\Models\Menu;

class NewsController extends Controller {
	public function index() {
    $pages = Page::preview("news");
        if (count($pages) > 0) {
            
            
            $objMenu = Menu::ParentNavi();
            $content = str_replace("[", "<?php echo ", $pages->content);
            $content = str_replace("]", "?>", $content);
//            dd($content );
            $arData = array(
                'content' => $content,
                'pages' => $pages,
                'objMenu' => $objMenu
            );
            return view('site/Pages/index', $arData);
        } else {
            return view('site/Pages/404');
        }
     }

	public function show($id, $slug = '') {
    	$result = News::find($id);
    	$archive = News::archive();
      $imagesPath = 'uploads/news_image/';
    	return View::make('site.news.show')->with(array('result'=>$result,'archive'=>$archive,'imagesPath'=>$imagesPath));
	}

  public function preview($slug='', $slug2 = '') {
      $result = News::find($slug2);
      $imagesPath = 'uploads/news_image/';
      return View::make('site.news.show')->with(array('result'=>$result,'imagesPath'=>$imagesPath));
  }
}