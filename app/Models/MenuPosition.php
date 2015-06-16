<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MenuPosition  extends Model {
    
    protected $table = 'site_menu_position';

    public static function menuPositions() {
        $objMenuPosi = DB::table('site_menu_position')->select('id', 'position', 'is_selected')->get();

        if (count($objMenuPosi) > 0) {
            return $objMenuPosi;
        }
    }

    public static function menuSelectedPosition() {
        $objMenuPosiSelected = DB::table('site_menu_position')->select('position')->where('is_selected', '=', 1)->get();

        if (count($objMenuPosiSelected) > 0) {
            return $objMenuPosiSelected;
        }
    }

}
