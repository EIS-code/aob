<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;


class User extends Model
{
	protected $guarded = [];
	
    public static function updateRecord($data,$id)
    {
		$updated=DB::table(CUSTOMER_TABLE)->where('id',$id)->update($data);
		if($updated){
			return true;
		}else{
			return false;
		}
    }
    public static function getRecordByUser($id)
    {
		$data=DB::table(CUSTOMER_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->get();
		return $data;
    }
    public static function getRecordByEmail($email){
        $data=DB::table(CUSTOMER_TABLE)->where([ ['email','=',$email],['is_delete','=',0] ])->first();
        return $data;
    }
    public static function getRecordById($id){
        $data=DB::table(CUSTOMER_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->first();
        return $data;
    }
    public static function addUpdateRecord($data,$id)
    {
    	if($id!=0){
   			$updated=DB::table(CUSTOMER_TABLE)->where('id',$id)->update($data);
    	}else{
   			$updated=DB::table(CUSTOMER_TABLE)->insert($data);
    	}
		if($updated){
			return true;
		}else{
			return false;
		}
    }
}
