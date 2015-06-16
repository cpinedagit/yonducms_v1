<?php namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use View;
use App\Models\Page;

class News extends Model {
	protected $table = "content_news";
	protected $primaryKey = "slug";

    public static function list_all()
    {
            $results = News::All();
            return $results;
    }

    public static function archive()
    {
        $arrNews=[];
        $arrYear=[];

        $years= DB::SELECT(DB::raw("SELECT DISTINCT(YEAR(news_date)) AS year FROM content_news"));
            foreach ($years as $year) {
            $arrMonth=[];
            $months= DB::SELECT(DB::raw("SELECT DISTINCT(MONTHNAME(news_date)) as month,MONTH(news_date) as month_id FROM content_news where (YEAR(news_date)) = :_year"),array('_year'=>$year->year));
           
                foreach ($months as $month) {

                    $news= DB::SELECT(DB::raw("SELECT news_title,news_id,slug FROM content_news where (YEAR(news_date)) = :_year and (MONTH(news_date)) = :_month"),array('_year'=>$year->year, '_month'=>$month->month_id));
                        $arrMonth[$month->month]=$news; 
                }
                   $arrYear[$year->year]=$arrMonth;

            }

        return $arrYear;
    }

    public static function featured()
    {
        $arrfeatured = DB::table('content_news')->where(array('featured'=>'1'))->get();
        return $arrfeatured;
    }

    public static function show_news($id)
    {
        $result = DB::table('content_news')
            ->leftJoin('content_media', 'content_media.media_id', '=', 'content_news.photo_id')
            ->select('content_news.*', 'content_media.media_path')
            ->where(array('content_news.slug'=>$slug))
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
    public static function viewAll()
    {
        $imagesPath = 'uploads/news_image/';
        $results = News::All();
        $archive = News::archive();
        return View::make('site.news.index')->with(array('results'=>$results,'archive'=>$archive,'imagesPath'=>$imagesPath));

    }
}

