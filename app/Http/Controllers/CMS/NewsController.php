<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use File;
use App\Models\News;
use HTML; 
use Image;
use Response;

class NewsController extends Controller {

  
  public function index() {
    $this->regenerateMenuSession('cms.news.index', 'cms.news.index');
    $all = DB::table('content_news')->count();
    $published = DB::table('content_news')
                     ->select(DB::raw('count(*) as c_pub'))
                     ->where('published', '=', 1)
                     ->get();
    $featured = DB::table('content_news')
                     ->select(DB::raw('count(*) as c_fea'))
                     ->where('featured', '=', 1)
                     ->get();

    $results = News::All();
    return View::make('cms.news.index')->with(array('results'=>$results,'all'=>$all,'published'=>$published,'featured'=>$featured));
  }


  public function create() {
    $this->regenerateMenuSession('cms.news.index', 'cms.news.create');
     return View::make('cms.news.add');
  }

  public function show($id, $slug = '') {
      $result = News::find($id);
      $imagesPath = 'uploads/news_image/';
      return View::make('cms.news.show')->with(array('result'=>$result,'imagePath'=>$imagesPath));
  
  }

  public function store()
  {
      $file = Input::file('file');
      $filename = $file->getClientOriginalName();
   //   $file->move('uploads/news_image/', $filename);
      $imagesPath = 'uploads/news_image/';
       Image::make($file->getRealPath())
                ->save($imagesPath.$filename)
                ->fit('150', '150')
                ->save($imagesPath.'thumbnail-'.$filename)
                ->destroy();

      $news = new News;
      $news->news_title = Input::get('news_title');
      $news->news_content = Input::get('news_content');
      $news->news_date = date("Y-m-d",strtotime(Input::get('news_date')));
      $news->description = Input::get('description');
      $news->published = Input::get('published');
      $news->featured = Input::get('featured');
      $slug = str_replace(array(' ','/'), '_', Input::get('news_title'));
      $news->slug = $slug;
      $news->image_filename = $filename;

      $news->save();
          Session::flash('message', 'News saved.');
      return Redirect::to('cms/news');
    }

  public function edit($slug) {
    

  }

  public function update($id) {

      $news = News::find($id);
      $file = Input::file('file');
      $file_count = count($file);
      if($file_count > 0) {
      $filename = $file->getClientOriginalName();
     // $file->move('uploads/news_image/', $filename);
     // $original_path = 'uploads/news_image/'.$filename;
       $imagesPath = 'uploads/news_image/';
       Image::make($file->getRealPath())
                ->save($imagesPath.$filename)
                ->fit('150', '150')
                ->save($imagesPath.'thumbnail-'.$filename)
                ->destroy();
      $news->image_filename = $filename;
      }
      $news->news_title = Input::get('news_title');
      $news->news_content = Input::get('news_content');
      $news->news_date = date("Y-m-d",strtotime(Input::get('news_date')));
      $news->description = Input::get('description');
      $news->published = Input::get('published');
      $news->featured = Input::get('featured');
      $slug = str_replace(array(' ','/'), '_', Input::get('slug'));
      $news->slug = $slug;
      $news->save();
      Session::flash('message', 'News updated.');
      return Redirect::to('cms/news');
  }

  public function destroy($id) {
      $imagesPath = 'uploads/news_image/';
      $news = News::find($id);
      $filename = $imagesPath.$news->image_filename;
      $filename2 = $imagesPath.'thumbnail-'.$news->image_filename;
         if (file_exists($filename)) {
         unlink($filename);
         }
         if (file_exists($filename2)) {
         unlink($filename2);
         }
      $news->delete();
      Session::flash('message', 'News deleted.');
      return Response::json(array($id)); 
    }

  public function deleteSelected() {
      $imagesPath = 'uploads/news_image/';
      $selected = Request::get('selected');
      foreach ($selected as $select) {
         $news = News::find($select);
         $filename = $imagesPath.$news->image_filename;
         $filename2 = $imagesPath.'thumbnail-'.$news->image_filename;
         if (file_exists($filename)) {
         unlink($filename);
         }
         if (file_exists($filename2)) {
         unlink($filename2);
         }

         $news->delete();
       }
       Session::flash('message', 'News deleted.');
      return Response::json(array($selected)); 
  }
}