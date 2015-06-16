<?php

/**
 * Cms Menu Management
 * Yondu Web Service
 * Author: Allan Perez
 */

namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Models\MenuPosition;
use App\Models\Page;
use App\Models\CMS\User;
use Input;
use View;
use DB;
use Illuminate\Database\Query\Builder;
use Request;
use Response;

class CmsMenuController extends Controller {

    //
    public $html = '';
    public $arrData = [];

    public function __construct() {
        //Read the settings .env set app title and tag line
        View::share('APP_TITLE', env('APP_TITLE'));
        View::share('APP_TAG_LINE', env('APP_TAG_LINE'));
        View::share('bell_counter', User::bellCounter());
        //$this->middleware('guest');    //Doesn't require active user
        $this->middleware('is.allowed'); //Require require active user
    }

    function index() {
        $this->regenerateMenuSession('cms.menu.index', 'cms.menu.index');
        $objMenu = Menu::ParentNavi();
        $objPage = Page::all();
        $objMenuPosition = MenuPosition::menuPositions();
        $objData = [
            'objMenu' => $objMenu,
            'objPage' => $objPage,
            'objMenuPosition' => $objMenuPosition,
        ];
        return view('cms.menu.index', $objData);
    }

    // do edit menu label and external url
    function updateLabelMenu() {
        $id = Input::get('menu_id');
        $label = Input::get('menu_label');
        $menu_link = Input::get('menu-link');

        $menu_name_update = Menu::find($id);
        $menu_name_update->label = $label;
        // if external link, do edit for external_link field. if not, do edit in page management
        if ($menu_name_update->page_id == 0) {
            $menu_name_update->external_link = $menu_link;
        }
        $menu_name_update->save();
    }

    // updates the structure of menu
    function updatemenu() {

        $arrJson = Input::get('nestable-output');
        $arrData = json_decode($arrJson, TRUE);
        foreach ($arrData as $key => $value) {
            foreach ($value as $key1 => $value1) {
                if (($key1 == 1)) {
                    if ($value[1] === null) {
                        $parent_id = 0;
                    } else {
                        $parent_id = $value[1];
                    }
                    // for setting parent
                    $menusave = Menu::find($value[0]);
                    $menusave->parent_id = $parent_id;
                    $menusave->save();
                }
                if (($key1 == 2)) {
                    // for order id
                    $menusave = Menu::find($value[0]);
                    $menusave->order_id = $value[2];
                    $menusave->save();
                }
            }
        }
    }

    // menu add from page table
    function addPagetoMenu(Menu $page_menu) {
        if (Request::ajax()) {
            $page_menu->label = Request::get('label');
            $page_menu->parent_id = 0;
            $page_menu->page_id = Request::get('page_id');
            $page_menu->order_id = Request::get('order_id');
            if ($page_menu->save()) {
                return Response::json(array('last_id' => $page_menu->menu_id));
            }
        }
    }

    // external link add to menu management table
    function addLinktoMenu(Menu $link_menu) {
        if (Request::ajax()) {
            $link_menu->label = Request::get('label');
            $link_menu->parent_id = 0;
            $link_menu->page_id = 0;
            $link_menu->external_link = Request::get('external_link');
            $link_menu->order_id = Request::get('order_id');
            if ($link_menu->save()) {
                return Response::json(array('last_id' => $link_menu->menu_id));
            }
        }
    }

    // update selected position id
    function setMenuPosition(MenuPosition $menuPosition) {
        if (Request::ajax()) {
            $newMenupositionSelecttoZero = $menuPosition->where('is_selected', '=', 1)->first();
            $newMenupositionSelecttoZero->is_selected = 0;
            $newMenupositionSelecttoZero->save();

            $menuPosId = Request::get('idpos');
            $newMenupositionSelect = $menuPosition->find($menuPosId);
            $newMenupositionSelect->is_selected = 1;
            $newMenupositionSelect->save();
        }
    }

    // search function for page table
    function listPageSearch(Page $pages) {
        if (Request::ajax()) {
            $key = Request::get('keyword');
            $conKey = ($key === '') ? '%%' : '%'. $key . '%';  
            $objPage = $pages::where('title', 'like', $conKey)->get();
            
            foreach ($objPage as $valPage) {
                $objArr[] = array('id' => $valPage->id, 'title' => $valPage->title, 'slug' => $valPage->slug);
            }
            return Response::json($objArr);
        }
    }

    // we use "deleteMenu" word than resource destroy method to avoid ajax conflict
    function deleteMenu(Menu $menu) {
        $id = Request::get('del_id');
        $menu_parent = Menu::find($id);
        if ($menu_parent->delete()) {

            // $menu_child = Menu::where('parent_id', '=', $id);
            $menu_child = $menu->where('parent_id', '=', $id)->get();
            foreach ($menu_child as $id_child) {
                $this->deleteChildMenu($id_child->menu_id);
            }
        }
    }

    // child function for "deleteMenu" fucntion, if deleted parent has child to be deleted also
    function deleteChildMenu($id) {
        $menu_parent = Menu::find($id);
        if ($menu_parent->delete()) {
            $menu_child = DB::table('site_menus')->where('parent_id', '=', $id)->get();
            foreach ($menu_child as $id_child) {
                $this->deleteChildMenu($id_child->menu_id);
            }
        }
    }

}
