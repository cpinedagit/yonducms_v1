<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Media extends Model {
	protected $table = "content_media";
	protected $primaryKey = "media_id";

    public static function gallery(array $array)
    {
        $arView="";
        $results = DB::table('content_media')
                    ->whereIn('media_id', $array)->get();
            foreach ($results as $result) {

                if ($result->media_type == 1) {
                    $arView .= "<img src='../". $result->media_path  ."' style='height:100px;width:100px' alt = '".$result->alternative_text."'/>";
                } else {

                    $arView .= "<video width='320' height='240' controls>";
                    $arView .= "<source src='../". $result->media_path  ."' type='video/mp4'>";
                    $arView .= "<source src='../". $result->media_path  ."' type='video/ogg'>";
                    $arView .= "<source src='../". $result->media_path  ."' type='video/wmv'>";
                    $arView .= "  Your browser does not support the video tag.";
                    $arView .= "</video>";
                }
                     
            }            
        	return $arView;
    }

    public static function truncate()
    {
        return DB::table('content_media')->truncate();
    }	
}