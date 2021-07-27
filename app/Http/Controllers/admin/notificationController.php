<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\admin\File;
use App\admin\Notification;
use DB;

class notificationController extends Controller
{
    public function index(){
        $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
    	$data['teams'] = DB::table(TEAM_TABLE)->where([ ['is_active','=',1],['is_delete','=',0] ])->get();
    	$data['users'] = DB::table(CUSTOMER_TABLE)->where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ])->get();
        $data['movefolders'] =  DB::table(FOLDER_TABLE)
                                ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id as folderid')
                                ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                ->where([ [FOLDER_TABLE.'.parent_id','=',0],[FOLDER_TABLE.'.is_delete','=',0] ])
                                ->groupBy(FOLDER_TABLE.'.name')
                                ->get();
        $data['teams'] =  DB::table(TEAM_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0] ])
                                ->get();
        $data['users'] =  DB::table(CUSTOMER_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0] ])
                                ->get();
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['notifications']=Notification::getallrecentnotification();
        $data['recentfiles']=File::getRecentFile();
        $data['imagefile']=File::getTotalImageFile();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
    	$data['page']='notifications';
    	return view('admin.notifications')->with('data',$data);
    }
}
