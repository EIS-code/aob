<?php

namespace App\admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $guarded = [];

    public static function removeUserFromTeam($id){
        $data=DB::table(TEAM_MEMBER_TABLE)->where('user_id',$id)->delete();
        return $data;
    }
}
