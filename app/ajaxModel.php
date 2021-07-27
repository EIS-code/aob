<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ajaxModel extends Model
{
    public static function getSubFolder($folderid){
    	$data =  DB::table(FOLDER_TABLE)
				->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id as folderid')
				->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
				->where([ [FOLDER_TABLE.'.parent_id','=',$folderid],[FOLDER_TABLE.'.is_delete','=',0] ])
				->groupBy(FOLDER_TABLE.'.name')
				->get();
		return $data;
    }
    
}
