<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Input;
use Cache;
use Response;
use DB;

class ImageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $images = Image::all();

        $arData = array(
            'images' => $images
        );
        return view('cms/Images/index', $arData);
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
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $filename = $file->getClientOriginalName();
            $file->move('../public/images', $filename);
        }

        $images = new Image;
        $images->name = Input::get('name');

        if (isset($filename))
            $images->image = $filename;
        $images->save();
        return redirect('cms/image');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $images = Image::edit($id);
        $arData = array(
            'images' => $images
        );
        return view('cms/Images/edit', $arData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {    
        Image::updateImage($id);
        return redirect('cms/image');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        $fk_banner = DB::table('fk_banners')->where('image_id', '=', $id);
        if (count($fk_banner) > 0) {
            $fk_banner->delete();
        }


        Image::destroy($id);
        $image = Image::all();
        return Response::json(array($image));
    }

    public function addImage() {
        return View('cms/Images.add');
    }

    public function frontEnd() {
        $images = Image::all()->orderBy('order', 'asc');
        $arData = array(
            'images' => $images
        );
        return View('cms/Images.frontend', $arData);
    }

}
