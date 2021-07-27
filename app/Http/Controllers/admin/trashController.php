<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\admin\File;
use App\admin\Folder;
use App\admin\Trash;
use App\admin\Notification;
use DB;
class trashController extends Controller
{
    public function index(Request $request)
    {
        $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
        if(isset($request['search'])){
            $data['deletedfile'] = Trash::deletedfile($request['s']);
            $data['deletedfixfile'] = Trash::deletedfixfile($request['s']);
            $data['deletedfolder'] = Trash::deletedfolder($request['s']);
        }else{
        	$data['deletedfile'] = Trash::deletedfile();
            $data['deletedfixfile'] = Trash::deletedfixfile();
        	$data['deletedfolder'] = Trash::deletedfolder();
        }

        $data['recentnotifications']=Notification::getrecentnotification();
        $data['imagefile']=File::getTotalImageFile();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
    	$data['page']='trash';
    	return view('admin.trash')->with('data',$data);
    }
    public function restorefile(Request $request){
		$id=$request['id'];
		$updated_data = array('is_delete' =>0);
    	$action=File::addUpdateRecord($updated_data,$id);
    	if($action){
    		session()->flash('succ_msg','File Restored Succesfully.');
    	}else{
    		session()->flash('fail_msg','Something Went Wrong.');
    	}
    	return back();
    }
    public function restorefolder(Request $request){
		$id=$request['id'];
		$updated_data = array('is_delete' =>0);
    	$action=Folder::addUpdateRecord($updated_data,$id);
    	if($action){
    		session()->flash('succ_msg','Folder Restored Succesfully.');
    	}else{
    		session()->flash('fail_msg','Something Went Wrong.');
    	}
    	return back();
    }
    public function restorefixfile(Request $request){
        $id=$request['id'];
        $updated_data = array('is_delete' =>0);
        $action=File::addUpdateFixRecord($updated_data,$id);
        if($action){
            session()->flash('succ_msg','File Restored Succesfully.');
        }else{
            session()->flash('fail_msg','Something Went Wrong.');
        }
        return back();
    }
    public function deletefixfile(Request $request){
        $id=$request['id'];
        $updated_data = array('final_delete' =>1);
        $action=File::addUpdateFixRecord($updated_data,$id);
        if($action){
            session()->flash('succ_msg','File Permanent Deleted.');
        }else{
            session()->flash('fail_msg','Something Went Wrong.');
        }
        return back();
    }
    public function deletefile(Request $request){
		$id=$request['id'];
		$updated_data = array('final_delete' =>1);
    	$action=File::addUpdateRecord($updated_data,$id);
    	if($action){
    		session()->flash('succ_msg','File Permanent Deleted.');
    	}else{
    		session()->flash('fail_msg','Something Went Wrong.');
    	}
    	return back();
    }
    public function deletefolder(Request $request){
		$id=$request['id'];
		$updated_data = array('final_delete' =>1);
    	$action=Folder::addUpdateRecord($updated_data,$id);
    	if($action){
    		session()->flash('succ_msg','Folder Permanent Deleted.');
    	}else{
    		session()->flash('fail_msg','Something Went Wrong.');
    	}
    	return back();
    }
}
