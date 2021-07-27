<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\Folder;
use App\admin\File;
use App\admin\Notification;
use \Response;
use Illuminate\Support\Arr;

class folderController extends Controller
{
    public function index(Request $request){
    	session()->put('parent_id',0);
    	session()->put('folder_id',0);
    	$data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
        
        if(isset($request['search'])){
            $data['parentfolders']= DB::table(FOLDER_TABLE)
                                    ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'))
                                    ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                    ->where([ [FOLDER_TABLE.'.parent_id','=',session()->get('parent_id')],[FOLDER_TABLE.'.is_delete','=',0] ])
                                    ->where(FOLDER_TABLE.'.name','LIKE','%'.$request['s'].'%')
                                    ->groupBy(FOLDER_TABLE.'.name')
                                    ->get();
            $data['parentfiles'] =  DB::table(FILE_TABLE)
                                    ->where([ ['folder_id','=',session()->get('folder_id')],['is_delete','=',0],['filetype','=','normal'] ])
                                    ->where(FILE_TABLE.'.name','LIKE','%'.$request['s'].'%')
                                    ->get();
        }else{
            $data['parentfolders']= DB::table(FOLDER_TABLE)
                                    ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'))
                                    ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                    ->where([ [FOLDER_TABLE.'.parent_id','=',session()->get('parent_id')],[FOLDER_TABLE.'.is_delete','=',0] ])
                                    ->groupBy(FOLDER_TABLE.'.name')
                                    ->get();
        	$data['parentfiles'] =	DB::table(FILE_TABLE)
        							->where([ ['folder_id','=',session()->get('folder_id')],['is_delete','=',0],['filetype','=','normal'] ])
        							->get();
        }
        $data['parentfolders1']= DB::table(FOLDER_TABLE)
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
        $data['teams'] =  DB::table(TEAM_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0] ])
                                ->get();
        $data['users'] =  DB::table(CUSTOMER_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ])
                                ->get();
        $data['recentnotifications']=Notification::getrecentnotification();
    	$data['page']='folder';
    	return view('admin.folder')->with('data',$data);
    }
    public function folderindex(request $request){
        if($request['folder1']!=''){
            $folder = Folder::getRecordById($request['folder1']);
            $breadcrump = array();
            $folder_bred = $folder;
            $i=0;
            while($folder_bred->parent_id!=0){
                $breadcrump[$i] = new \stdClass();
                $breadcrump[$i]->id = $folder_bred->id;
                $breadcrump[$i]->name = $folder_bred->name;
                $i++;
                $folder_bred = Folder::getRecordById($folder_bred->parent_id);
            }
            $breadcrump[$i] = new \stdClass();
            $breadcrump[$i]->id = $folder_bred->id;
            $breadcrump[$i]->name = $folder_bred->name;
            $data['breadcrumps'] = array_reverse($breadcrump);
            session()->put('parent_id',$folder->id);
            session()->put('folder_id',$folder->id);
            $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
            
            if(isset($request['search'])){
                $data['parentfolders']= DB::table(FOLDER_TABLE)
                                    ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'))
                                    ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                    ->where([ [FOLDER_TABLE.'.parent_id','=',session()->get('parent_id')],[FOLDER_TABLE.'.is_delete','=',0] ])
                                    ->where(FOLDER_TABLE.'.name','LIKE','%'.$request['s'].'%')
                                    ->groupBy(FOLDER_TABLE.'.name')
                                    ->get();
                $data['parentfiles'] =  DB::table(FILE_TABLE)
                                    ->where([ ['folder_id','=',session()->get('folder_id')],['is_delete','=',0],['filetype','=','normal'] ])
                                    ->where(FILE_TABLE.'.name','LIKE','%'.$request['s'].'%')
                                    ->get();
            }else{
                $data['parentfolders']= DB::table(FOLDER_TABLE)
                                    ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'))
                                    ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                    ->where([ [FOLDER_TABLE.'.parent_id','=',session()->get('parent_id')],[FOLDER_TABLE.'.is_delete','=',0] ])
                                    ->groupBy(FOLDER_TABLE.'.name')
                                    ->get();
                $data['parentfiles'] =  DB::table(FILE_TABLE)
                                    ->where([ ['folder_id','=',session()->get('folder_id')],['is_delete','=',0],['filetype','=','normal'] ])
                                    ->get();
            }
            $data['parentfolders1']= DB::table(FOLDER_TABLE)
                                    ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'))
                                    ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                    ->where([ [FOLDER_TABLE.'.parent_id','=',0],[FOLDER_TABLE.'.is_delete','=',0] ])
                                    ->groupBy(FOLDER_TABLE.'.name')
                                    ->get();
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
            $data['page']='folder';
            $data['recentnotifications']=Notification::getrecentnotification();
            $data['folder']=$folder;
            $parentFiles = array();
            if(!empty($data['parentfiles'])) {
                foreach($data['parentfiles'] as $key => $file) {
                    if (file_exists( public_path() . '/document/' . $file->name .'.'. $file->ext)) {
                        $parentFiles[] = $file;
                    }
                }
                $data['parentfiles'] = $parentFiles;
            }
            return view('admin.folderindex')->with('data',$data);
        }else{
            return redirect('admin/folder');
        }
    }
    public function fixfolderindex(request $request){
        if($request['folder1']!=''){
            $folder = Folder::getFixRecordById($request['folder1']);
            session()->put('fixfolder_id',$folder->id);
            $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
            
            if(isset($request['search'])){
                $data['parentfiles'] =  DB::table(FIX_FILE_TABLE)
                                    ->where([ ['folder_id','=',session()->get('fixfolder_id')],['is_delete','=',0] ])
                                    ->where(FIX_FILE_TABLE.'.name','LIKE','%'.$request['s'].'%')
                                    ->get();
            }else{
                $data['parentfiles'] =  DB::table(FIX_FILE_TABLE)
                                    ->where([ ['folder_id','=',session()->get('fixfolder_id')],['is_delete','=',0] ])
                                    ->get();
            }

            $data['parentfolders']= DB::table(FIX_FOLDER_TABLE)
                                    ->select(FIX_FOLDER_TABLE.'.*')
                                    ->leftJoin(FIX_FILE_TABLE, FIX_FOLDER_TABLE.'.id', '=', FIX_FILE_TABLE.'.folder_id')
                                    ->where([ [FIX_FOLDER_TABLE.'.is_delete','=',0] ])
                                    ->groupBy(FIX_FOLDER_TABLE.'.name')
                                    ->get();

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
            $data['page']='folder';
            $data['fixfolder']=$folder;
            return view('admin.fixfolderindex')->with('data',$data);
        }else{
            return redirect('admin/folder');
        }
    }

