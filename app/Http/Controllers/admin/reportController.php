<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\Folder;
use App\admin\File;
use App\admin\Notification;

class reportController extends Controller
{
    public function index(Request $request){
    	$data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
        $data['parentfolders']= DB::table(FOLDER_TABLE)
                                ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'))
                                ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                ->where([ [FOLDER_TABLE.'.parent_id','=',session()->get('parent_id')],[FOLDER_TABLE.'.is_delete','=',0] ])
                                ->groupBy(FOLDER_TABLE.'.name')
                                ->get();
    	$data['movefolders'] =	DB::table(FOLDER_TABLE)
    							->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id as folderid')
    							->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
    							->where([ [FOLDER_TABLE.'.parent_id','=',0],[FOLDER_TABLE.'.is_delete','=',0] ])
    							->groupBy(FOLDER_TABLE.'.name')
    							->get();
    	$data['parentfiles'] =	DB::table(FILE_TABLE)
    							->where([ ['folder_id','=',session()->get('folder_id')],['is_delete','=',0],['filetype','=','normal'] ])
    							->get();
        $data['teams'] =  DB::table(TEAM_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0] ])
                                ->get();
        $data['users'] =  DB::table(CUSTOMER_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ])
                                ->get();
        if(isset($request['search'])){
        	$data['reports']=File::getTotalReportFile($request['s']);
        }else{
        	$data['reports']=File::getTotalReportFile();
        }
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['imagefile']=File::getTotalImageFile();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
    	$data['page']='reports';
    	return view('admin.reports')->with('data',$data);
    }
    public function addupdatereport(Request $request){
	    if(isset($_FILES['fileToUpload'])){
	      if($_FILES['fileToUpload']['name']!=''){
	        $file = File::getRecordByFileName($_FILES['fileToUpload']['name']);
	        if($file){
	            session()->flash('fail_msg','Filename already exists !!');
	        }else{
                $file_name = 'new_'.pathinfo($_FILES['fileToUpload']['name'], PATHINFO_FILENAME);
	            $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
	            $ext = strtolower($ext);
	                $target_file = $_SERVER["DOCUMENT_ROOT"].ROOT_PATH.'public/document/';
	                $size = (filesize($_FILES["fileToUpload"]["tmp_name"]))/1024; //KB
	                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.$file_name);
	                $data['document_size']=$size;
	                $id=0;
	                $updated_data = array('name' =>$file_name,'ext' =>$ext,'size' =>$size,'folder_id' =>0,'filetype'=>'report','created_at'=>date('Y-m-d h:i:s'));
	                $action=File::addUpdateRecord($updated_data,$id);
	                if($action){
	                    session()->flash('succ_msg','Report Added Succesfully.');
	                }else{
	                    session()->flash('fail_msg','Something Went Wrong.');
	                }
	        }
	      }else{
	        session()->flash('fail_msg','Please select a file');
	      }
	    }else{
	        session()->flash('fail_msg','Please select a file');
	    }
	    return back();
	}
}
