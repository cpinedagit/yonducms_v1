<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;


class Editor extends Model {

    protected $table = 'editors';
    public $timestamps = false;

    public static function getParentFolder() {
        return DB::table('editors')->where('parent_id','=',0)->get();
    }

    public static function getChildFolder($id){
        return DB::table('editors')->where('parent_id','=',$id)->get();
    }
    
    public static function getAllParent(){
        return DB::table('editors')->where('parent_id','=','0')->get();
    }

}
