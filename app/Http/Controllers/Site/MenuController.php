<?php

namespace App\Http\Controllers\Site;

/*
 * Menu Management - YWS
 * Author: Allan C. Perez <aperez@yondu.com>
 * April 28, 2015
 * 
 */

use App\Http\Controllers\MainController;
use App\Http\Controllers\CmsMenuController;
use App\Models\Menu;
use DB;

class MenuController extends MainController {

    public $menu = '';
    function __construct() {
        
    }

    public function index() {
        $objMenu = DB::table('content_json')->where('page_id', 1)->get();

        foreach ($objMenu as $obj) {
            $objMenudc = json_decode($obj->page_content, true);
        }
        $siteMenu = $this->decodeRecurse($objMenudc);
        return view('site.index')->with('siteMenu', $siteMenu);
    }

    function decodeRecurse($arrMenu) {
        // dto na me
        foreach ($arrMenu as $key => $value) {
            if (is_array($value)) {

                if ($key === 'children') {

                    $this->menu .= "<ul class='dropdown-menu'>";
                }

                $this->decodeRecurse($value);

                if ($key === 'children') {

                    $this->menu .= "</ul>";
                }
            } else {

                if ($arrMenu['id'] === $value) {
                    
                     $this->menu .= "<li class='dropdown'>";

                    $this->menu .= "<a class='dropdown-toggle' data-toggle='dropdown'>" . $arrMenu['menu'] . "</a>";
                }
            }
        }
        $this->menu .= "</li>";
        return $this->menu;
    }

}
