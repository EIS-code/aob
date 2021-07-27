<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Trash extends Model
{
    public static function deletedfixfile($search=''){
        if(empty($search)){
			$data=DB::table(FIX_FILE_TABLE)->where([ ['is_delete','=',1],['final_delete','=',0] ])->orderByDesc('id')->get();
        }else{
        	$data=DB::table(FIX_FILE_TABLE)->where([ ['is_delete','=',1],['final_delete','=',0] ])->where(FIX_FILE_TABLE.'.name','LIKE','%'.$search.'%')->orderByDesc('id')->get();
        }

		return $data;
    }
    public static function deletedfile($search=''){
        if(empty($search)){
            $data=DB::table(FILE_TABLE)->where([ ['is_delete','=',1],['final_delete','=',0] ])->orderByDesc('id')->get();
        }else{
            $data=DB::table(FILE_TABLE)->where([ ['is_delete','=',1],['final_delete','=',0] ])->where(FILE_TABLE.'.name','LIKE','%'.$search.'%')->orderByDesc('id')->get();
        }

        return $data;
    }
    public static function deletedfolder($search=''){
        if(empty($search)){
			$data=DB::table(FOLDER_TABLE)->where([ ['is_delete','=',1],['final_delete','=',0] ])->orderByDesc('id')->get();
        }else{
        	$data=DB::table(FOLDER_TABLE)->where([ ['is_delete','=',1],['final_delete','=',0] ])->where(FOLDER_TABLE.'.name','LIKE','%'.$search.'%')->orderByDesc('id')->get();
        }

		return $data;
    }
}
