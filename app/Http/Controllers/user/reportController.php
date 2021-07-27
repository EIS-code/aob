<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\Folder;
use App\admin\File;
use App\admin\Notification;

class reportController extends Controller
{
    public function index(Request $request){
    	
    	$data['user']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('user_id'))],['role_id','=',2] ])->get()->first();
      	$data['reports']= DB::table(FILE_TABLE)
		  					->leftjoin(SHARE_TABLE, SHARE_TABLE.'.shared_id', '=', FILE_TABLE.'.id')
							->leftjoin(CUSTOMER_TABLE, SHARE_TABLE.'.user_id', '=', CUSTOMER_TABLE.'.id')
							->where(FILE_TABLE. '.is_delete' , 0)
							->where(SHARE_TABLE. '.is_delete' , 0)
							->where(CUSTOMER_TABLE. '.id' , sp_decryption(session()->get('user_id')))
							->where(FILE_TABLE.'.filetype', 'report')
							->orderByDesc(SHARE_TABLE.'.id')
							->select(FILE_TABLE . ".*")
							->get();

        $data['recentnotifications']= Notification::where('is_delete',0)
										->where('user_id',sp_decryption(session()->get('user_id')))
										// ->whereDate('created_at','>=',date('Y-m-d',strtotime('-7 days')))
										->orderByDesc('id')
										->limit(6)
										->get();
        $data['page']='reports';
    	
    	return view('user.reports')->with('data',$data);
    }
}
