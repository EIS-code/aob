<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Share extends Model
{
    public static function addUpdateRecord($data,$id)
    {
    	if($id!=0){
   			$updated=DB::table(SHARE_TABLE)->where('id',$id)->update($data);
    	}else{
   			$updated=DB::table(SHARE_TABLE)->insert($data);
    	}
		if($updated){
			return true;
		}else{
			return false;
		}
    }
    public static function recentsharefile($search=''){
        if(empty($search)){
            $data=DB::table(SHARE_TABLE)
                ->select(FILE_TABLE.'.*')
                ->join(FILE_TABLE, SHARE_TABLE.'.shared_id', '=', FILE_TABLE.'.id')
                ->where(SHARE_TABLE.'.type','file')
                ->where(SHARE_TABLE.'.is_delete',0)
                ->where(FILE_TABLE.'.is_delete',0)
                ->groupBy(SHARE_TABLE.'.shared_id')
                ->orderBy(SHARE_TABLE.'.id','desc')
                ->get();
        }else{
            $data=DB::table(SHARE_TABLE)
                ->select(FILE_TABLE.'.*')
                ->join(FILE_TABLE, SHARE_TABLE.'.shared_id', '=', FILE_TABLE.'.id')
                ->where(SHARE_TABLE.'.type','file')
                ->where(SHARE_TABLE.'.is_delete',0)
                ->where(FILE_TABLE.'.is_delete',0)
                ->where(FILE_TABLE.'.name','LIKE','%'.$search.'%')
                ->groupBy(SHARE_TABLE.'.shared_id')
                ->orderBy(SHARE_TABLE.'.id','desc')
                ->get();
        }

        return $data;
    }

    public static function recentsharefolder($search=''){
        if(empty($search)){
            $data=DB::table(SHARE_TABLE)
            ->select(FOLDER_TABLE.'.*')
            ->join(FOLDER_TABLE, SHARE_TABLE.'.shared_id', '=', FOLDER_TABLE.'.id')
            ->where(SHARE_TABLE.'.type','folder')
            ->where(SHARE_TABLE.'.is_delete',0)
            ->where(FOLDER_TABLE.'.is_delete',0)
            ->groupBy(SHARE_TABLE.'.shared_id')
            ->orderBy(SHARE_TABLE.'.id','desc')
            ->get();

            
        }else{
            $data=DB::table(SHARE_TABLE)
            ->select(FOLDER_TABLE.'.*')
            ->join(FOLDER_TABLE, SHARE_TABLE.'.shared_id', '=', FOLDER_TABLE.'.id')
            ->where(SHARE_TABLE.'.type','folder')
            ->where(SHARE_TABLE.'.is_delete',0)
            ->where(FOLDER_TABLE.'.is_delete',0)
            ->where(FOLDER_TABLE.'.name','LIKE','%'.$search.'%')
            ->groupBy(SHARE_TABLE.'.shared_id')
            ->orderBy(SHARE_TABLE.'.id','desc')
            ->get();
        }

        return $data;
    }
    public static function getsharedmemberes($share_id){
        $data=DB::table(SHARE_TABLE)
                ->join(CUSTOMER_TABLE, SHARE_TABLE.'.user_id', '=', CUSTOMER_TABLE.'.id')
                ->where(SHARE_TABLE.'.shared_id',$share_id)->where(SHARE_TABLE.'.type','folder')->get();
        return $data;
    }
    public static function getsharedmemberesbyfile($share_id){
        $data=DB::table(SHARE_TABLE)
                ->join(CUSTOMER_TABLE, SHARE_TABLE.'.user_id', '=', CUSTOMER_TABLE.'.id')
                ->where(SHARE_TABLE.'.shared_id',$share_id)->where(SHARE_TABLE.'.type','file')->get();
        return $data;
    }
    public static function getsharedteamsbyfile($share_id){
        $data=DB::table(SHARE_TABLE)
                ->join(TEAM_TABLE, SHARE_TABLE.'.team_id', '=', TEAM_TABLE.'.id')
                ->where(SHARE_TABLE.'.shared_id',$share_id)->where(SHARE_TABLE.'.type','file')->get();
        return $data;
    }
    public static function getsharedteamsbyfolder($share_id){
        $data=DB::table(SHARE_TABLE)
                ->join(TEAM_TABLE, SHARE_TABLE.'.team_id', '=', TEAM_TABLE.'.id')
                ->where(SHARE_TABLE.'.shared_id',$share_id)->where(SHARE_TABLE.'.type','folder')->get();
        return $data;
    }
    public static function getreportsharedmemberes($share_id){
        $data=DB::table(SHARE_TABLE)
                ->join(CUSTOMER_TABLE, SHARE_TABLE.'.user_id', '=', CUSTOMER_TABLE.'.id')
                ->join(FILE_TABLE, SHARE_TABLE.'.shared_id', '=', FILE_TABLE.'.id')
                ->where(SHARE_TABLE.'.shared_id',$share_id)->where(SHARE_TABLE.'.type','file')->where(FILE_TABLE.'.filetype','report')->get();
        return $data;
    }
    public static function clearRecordBySharedFolder($id,$type,$data){
        $data=DB::table(SHARE_TABLE)->where('shared_id',$id)->where('type',$type)->whereNull('user_id')->update($data);
        return $data;
    }
    public static function clearRecordBySharedFolder1($id,$type,$data){
        $data=DB::table(SHARE_TABLE)->where('shared_id',$id)->where('type',$type)->whereNull('team_id')->update($data);
        return $data;
    }
}
