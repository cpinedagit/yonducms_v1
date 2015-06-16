<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input;
use DB;
use Request;

class MyCollection2 extends \Illuminate\Database\Eloquent\Collection {

    public function orderBy($attribute, $order = 'asc') {
        $this->sortBy(function($model) use ($attribute) {
            return $model->{$attribute};
        });

        if ($order == 'desc') {
            $this->items = array_reverse($this->items);
        }

        return $this;
    }

}

class Banner extends Model {

    protected $table = 'banners';

    public function newCollection(array $models = array()) {
        return new MyCollection2($models);
    }

    public static function edit($id) {
        return Banner::find($id);
    }

    public static function getImages($id) {
        return DB::table('banners')
                        ->leftJoin('fk_banners', 'fk_banners.banner_id', '=', 'banners.id')
                        ->leftJoin('content_media', 'content_media.media_id', '=', 'fk_banners.image_id')
                        ->where('banners.id', '=', $id)
                        ->get(array(
                            'content_media.media_path',
                            'content_media.media_id',
                            'fk_banners.image_name',
                            'fk_banners.image_description',
                            'fk_banners.id'
        ));
    }

    public static function saveImage() {
        if (Request::get('selected')) {
            $id = Request::get('id');
            $selected = Request::get('selected');
            foreach ($selected as $select) {
                DB::table('fk_banners')->insertGetId(
                        array(
                            'banner_id' => $id,
                            'image_id' => $select)
                );
            }
        }
    }

    public static function updateBanner($id) {
        $type = Input::get('type');
        $banner = Banner::find($id);
        $curType = Input::get('curType');
        if ($type === null) {
            $banner->type = Input::get('curType');
        } else {
            $banner->type = Input::get('type');
        }
        if ($type === 'Standard' || $curType === 'Standard') {
            $banner->animation = Input::get('defaultAnimation');
        } else {
            $banner->animation = Input::get('stTransition');
        }
        $banner->animationTitle = Input::get('animationTitle');
        $banner->title = Input::get('name');
        $banner->save();
    }

    public static function myBanner($id) {
        $banner = DB::table('banners')
                ->leftJoin('fk_banners', 'fk_banners.banner_id', '=', 'banners.id')
                ->leftJoin('content_media', 'content_media.media_id', '=', 'fk_banners.image_id')
                ->where('banners.id', '=', $id)
                ->get(array('content_media.media_path', 'content_media.media_id'));
        return $banner;
    }

    public static function getBannerType($id) {
        return $banner = DB::table('banners')
                ->where('id', '=', $id)
                ->pluck('type');
    }

    public static function getClass($id) {
        return Banner::find($id)->pluck('classes');
    }

    public static function getAllMainBanner() {
        return DB::table('banners')->where('title', '=', 'Main Banner')->get();
    }

    public static function getAllSubBanner() {
        return DB::table('banners')->where('title', '=', 'Sub Banner')->get();
    }

    public static function getCode($id) {
        return DB::table('banners')->where('id', '=', $id)->pluck('animation');
    }
    
    // Get Page Summary output it on dashboard
    public static function getBannerSummary()
    {
        $data['all_banners']  = DB::table('banners')->count();
        $data['advanced'] = DB::table('banners')
                           ->select(DB::raw('count(id) as advanced'))
                           ->where('type', '=', 'Advanced')
                           ->count();
        return $data;
    }
    
        public static function getAnimationTitle($id) {
        return DB::table('banners')->where('id', '=', $id)->pluck('animationTitle');
    }

    public static function truncate()
    {
        $deleted = DB::table('fk_banners')->truncate();
        if($deleted) {
            return DB::table('banners')->truncate();
        }
    }
}
