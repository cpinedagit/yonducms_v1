<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model {

    protected $table = 'site_menus';
    protected $primaryKey = 'menu_id';

    public static function ParentNavi() {
        $parent = DB::table('site_menus as sm')
                        ->select('sm.menu_id', 'sm.page_id', 'sm.label', 'sm.parent_id', 'sm.page_id', 'sm.external_link', 'pg.slug')
                        ->leftJoin('pages as pg', 'sm.page_id', '=', 'pg.id')
                        ->where('sm.parent_id', 0)
                        ->orderBy('sm.order_id')->get();

        if (count($parent) > 0) {
            return $parent;
        }
    }

    public static function hasChild($menu_id) {

        $children = DB::table('site_menus as sm')
                        ->select('sm.menu_id', 'sm.page_id', 'sm.label', 'sm.parent_id', 'sm.page_id', 'sm.external_link', 'pg.slug')
                        ->leftJoin('pages as pg', 'sm.page_id', '=', 'pg.id')
                        ->where('sm.parent_id', $menu_id)
                        ->orderBy('sm.order_id')->get();

        if (count($children) > 0) {
            return $children;
        }
    }

    public static function truncate()
    {
        return DB::table('site_menus')->truncate();
    }


}
