<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Editor;
use File;
use Response;
use Input;
use Request;
use Cache;

class EditorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $this->regenerateMenuSession('cms.editor.index', 'cms.editor.index');
        $parents = Editor::getAllParent();

        $arData = array(
            'parents' => $parents
        );
        return View('cms.Editors.index', $arData);
    }

    public function folder() {
        return 'test';
    }

    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function Show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    //Read requested file
    public function readFile()
    {
      $file_dir = file(Input::get('file_dir'));
      return Response::json($file_dir);
    }

    public function updateFile() {
        //file path
        $file = Input::get('hidden');
        $content = Input::get('content');
        unlink($file);
        
        if (file_put_contents($file, $content, FILE_APPEND)) {
           return Response::json('ok');
        }else{
            return Response::json('not ok');
        }
    }

    public function addFile() {
        //dd(Input::hasFile('file'));
//        
//        $file= Input::file('file');
//        dd($file->getClientOriginalName());

        $file = Input::file('file');
        $path = Input::get('path');
       
        if ($file) {
            $filename = $file->getClientOriginalName();
//            $extension = $file->getClientOriginalExtension();            
//            if ($extension == 'js') {
//                $file->move('public/site/js', $filename);
//            } elseif ($extension == 'css') {
//                $file->move('public/site/css', $filename);
//            } else {
//                $file->move('resources/views/site', $filename);
//            }
            $file->move($path, $filename);
            return redirect('cms/editor');
        } else {
            return redirect('cms/editor');
        }
    }

    public function addFolder() {
        $name = Input::get('foldername');
        $path = Input::get('path');
        $parent = Input::get('parent');
        $editor = new Editor;
        $editor->name = $name;
        $editor->path = $path . '/' . $name;
        $editor->parent_id = $parent;
        $editor->save();
        $result = File::makeDirectory($path . '/' . $name);
        return Response::json('ok');
    }

}