public function addupdatefolder(Request $request){
	$validatedData=$request->validate([
		'name'=>'required',
	]);

    $folder = Folder::getRecordByFolderName($request['name']);
    if($folder){
        session()->flash('fail_msg','Folder name already exists. Please enter anothor folder name.');
    }else{
        if(!empty($request['id'])){
    		$id=$request['id'];
    		$updated_data = array('name' =>$request['name'],'parent_id' =>session()->get('parent_id'),'updated_at'=>date('Y-m-d h:i:s'));
    	}else{
    		$id=0;
    		$updated_data = array('name' =>$request['name'],'parent_id' =>session()->get('parent_id'),'created_at'=>date('Y-m-d h:i:s'));
    	}

        $action=Folder::addUpdateRecord($updated_data,$id);
    	if($action){
            $notification['user_id']=sp_decryption(session()->get('admin_id'));
            $notification['title'] = "You have added a '".$request['name']."' folder.";
            $notification['details'] = "You have added a '".$request['name']."' folder.";
            $notification['created_at'] = date('Y-m-d h:i:s');
            $notification['updated_at'] = date('Y-m-d h:i:s');
    	    Notification::addUpdateRecord($notification,0);
    		if($id==0){
    			session()->flash('succ_msg','Folder Added Succesfully.');
    		}else{
    			session()->flash('succ_msg','Folder Updated Succesfully.');
    		}
    	}else{
    		session()->flash('fail_msg','Something Went Wrong.');
    	}
    }
    return back();
}
public function addupdatefile(Request $request){
    if(isset($_FILES['fileToUpload'])){
      if($_FILES['fileToUpload']['name']!=''){
        $file = File::getRecordByFileName($_FILES['fileToUpload']['name']);
        if($file){
            session()->flash('fail_msg','Filename already exists !!');
        }else{
            $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
            $file_name = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_FILENAME);
            $ext = strtolower($ext);
                $target_file = $_SERVER["DOCUMENT_ROOT"].ROOT_PATH.'public/document/';
                $size = (filesize($_FILES["fileToUpload"]["tmp_name"]))/1024; //KB
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.$file_name.'.'.$ext);
                $data['document_size']=$size;
                $id=0;
                $updated_data = array('name' =>$file_name,'ext' =>$ext,'size' =>$size,'folder_id' =>session()->get('folder_id'),'created_at'=>date('Y-m-d h:i:s'));
                $action=File::addUpdateRecord($updated_data,$id);
                if($action){
                    $notification['user_id']=sp_decryption(session()->get('admin_id'));
                    $notification['title'] = "You have added a '".$file_name."' file.";
                    $notification['details'] = "You have added a '".$file_name."' file.";
                    $notification['created_at'] = date('Y-m-d h:i:s');
                    $notification['updated_at'] = date('Y-m-d h:i:s');
                    Notification::addUpdateRecord($notification,0);
                    session()->flash('succ_msg','File Added Succesfully.');
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
public function addupdatefixfile(Request $request){
    if(isset($_FILES['fileToUpload'])){
      if($_FILES['fileToUpload']['name']!=''){
        $file = File::getFixRecordByFileName($_FILES['fileToUpload']['name']);
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
                $updated_data = array('name' =>$file_name,'ext' =>$ext,'size' =>$size,'folder_id' =>session()->get('fixfolder_id'),'created_at'=>date('Y-m-d h:i:s'));
                $action=File::addUpdateFixRecord($updated_data,$id);
                if($action){
                    $notification['user_id']=sp_decryption(session()->get('admin_id'));
                    $notification['title'] = "You have added a '".$file_name."' file.";
                    $notification['details'] = "You have added a '".$file_name."' file.";
                    $notification['created_at'] = date('Y-m-d h:i:s');
                    $notification['updated_at'] = date('Y-m-d h:i:s');
                    Notification::addUpdateRecord($notification,0);
                    session()->flash('succ_msg','File Added Succesfully.');
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
public function movefolder(Request $request){
    if($request['move_file']==0){
        if( $request['move_folder_id']==$request['move'] || $request['move']=='' || $request['move_folder_id']=='' || $request['move_folder_id']==NULL || $request['move']==NULL ){
            session()->flash('fail_msg','Please select a another folder');
        }else{
            if($request['move'] == -1) { // transfer to root folder
                $fromfolderdata = Folder::getRecordById($request['move_folder_id']);
                $id=$request['move_folder_id'];
                $updated_data = array('parent_id' =>0,'updated_at'=>date('Y-m-d h:i:s'));
                $action=Folder::addUpdateRecord($updated_data,$id);
                if($action){
                    $notification['user_id']=sp_decryption(session()->get('admin_id'));
                    $notification['title'] = "You have moved folder from '".$fromfolderdata->name."' to root folder.";
                    $notification['details'] = "You have moved folder from '".$fromfolderdata->name."' to root folder.";
                    $notification['created_at'] = date('Y-m-d h:i:s');
                    $notification['updated_at'] = date('Y-m-d h:i:s');
                    Notification::addUpdateRecord($notification,0);
                    session()->flash('succ_msg','Folder Moved Succesfully.');
                }else{
                    session()->flash('fail_msg','Something Went Wrong.');
                }
            } else {
                $temp_tofolderdata = Folder::getRecordById($request['move']);
                while ($temp_tofolderdata->parent_id == $request['move_folder_id'] ){
                    $temp_tofolderdata = Folder::getRecordById($temp_tofolderdata->parent_id);
                }
                if($request['move_folder_id']==$temp_tofolderdata->id){
                    session()->flash('fail_msg','Please select a another folder');
                }else{
                    $tofolderdata = Folder::getRecordById($request['move']);
                    $fromfolderdata = Folder::getRecordById($request['move_folder_id']);
                    $id=$request['move_folder_id'];
                    $updated_data = array('parent_id' =>$request['move'],'updated_at'=>date('Y-m-d h:i:s'));
                    $action=Folder::addUpdateRecord($updated_data,$id);
                    if($action){
                        $notification['user_id']=sp_decryption(session()->get('admin_id'));
                        $notification['title'] = "You have moved folder from '".$fromfolderdata->name."' to '".$tofolderdata->name."'.";
                        $notification['details'] = "You have moved folder from '".$fromfolderdata->name."' to '".$tofolderdata->name."'.";
                        $notification['created_at'] = date('Y-m-d h:i:s');
                        $notification['updated_at'] = date('Y-m-d h:i:s');
                        Notification::addUpdateRecord($notification,0);
                        session()->flash('succ_msg','Folder Moved Succesfully.');
                    }else{
                        session()->flash('fail_msg','Something Went Wrong.');
                    }
                }
            }
            
            
        }
    }else{
        if($request['move'] == -1) { // transfer to root folder
            $id=$request['move_folder_id'];
            $updated_data = array('folder_id' =>0,'updated_at'=>date('Y-m-d h:i:s'));
            $action=File::addUpdateRecord($updated_data,$id);
            if($action){
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have moved file.";
                $notification['details'] = "You have moved file.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
                session()->flash('succ_msg','File Moved Succesfully.');
            }else{
                session()->flash('fail_msg','Something Went Wrong.');
            }
        } else {
            $id=$request['move_folder_id'];
            $updated_data = array('folder_id' =>$request['move'],'updated_at'=>date('Y-m-d h:i:s'));
            $action=File::addUpdateRecord($updated_data,$id);
            if($action){
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have moved file.";
                $notification['details'] = "You have moved file.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
                session()->flash('succ_msg','File Moved Succesfully.');
            }else{
                session()->flash('fail_msg','Something Went Wrong.');
            }
        }
    }
    return back();
}
public function copyfolder(Request $request){
    if($request['copy_file']==0){
        if( $request['copy_folder_id']==$request['copy'] || $request['copy']=='' || $request['copy_folder_id']=='' || $request['copy_folder_id']==NULL || $request['copy']==NULL ){
            session()->flash('fail_msg','Please select a another folder');
        }else{
            if($request['copy'] == -1) { // copy to root folder
                $fromfolderdata = Folder::getRecordById($request['copy_folder_id']);
                //To get the folder details with associated files
                $fromFolderDataWithFiles = Folder::with(['Files'])->find($request['copy_folder_id']);
                $id=0;
                $folder = new Folder();
                //To copy the folders with associated files
                $action = $folder->copyFolder($fromFolderDataWithFiles, 0);
                if($action){
                    $notification['user_id']=sp_decryption(session()->get('admin_id'));
                    $notification['title'] = "You have copied folder from '".$fromfolderdata->name."' to root folder.";
                    $notification['details'] = "You have copied folder from '".$fromfolderdata->name."' to root folder.";
                    $notification['created_at'] = date('Y-m-d h:i:s');
                    $notification['updated_at'] = date('Y-m-d h:i:s');
                    Notification::addUpdateRecord($notification,0);
                    session()->flash('succ_msg','Folder Copied Succesfully.');
                }else{
                    session()->flash('fail_msg','Something Went Wrong.');
                }
            } else {
                $temp_tofolderdata = Folder::getRecordById($request['copy']);
                while ($temp_tofolderdata->parent_id == $request['copy_folder_id'] ){
                    $temp_tofolderdata = Folder::getRecordById($temp_tofolderdata->parent_id);
                }
                if($request['copy_folder_id']==$temp_tofolderdata->id){
                    session()->flash('fail_msg','Please select a another folder');
                }else{
                    $tofolderdata = Folder::getRecordById($request['copy']);
                    $fromfolderdata = Folder::getRecordById($request['copy_folder_id']);
                    //To get the folder details with associated files
                    $fromFolderDataWithFiles = Folder::with(['Files'])->find($request['copy_folder_id']);
                    $id=0;
                    $folder = new Folder();
                    //To copy the folders with associated files
                    $action = $folder->copyFolder($fromFolderDataWithFiles, $request['copy']);
                    if($action){
                        $notification['user_id']=sp_decryption(session()->get('admin_id'));
                        $notification['title'] = "You have copied folder from '".$fromfolderdata->name."' to '".$tofolderdata->name."'.";
                        $notification['details'] = "You have copied folder from '".$fromfolderdata->name."' to '".$tofolderdata->name."'.";
                        $notification['created_at'] = date('Y-m-d h:i:s');
                        $notification['updated_at'] = date('Y-m-d h:i:s');
                        Notification::addUpdateRecord($notification,0);
                        session()->flash('succ_msg','Folder Copied Succesfully.');
                    }else{
                        session()->flash('fail_msg','Something Went Wrong.');
                    }
                }
            }
            
        }
    }else{
        if($request['copy'] == -1) { // copy to root folder
            $fromfiledata = File::getRecordById($request['copy_folder_id']);
            $id=0;
            $updated_data = array('name' =>$fromfiledata->name,'folder_id' => 0,'created_at'=>date('Y-m-d h:i:s'));
            $action=File::addUpdateRecord($updated_data,$id);
            if($action){
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have copied file.";
                $notification['details'] = "You have copied file.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
                session()->flash('succ_msg','File Copied Succesfully.');
            }else{
                session()->flash('fail_msg','Something Went Wrong.');
            }
        } else {
            $fromfiledata = File::getRecordById($request['copy_folder_id']);
            $id=0;
            $updated_data = array('name' =>$fromfiledata->name,'folder_id' =>$request['copy'],'created_at'=>date('Y-m-d h:i:s'));
            $action=File::addUpdateRecord($updated_data,$id);
            if($action){
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have copied file.";
                $notification['details'] = "You have copied file.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
                session()->flash('succ_msg','File Copied Succesfully.');
            }else{
                session()->flash('fail_msg','Something Went Wrong.');
            }
        }
        
    }
    return back();
}
public function movefixfile(Request $request){
    $id=$request['move_folder_id'];
    $updated_data = array('folder_id' =>$request['move'],'updated_at'=>date('Y-m-d h:i:s'));
    $action=File::addUpdateFixRecord($updated_data,$id);
    if($action){
        $notification['user_id']=sp_decryption(session()->get('admin_id'));
        $notification['title'] = "You have moved file.";
        $notification['details'] = "You have moved file.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification,0);
        session()->flash('succ_msg','File Moved Succesfully.');
    }else{
        session()->flash('fail_msg','Something Went Wrong.');
    }
    return back();
}
public function copyfixfile(Request $request){
    $fromfiledata = File::getFixRecordById($request['copy_folder_id']);
    $id=0;
    $updated_data = array('name' =>$fromfiledata->name,'ext' =>$fromfiledata->ext,'size' =>$fromfiledata->size,'folder_id' =>$request['copy'],'created_at'=>date('Y-m-d h:i:s'));
    $action=File::addUpdateFixRecord($updated_data,$id);
    if($action){
        $notification['user_id']=sp_decryption(session()->get('admin_id'));
        $notification['title'] = "You have copied file.";
        $notification['details'] = "You have copied file.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification,0);
        session()->flash('succ_msg','File Copied Succesfully.');
    }else{
        session()->flash('fail_msg','Something Went Wrong.');
    }
    return back();
}
public function downloadfixfile(Request $request){
    $file = File::getFixRecordById($request['path']);
    $notification['user_id']=sp_decryption(session()->get('admin_id'));
    $notification['title'] = "You have downloaded ".$file->name." file.";
    $notification['details'] = "You have downloaded ".$file->name." file.";
    $notification['created_at'] = date('Y-m-d h:i:s');
    $notification['updated_at'] = date('Y-m-d h:i:s');
    Notification::addUpdateRecord($notification,0);
    $path = public_path()."/document/".$file->name.'.'.$file->ext;
    $headers = array(
              'Content-Type: application/'.$file->ext,
            );
    return Response::download($path, $file->name.'.'.$file->ext);
}
public function download(Request $request){
    $file = File::getRecordById($request['path']);
    $notification['user_id']=sp_decryption(session()->get('admin_id'));
    $notification['title'] = "You have downloaded ".$file->name." file.";
    $notification['details'] = "You have downloaded ".$file->name." file.";
    $notification['created_at'] = date('Y-m-d h:i:s');
    $notification['updated_at'] = date('Y-m-d h:i:s');
    Notification::addUpdateRecord($notification,0);
    $path = public_path()."/document/".$file->name.'.'.$file->ext;

    $headers = array(
              'Content-Type: application/'.$file->ext,
            );
    return Response::download($path, $file->name.'.'.$file->ext);
}
public function deletefixfile(Request $request){
    $id=$request['id'];
    $file = File::getFixRecordById($id);
    $updated_data = array('is_delete' =>1);
    $action=File::addUpdateFixRecord($updated_data,$id);
    if($action){
        $notification['user_id']=sp_decryption(session()->get('admin_id'));
        $notification['title'] = "You have deleted ".$file->name." file.";
        $notification['details'] = "You have deleted ".$file->name." file.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification,0);
        session()->flash('succ_msg','File Deleted Succesfully.');
    }else{
        session()->flash('fail_msg','Something Went Wrong.');
    }
    return back();
}
public function deletefile(Request $request){
    $id=$request['id'];
    $file = File::getRecordById($id);
    $updated_data = array('is_delete' =>1);
    $action=File::addUpdateRecord($updated_data,$id);
    if($action){
        $notification['user_id']=sp_decryption(session()->get('admin_id'));
        $notification['title'] = "You have deleted ".$file->name." file.";
        $notification['details'] = "You have deleted ".$file->name." file.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification,0);
        session()->flash('succ_msg','File Deleted Succesfully.');
    }else{
        session()->flash('fail_msg','Something Went Wrong.');
    }
    return back();
}
public function deletefolder(Request $request){
    $id=$request['id'];
    $folder = Folder::getRecordById($id);
    $updated_data = array('is_delete' =>1);
    $action=Folder::addUpdateRecord($updated_data,$id);
    if($action){
        $notification['user_id']=sp_decryption(session()->get('admin_id'));
        $notification['title'] = "You have deleted ".$folder->name." folder.";
        $notification['details'] = "You have deleted ".$folder->name." folder.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification,0);
        session()->flash('succ_msg','Folder Deleted Succesfully.');
    }else{
        session()->flash('fail_msg','Something Went Wrong.');
    }
    return back();
}

//Function to download the zip of full folder
public function downloadFolder(Request $request, $id) {
    $folderDetails = Folder::with(['Files', 'subFolder.Files'])->find($id);
    //Set the zip name
    $zip_file = $folderDetails->name .'.zip';
    //Initialize the zip object
    $zip = new \ZipArchive();
    //Create the new zip
    $zip->open(public_path() .'/document/'.$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
    $folder = new Folder();
    $zip = $folder->addFoldersToZip($zip, $folderDetails, $parent_id = 0, $folderDetails->name);
    $zip->close();
    // Set Header
    $headers = array(
        'Content-Type' => 'application/octet-stream',
    );
    $filetopath = public_path() .'/document/'.$zip_file;
    // Create Download Response
    if(file_exists($filetopath)){
        return response()->download($filetopath,$zip_file,$headers)->deleteFileAfterSend(true);;
    }
}

}
