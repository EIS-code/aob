<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\admin\File;
use App\admin\Notification;
use DB;

class notificationController extends Controller
{
    public function index(){
        $data['user']=DB::table(CUSTOMER_TABLE)->where([ ['id',sp_decryption(session()->get('user_id'))],['role_id',2] ])->get()->first();
    	$data['recentnotifications'] = Notification::where('is_delete',0)
                                        ->where('user_id',sp_decryption(session()->get('user_id')))
                                        // ->whereDate('created_at','>=',date('Y-m-d',strtotime('-7 days')))
                                        ->orderByDesc('id')
                                        ->limit(6)
                                        ->get();
            
        $data['notifications'] = Notification::where('is_delete',0)
                                ->where('user_id',sp_decryption(session()->get('user_id')))
                                ->orderByDesc('id')
                                ->get();

        $data['page']='notifications';
    	return view('user.notifications')->with('data',$data);
    }
}
