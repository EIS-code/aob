<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Team extends Model
{
    public static function updateRecord($data,$id)
    {
		$updated=DB::table(TEAM_TABLE)->where('id',$id)->update($data);
		if($updated){
			return true;
		}else{
			return false;
		}
    }
    public static function getMembersByTeam($id,$search="")
    {
        if($search==''){
          $data=DB::table(TEAM_MEMBER_TABLE)->selectRaw(TEAM_MEMBER_TABLE.'.id as tid,users.*,users.id as uid')->join(CUSTOMER_TABLE, TEAM_MEMBER_TABLE.'.user_id', '=', CUSTOMER_TABLE.'.id')->where([ [TEAM_MEMBER_TABLE.'.team_id','=',$id],[TEAM_MEMBER_TABLE.'.is_delete','=',0] ])->get();
        }else{
		  $data=DB::table(TEAM_MEMBER_TABLE)
                ->selectRaw(TEAM_MEMBER_TABLE.'.id as tid,users.*,users.id as uid')
                ->join(CUSTOMER_TABLE, TEAM_MEMBER_TABLE.'.user_id', '=', CUSTOMER_TABLE.'.id')
                ->where([ [TEAM_MEMBER_TABLE.'.team_id','=',$id],[TEAM_MEMBER_TABLE.'.is_delete','=',0] ])
                ->where(CUSTOMER_TABLE.'.name','LIKE','%'.$search.'%')
                ->get();

        }
		return $data;
    }
    public static function clearRecordByTeam($id,$data){
        $data=DB::table(TEAM_MEMBER_TABLE)->where('team_id',$id)->update($data);
        return $data;
    }
    public static function getRecordByUser($id)
    {
		$data=DB::table(TEAM_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->first();
		return $data;
    }
    public static function memberAddUpdateRecord($data,$id)
    {
        if($id!=0){
            $updated=DB::table(TEAM_MEMBER_TABLE)->where('id',$id)->update($data);
            $response = $id;
        }else{
            $response=DB::table(TEAM_MEMBER_TABLE)->insertGetId($data);
        }
        return $response;
    }
    public static function addUpdateRecord($data,$id)
    {
    	if($id!=0){
   			$updated=DB::table(TEAM_TABLE)->where('id',$id)->update($data);
            $response = $id;
    	}else{
   			$response=DB::table(TEAM_TABLE)->insertGetId($data);
    	}
		return $response;
    }
}
