<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Models\Page;
use App\Models\Menu;
use App\Models\Site\News;
use Input;
use DB;
use File;
use Request;
use Response;
use View;

class PageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $this->regenerateMenuSession('cms.pages.index', 'cms.pages.index');
        $pages = Page::all();
        $pagesCount = count($pages);
        $published = Page::getAllPublished();
        $publishedCount = count($published);
        $arData = array(
            'pages' => $pages,
            'pagesCount' => $pagesCount,
            'publishedCount' => $publishedCount
        );
        return View('cms/Pages/index', $arData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $content = Input::get('Editor1');
        $page = new Page;
        $page->content = $content;
        $page->title = Input::get('title');
        $slug = Input::get('slug');
        $page->slug = str_replace(array("/", ' '), "_", $slug);
        $page->parent_id = Input::get('parent');
        $publish = Input::get('publish');
        if (isset($publish)) {
            $page->status = 'Published';
        } else {
            $page->status = 'Unpublished';
        }
        $page->save();
        return redirect('cms/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    public function edit($id) {
        $this->regenerateMenuSession('cms.pages.index', 'cms.pages.index');
//        $banners = DB::table('banners')->get(array('banners.title', 'banners.id'));
//        $bannerId = DB::table('pages')
//                ->where('id', '=', $id)
//                ->pluck('banner');
//        $currentbanner = DB::table('banners')
//                ->where('id', '=', $bannerId)
//                ->pluck('title');
//        foreach ($banners as $banner) {
//            $arrays[] = (array) $banner;
//        }
        $pages = Page::edit($id);
        $banners = Page::getAllBanners();
        $getParentId = Page::where('id', '=', $id)->pluck('parent_id');
        $getAllPages = DB::table('pages')->whereNotIn('id', array($getParentId, $id))->get();
        $getParent = Page::where('id', '=', $getParentId)
                ->pluck('title');
        $arData = array(
            'pages' => $pages,
            'banners' => $banners,
            'getAllPages' => $getAllPages,
            'getParent' => $getParent,
            'getParentId' => $getParentId
        );
        return view('cms/Pages/edit', $arData);
    }

    public function preview($slug) {
        $pages = Page::preview($slug);
        if (count($pages) > 0) {
            
            
            $objMenu = Menu::ParentNavi();
            $content = str_replace("[", "<?php echo ", $pages->content);
            $content = str_replace("]", "?>", $content);
//            dd($content );
            $arData = array(
                'content' => $content,
                'pages' => $pages,
                'objMenu' => $objMenu
            );
            return view('site/Pages/index', $arData);
        } else {
            return view('site/Pages/404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        Page::updatePage($id);
        return redirect('cms/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
    }

    public function addPage() {
//        $banners = DB::table('banners')->get(array('banners.title', 'banners.id'));
        $this->regenerateMenuSession('cms.pages.index', 'cms.pages.addPage');
        $Pages = Page::all();
        $arData = array(
            'pages' => $Pages
        );
        return view('cms/Pages/add', $arData);
    }

    public function delPage() {
//        $selected = Request::get('selected');
//        foreach ($selected as $select) {
//            $fk_banner = DB::table('fk_banners')->where('id', '=', $select);
//            $fk_banner->delete();
//        }
//        return Response::json('ok');

        $checked = Request::get('checked');

        foreach ($checked as $che) {
            $page = Page::find($che);
            $page->delete();
        }
        return Response::json('ok');
    }

}
