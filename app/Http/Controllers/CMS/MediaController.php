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
use App\Models\Media;
use HTML; 
use Image;
use Response;

class MediaController extends Controller {

  
  public function index() {
    $this->regenerateMenuSession('cms.media.index', 'cms.media.index');
    $all = DB::table('content_media')->count();
    $images = DB::table('content_media')
                     ->select(DB::raw('count(*) as c_img'))
                     ->where('media_type', '=', 1)
                     ->get();
    $videos = DB::table('content_media')
                     ->select(DB::raw('count(*) as c_vid'))
                     ->where('media_type', '=', 2)
                     ->get();
    $files = Media::All();
    return View::make('cms.media.index')->with(array('files'=>$files,'all'=>$all,'images'=>$images,'videos'=>$videos));
  }

  public function create() {
    $this->regenerateMenuSession('cms.media.index', 'cms.media.create');
     return View::make('cms.media.add');
  }

  public function show($id, $slug = '') {
      $file = Media::find($id);
      list($width, $height) = getimagesize($file->media_path);
      $file_name= after_last("/",$file->media_path);
      return View::make('cms.media.show')->with(array('file'=>$file,'filename'=>$file_name,'width'=>$width,'height'=>$height));
  
  }

  public function store()
  {

     $files = Input::file('fileselect');
      $file_count = count($files);
      $uploadcount = 0;
      foreach($files as $file) {
          $year = date("Y");
          $month = date("m");
          $imagesPath = 'uploads/image/'.$year.'/'.$month.'/';
          $videosPath = 'uploads/video/'.$year.'/'.$month.'/';
          $filename = $file->getClientOriginalName();
          $extension = $file->getClientOriginalExtension();
          $filePath = realpath($file);

          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mime=finfo_file($finfo, $filePath);
          if(strstr($mime, "video/")){
              $fileType= 2;
              $file->move($videosPath.'/'.$year.'/'.$month, $filename);
              $original_path = $videosPath.$filename;
          }else if(strstr($mime, "image/")){
              $fileType = 1;
              $file->move($imagesPath, $filename);
              $original_path = $imagesPath.$filename;
            /*  Image::make($file->getRealPath())
                ->save($imagesPath.$filename)
                ->fit('100', '100')
                ->save($imagesPath.'thumbnail-'.$filename)
                ->destroy(); */
          }
          //  $image = Image::make(url($destinationPath.'/'.$year.'/'.$month.'/'.$filename))->resize(300, 400)->save(public_path($original_path));
          $media = new Media;
          $media->media_path = $original_path;
          $media->media_type = $fileType;
          $media->save();
          $uploadcount ++;
        
      }
    }

  public function edit($slug) {
    

  }

  public function update($id) {

      $media = Media::find($id);
      $file = Input::file('file');
      $file_count = count($file);
      if($file_count > 0) {
          $imagesPath = 'uploads/image';
          $videosPath = 'uploads/video';
          $year = date("Y");
          $month = date("m");
          $filename = $file->getClientOriginalName();
          $extension = $file->getClientOriginalExtension();
          $filePath = realpath($file);

          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mime=finfo_file($finfo, $filePath);
          if(strstr($mime, "video/")){
              $fileType= 2;
              $file->move($videosPath.'/'.$year.'/'.$month, $filename);
              $original_path = $videosPath.'/'.$year.'/'.$month.'/'.$filename;
          }else if(strstr($mime, "image/")){
              $fileType = 1;
              $file->move($imagesPath.'/'.$year.'/'.$month, $filename);
              $original_path = $imagesPath.'/'.$year.'/'.$month.'/'.$filename;
          }
          $fileOld = $media->media_path;
          if (file_exists($fileOld)) {
           unlink($fileOld);
          }
          $media->media_path = $original_path;
          $media->media_type = $fileType;
        }
        else
        {
          $new_filename = Input::get('image_file_name');
          $old_filename = Input::get('image_file_name_orig');
          $path = before_last ('/',$media->media_path);
          $media->media_path = $path.'/'.$new_filename;
          rename($path.'/'.$old_filename,$path.'/'.$new_filename);
        }
          $media->caption= Input::get('caption');
          $media->description= Input::get('description');
          $media->alternative_text= Input::get('alternative_text');
          $media->save();

          if(Request::ajax()) {
          return Response::json(array($id));
        }
        Session::flash('message', 'Media saved.');
      return Redirect::to('cms/media');
  }

  public function destroy($id) {
        $media = Media::find($id);
        $filename = $media->media_path;
         if (file_exists($filename)) {
         unlink($filename);
         }
        $media->delete();
        Session::flash('message', 'Media deleted.');
        return Response::json(array($id));
    }

 public function gallery()
    {
        if(Request::ajax()) {
        $array = Request::get('selected');
        $results = DB::table('content_media')
                    ->whereIn('media_id', $array)->get();
        return Response::json(array($results));
    }
    } 

  public function getAll()
  {
    $files = Media::All();
     return Response::json(array($files));
  }

  public function getAllimage()
  {
    $files = DB::table('content_media')->where('media_type','=', '1' )->get();
    return Response::json(array($files));
  }

  public function deleteSelected() {
      $selected = Request::get('selected');
      foreach ($selected as $select) {
         $media = Media::find($select);
         $filename = $media->media_path;
         if (file_exists($filename)) {
         unlink($filename);
         }
         $media->delete();
       }
       Session::flash('message', 'Media deleted.');
      return Response::json(array($selected)); 
  }
}