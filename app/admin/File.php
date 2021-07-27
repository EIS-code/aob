<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class File extends Model
{
    protected $guarded = [];

    public static function getFixRecordByFileName($name){
      $data=DB::table(FIX_FILE_TABLE)->where([ ['name','=',$name],['is_delete','=',0] ])->first();
      return $data;
    }
    public static function getfixfilecountbyfolder($fixfolder){
      $data=DB::table(FIX_FILE_TABLE)->where([ ['is_delete','=',0],['folder_id','=',$fixfolder] ])->get();
      return count($data);
    }
    public static function getfixfilecount(){
      $data=DB::table(FIX_FILE_TABLE)->where([ ['is_delete','=',0] ])->get();
      return count($data);
    }
    public static function getfilecountbyfolder($folder){
        $data=DB::table(FILE_TABLE)->where([ ['is_delete','=',0],['folder_id','=',$folder] ])->get();
        $count = 0;
		if(!empty($data)) {
			foreach($data as $key => $file) {
				if (file_exists( public_path() . '/document/' . $file->name .'.'. $file->ext)) {
					$count++;
				}
			}
		}
     	return $count;
    }
    public static function getRecordByFileName($name){
  		$data=DB::table(FILE_TABLE)->where([ ['name','=',$name],['is_delete','=',0],['filetype','=','normal'] ])->first();
  		return $data;
    }
    public static function addUpdateFixRecord($data,$id){
      if($id!=0){
        $updated=DB::table(FIX_FILE_TABLE)->where('id',$id)->update($data);
      }else{
        $updated=DB::table(FIX_FILE_TABLE)->insert($data);
      }
      if($updated){
        return true;
      }else{
        return false;
      }
    }
    public static function addUpdateRecord($data,$id){
    	if($id!=0){
   			$updated=DB::table(FILE_TABLE)->where('id',$id)->update($data);
    	}else{
   			$updated=DB::table(FILE_TABLE)->insert($data);
    	}
  		if($updated){
  			return true;
  		}else{
  			return false;
  		}
    }
    public static function getRecentFile($search=''){
      if($search==''){
        $data = DB::select('select * from '.FILE_TABLE.' where is_delete=0 AND filetype = "normal" order by id desc limit 0,10');
      }else{
        $data = DB::select('select * from '.FILE_TABLE.' where is_delete=0 AND filetype = "normal" AND name like "%'.$search.'%" order by id desc limit 0,10');
      }
      return $data;
    }
    public static function getTotalReportFile($search=''){
        if(empty($search)){
          $sql='select * from '.FILE_TABLE.' where is_delete=0 AND filetype = "report" order by id desc';
        }else{
          $sql='select * from '.FILE_TABLE.' where is_delete=0 AND filetype = "report" AND name LIKE "%'.$search.'%" order by id desc';
        }
      $data = DB::select($sql);
      return $data;
    }
    public static function getFixRecordById($id){
      $data=DB::table(FIX_FILE_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->first();
      return $data;
    }
    public static function getRecordById($id){
      $data=DB::table(FILE_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->first();
      return $data;
    }
    public static function getTotalImageFile(){
      $ext = implode('","', IMAGE_VALID_EXT);
      $data1 = DB::select('select * from '.FILE_TABLE.' join '.FOLDER_TABLE.' on files.folder_id = folders.id where '.FILE_TABLE.'.is_delete=0 AND folders.is_delete=0 AND '.FILE_TABLE.'.filetype = "normal" AND '.FILE_TABLE.'.ext IN ("'.$ext.'")');
      $data3 = DB::select('select * from '.FIX_FILE_TABLE.' where is_delete=0 AND folder_id=0 AND ext IN ("'.$ext.'")');
      $data2 = DB::select('select * from '.FIX_FILE_TABLE.' join fixfolders on fixfolderfiles.folder_id=fixfolders.id where fixfolderfiles.is_delete=0 AND fixfolders.is_delete=0 AND fixfolderfiles.ext IN ("'.$ext.'")');
      return count($data1)+count($data2)+count($data3);
    }
    public static function getTotalDocumentFile(){
      $ext = implode('","', DOC_VALID_EXT);
      $data1 = DB::select('select * from '.FILE_TABLE.' join '.FOLDER_TABLE.' on files.folder_id = folders.id where '.FILE_TABLE.'.is_delete=0 AND folders.is_delete=0 AND '.FILE_TABLE.'.filetype = "normal" AND '.FILE_TABLE.'.ext IN ("'.$ext.'")');
      $data3 = DB::select('select * from '.FILE_TABLE.' where is_delete=0 AND folder_id=0 AND filetype = "normal" AND ext IN ("'.$ext.'")');
      $data2 = DB::select('select * from '.FIX_FILE_TABLE.' join fixfolders on fixfolderfiles.folder_id=fixfolders.id where fixfolderfiles.is_delete=0 AND fixfolders.is_delete=0 AND fixfolderfiles.ext IN ("'.$ext.'")');
      return count($data1)+count($data2)+count($data3);
    }
    public static function getTotalMediaFile(){
      $ext = implode('","', MEDIA_VALID_EXT);
      $data1 = DB::select('select * from '.FILE_TABLE.' join '.FOLDER_TABLE.' on files.folder_id = folders.id where '.FILE_TABLE.'.is_delete=0 AND folders.is_delete=0 AND '.FILE_TABLE.'.filetype = "normal" AND '.FILE_TABLE.'.ext IN ("'.$ext.'")');
      $data3 = DB::select('select * from '.FILE_TABLE.' where is_delete=0 AND folder_id=0 AND filetype = "normal" AND ext IN ("'.$ext.'")');
      $data2 = DB::select('select * from '.FIX_FILE_TABLE.' join fixfolders on fixfolderfiles.folder_id=fixfolders.id where fixfolderfiles.is_delete=0 AND fixfolders.is_delete=0 AND fixfolderfiles.ext IN ("'.$ext.'")');
      return count($data1)+count($data2)+count($data3);
    }
    public static function getTotalOtherFile(){
      $ext = implode('","', VALID_EXT);
      $data1 = DB::select('select * from '.FILE_TABLE.' join '.FOLDER_TABLE.' on files.folder_id = folders.id where '.FILE_TABLE.'.is_delete=0 AND folders.is_delete=0 AND '.FILE_TABLE.'.filetype = "normal" AND '.FILE_TABLE.'.ext NOT IN ("'.$ext.'")');
      $data3 = DB::select('select * from '.FILE_TABLE.' where is_delete=0 AND folder_id=0 AND filetype = "normal" AND ext NOT IN ("'.$ext.'")');
      $data2 = DB::select('select * from '.FIX_FILE_TABLE.' join fixfolders on fixfolderfiles.folder_id=fixfolders.id where fixfolderfiles.is_delete=0 AND fixfolders.is_delete=0 AND fixfolderfiles.ext NOT IN ("'.$ext.'")');
      return count($data1)+count($data2)+count($data3);
    }
}
