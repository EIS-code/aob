<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Chat extends Model
{
	public static function getChatByUser($fromid,$toid){
		$data=DB::table(CHAT_TABLE)
			->orWhere([ ['fromid','=',$fromid],['toid','=',$toid] ])
			->orWhere([ ['toid','=',$fromid],['fromid','=',$toid] ])
			->where([ ['is_delete','=',0] ])
			->get();
		return $data;
    }
    public static function getLastChatByUser($fromid,$toid){
		$data=DB::table(CHAT_TABLE)
			->orWhere([ ['fromid','=',$fromid],['toid','=',$toid] ])
			->orWhere([ ['toid','=',$fromid],['fromid','=',$toid] ])
			->where([ ['is_delete','=',0] ])
			->orderByDesc('id')
			->first();
		return $data;
    }
    public static function addUpdateRecord($data,$id){
    	if($id!=0){
   			$updated=DB::table(CHAT_TABLE)->where('id',$id)->update($data);
    	}else{
   			$updated=DB::table(CHAT_TABLE)->insert($data);
    	}
		if($updated){
			return true;
		}else{
			return false;
		}
    }
}
