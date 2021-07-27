<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\Folder;
use App\admin\File;
use App\admin\User;
use App\admin\Notification;
use \Response;
use App\admin\Team;

class questionController extends Controller
{
    public function index(Request $request)
    {
        
        // echo "<pre>"; print_r($request['search']); die();
        $data['user'] = DB::table(CUSTOMER_TABLE)->where([['id',sp_decryption(session()->get('user_id'))], ['role_id',  2]])->get()->first();
        
        $data['fixfolders'] = Folder::fixfolderWithFileCount($request['s']);
        



        $data['recentnotifications'] = Notification::where('is_delete',0)
                                        ->where('user_id',sp_decryption(session()->get('user_id')))
                                        // ->whereDate('created_at','>=',date('Y-m-d',strtotime('-7 days')))
                                        ->orderByDesc('id')
                                        ->limit(6)
                                        ->get();
        $data['page'] = 'dashboard';
        
        return view('user.question')->with('data', $data);
    }
}
