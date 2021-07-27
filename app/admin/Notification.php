<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Notification extends Model
{
    public static function addUpdateRecord($data,$id){
    	if($id!=0){
   			$updated=DB::table(NOTIFICATION_TABLE)->where('id',$id)->update($data);
    	}else{
   			$updated=DB::table(NOTIFICATION_TABLE)->insert($data);
    	}
  		if($updated){
  			return true;
  		}else{
  			return false;
  		}
    }
    public static function getrecentnotification(){
      $data=DB::table(NOTIFICATION_TABLE)
            ->where([ ['is_delete','=',0], ['user_id','=',sp_decryption(session()->get('admin_id'))] ])
            ->orderByDesc('id')
            ->limit(6)
            ->get();
        return $data;
    }
    public static function getallrecentnotification(){
      $date = date('Y-m-d',strtotime('-7 days'));
      $data=DB::table(NOTIFICATION_TABLE)
            ->where([ ['is_delete','=',0], ['user_id','=',sp_decryption(session()->get('admin_id'))] ])
            ->whereDate('created_at','>=',$date)
            ->orderByDesc('id')
            ->get();
        return $data;
    }
}
