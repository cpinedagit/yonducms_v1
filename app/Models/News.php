<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class News extends Model {
	protected $table = "content_news";
	protected $primaryKey = "news_id";

    public static function show_news($id)
    {
        $result = DB::table('content_news')
            ->leftJoin('content_media', 'content_media.media_id', '=', 'content_news.photo_id')
            ->select('content_news.*', 'content_media.media_path')
            ->where(array('content_news.news_id'=>$id))
            ->get();
            return $result;
    }
    public static function all_news()
    {
        $result = DB::table('content_news')
            ->leftJoin('content_media', 'content_media.media_id', '=', 'content_news.photo_id')
            ->select('content_news.*', 'content_media.media_path')
            ->get();
            return $result;
    }

    // Get News Summary output it on dashboard
    public static function getNewsSummary()
    {
        $data['all_news']  = DB::table('content_news')->count();
        $data['published'] = DB::table('content_news')
                           ->select(DB::raw('count(published) as published'))
                           ->where('published', '=', 1)
                           ->count();
   
        $data['featured']  = DB::table('content_news')
                           ->select(DB::raw('count(`featured`) as featured'))
                           ->where('featured', '=', 1)
                           ->count();
        return $data;
    }

    public static function truncate()
    {
        return DB::table('content_news')->truncate();
    }
}

