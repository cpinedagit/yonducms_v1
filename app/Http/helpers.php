<?php

function gallery(array $arr) {
    return \App\Models\Media::gallery($arr);
}

function modules() {
    return \App\Models\Module::getActiveModules();
}

function submenus() {
    return \App\Models\SubMenu::getActiveSubMenus();
}

function accesses($id) {
    return \App\Models\Access::getAccessFor($id);
}

function subaccesses($id) {
    return \App\Models\SubAccess::getSubAccessFor($id);
}

function roles() {
    return \App\Models\Role::getActiveRoles();
}

function siteIndex() {
    
}

function after_last($str, $inthat) {
    if (!is_bool(strrevpos($inthat, $str)))
        return substr($inthat, strrevpos($inthat, $str) + strlen($str));
}

function before_last($this, $inthat) {
    return substr($inthat, 0, strrevpos($inthat, $this));
}

function strrevpos($instr, $needle) {
    $rev_pos = strpos(strrev($instr), strrev($needle));
    if ($rev_pos === false)
        return false;
    else
        return strlen($instr) - $rev_pos - strlen($needle);
}

function news_archive() {
    $slug = Request::segment(2);
    $archive = \App\Models\Site\News::archive();
    return View('site.news.archive_news')->with(array('slug' => $slug, 'archive' => $archive))->render();
}

function featured_news() {
    $slug = Request::segment(2);
    $featured = \App\Models\Site\News::featured();
    return View('site.news.featured_news')->with(array('slug' => $slug, 'featured_news' => $featured))->render();
}

function news_list() {
    $slug = Request::segment(2);
    $imagesPath = 'uploads/news_image/';
    $results = \App\Models\Site\News::list_all();
    return View('site.news.index')->with(array('slug' => $slug, 'results' => $results, 'imagesPath' => $imagesPath))->render();
}

// start line for menu management
// menu management (admin)
function getSubMenu($arrVal, $htmlmenu = '') {
    if (count($arrVal) > 0) {
        $menuArrObj = \App\Models\Menu::hasChild($arrVal);
        if ($menuArrObj) {
            $htmlmenu .= '<ol class = "dd-list">';
            foreach ($menuArrObj as $objChildMenu) {
                $urllink = $objChildMenu->slug ? $objChildMenu->slug : $objChildMenu->external_link;
                $pageOrlink = ($objChildMenu->page_id == 0) ? 'external' : 'slug';

                $htmlmenu .= '<li id="idli_' . $objChildMenu->menu_id . '" class = "dd-item" data-menu_id = "' . $objChildMenu->menu_id . '" data-page_id ="' . $objChildMenu->page_id . '" data-parent_id ="' . $objChildMenu->parent_id . '" data-label ="' . $objChildMenu->label . '"  data-url="' . $urllink . '" data-url_origin="' . $pageOrlink . '"><div class = "dd-handle"  id="target_' . $objChildMenu->menu_id . '" }}">' . $objChildMenu->label . '</div><button class="circle btn--remove-menu delete-item" onclick="delThis(' .
                        $objChildMenu->menu_id
                        . ')"></button>';
                $htmlmenu .= getSubMenu($objChildMenu->menu_id);
                $htmlmenu .= '</li>';
            }
            $htmlmenu .= '</ol>';
        }
        return $htmlmenu;
    }
}

// if you love to change CSS/HTML of the navigation, do it here 
function getSubMenuSite($arrVal, $htmlmenu = '') {
    if (count($arrVal) > 0) {
        $menuArrObj = \App\Models\Menu::hasChild($arrVal);
        if ($menuArrObj) {
            $htmlmenu .= '<ul class="dropdown-menu">';
            foreach ($menuArrObj as $objChildMenu) {
                $menulink = $objChildMenu->slug ? $objChildMenu->slug : $objChildMenu->external_link;
                $htmlmenu .= '<li><a href = "' . $menulink . '"><span class = "link-title">' . $objChildMenu->label . '</span>';
                $htmlmenu .= parentCssElement($objChildMenu->menu_id, 'caret');
                $htmlmenu .= '</a>';

                $htmlmenu .= getSubMenuSite($objChildMenu->menu_id);
                $htmlmenu .= '</li>';
            }
            $htmlmenu .= '</ul>';
        }
        return $htmlmenu;
    }
}

// call css design for parent
function parentCssElement($arrVal, $element) {
    $menuArrObj = \App\Models\Menu::hasChild($arrVal);
    if ($menuArrObj) {
        switch ($element) {
            case 'caret':
                return '<b class="caret"></b>';
                break;
            case 'dropdown':
                return 'class= "dropdown"';
                break;
        }
    }
}

function menuLayout() {
    $menuPositionCurrentSelect = \App\Models\MenuPosition::menuSelectedPosition();

    if ($menuPositionCurrentSelect) {
        foreach ($menuPositionCurrentSelect as $key) {
            return $key->position;
        }
    } else {
        return 'top';
    }
}

// end here for menu


function banner($id) {

    $objBanner = \App\Models\Banner::myBanner($id);
    $code = \App\Models\Banner::getCode($id);
    $json = json_encode($code);
    $banner = "";
    if ($objBanner !== null) {
        $banner .= HTML::script('public/slide/js/jssor.slider.min.js');
        $banner .= HTML::script('public/slide/js/jssor.js');
        $banner .= HTML::style('public/slide/css/arrow.css');
        $banner .= HTML::script('public/slide/js/slideshow-transition-builder-controller.min.js');
        $banner .= "<div style='position: relative; width: 800px; height: 500px;margin-left:100px;' id='slider1_container'>
                    <div u = 'loading' style = 'position: absolute; top: 0px; left: 0px;'>
                    <div style='filter: alpha(opacity=70); opacity:.7; position: absolute; display: block; background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;'></div>
                    <div style = 'position: absolute; display: block; background: url(../public/slide/img/loading.gif) no-repeat center center;top: 0px; left: 0px;width: 100%;height:100%;'></div>
                    </div>
                    <div u = 'slides' style = 'cursor: move; position: absolute; width: 900px; height: 400px;top:0px;left:0px;overflow:hidden;'>
                    


";

        foreach ($objBanner as $obj) {
            $banner .= "<div>";
            $banner .= HTML::image($obj->media_path, null, ['style' => 'width:900px;height:400px;']);
            $banner .= "</div>";
        }
        $banner .= "</div>";
        $banner .= "</div>";
        $banner .= "<select id = 'ssTransition' style = 'width: 833px; height: 25px;visibility:hidden' name = 'ssTransition'></select>";
        $banner .= "<button id = 'sButtonPlay' style = 'width: 833px; height: 25px;visibility:hidden' name = 'sButtonPlay'></button>";
        $banner .= "<input id = 'stTransition' type = 'hidden' style = 'width: 833px; height: 25px;' name = 'stTransition'>";
        $banner .= "<script>code = $json; </script> ";
        $banner .= HTML::script('public/slide/mySlide.js');
    }
    return $banner;
}

/*Get Bell Notification*/
function bellCounter() {
    return \App\Models\cms\User::bellCounter();
}

function children($id)
{
    return \App\Models\Editor::getChildFolder($id);
}
/*Get Bell Notification*/


// List of users that request for password reset
function notification_lists()
{
    return $users = \App\Models\cms\User::usersThatRequestForPasswordReset();
}
// List of users that request for password reset

/*Check if user can access the module*/
function checkAccess($module_id)
{
    //Get user role
    $role_id = \Auth()->user()->role_id;
    //Check if user has an access
    return \App\Models\Access::checkAccess($role_id, $module_id);   
}
/*Check if user can access the module*/
