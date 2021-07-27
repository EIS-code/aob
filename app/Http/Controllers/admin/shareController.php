<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\admin\Share;
use App\admin\Notification;
use App\admin\File;
use App\admin\Folder;
use DB;
use Validator;
use Carbon\Carbon;

class shareController extends Controller
{
    public function index(Request $request){
        $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
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
                                ->where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ])
                                ->get();
        if(isset($request['search'])){
            $data['sharefile'] = Share::recentsharefile($request['s']);
            
            $data['sharefolder'] = Share::recentsharefolder($request['s']);
        }else{
            $data['sharefile'] = Share::recentsharefile();
            $data['sharefolder'] = Share::recentsharefolder();
        }
        $data['imagefile']=File::getTotalImageFile();
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
        $data['page']='share';
        return view('admin.share')->with('data',$data);
    }
    public function sharewithuser(Request $request){
        $rules = [
            'usershare' => 'required',
            'activation_date' => 'required|before-or-equal:expiration_date',
            'expiration_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'usershare.required' => 'Please select the users.'
        ]);
        if ($validator->fails()) {
            session()->flash('fail_msg', $validator->errors()->first());
            return redirect()->back();
        }
        $clear_data['is_delete']=1;
        //Share::clearRecordBySharedFolder1($request['shared_id'],$request['type'],$clear_data);
        if($request['usershare']){
            foreach ($request['usershare'] as $key => $user){
        		$id=0;
        		$updated_data = array('user_id' =>$user,'type' =>$request['type'],'shared_id' =>$request['shared_id'],'created_at'=>date('Y-m-d h:i:s'), 'activation_date' => Carbon::parse($request->activation_date), 'expiration_date' => Carbon::parse($request->expiration_date));
    	    	Share::addUpdateRecord($updated_data,$id);
        	}
        	if($request['type']=='folder'){
                $folder = Folder::getRecordById($request['shared_id']);
    	        session()->flash('succ_msg','Folder shared succesfully.');
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have shared a folder '".$folder->name."' with users succesfully.";
                $notification['details'] = "You have shared a folder '".$folder->name."' with users succesfully.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
        	}else{
                $file = File::getRecordById($request['shared_id']);
                session()->flash('succ_msg','File shared succesfully.');
        	   $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have shared a file '".$file->name."' with users succesfully.";
                $notification['details'] = "You have shared a file '".$file->name."' with users succesfully.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
            }
        }else{
	        session()->flash('fail_msg','Please select a user.');
        }
        return back();
    }
    public function sharewithteam(Request $request){
        $rules = [
            'teamshare' => 'required',
            'activation_date' => 'required|before-or-equal:expiration_date',
            'expiration_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'teamshare.required' => 'Please select the team.'
        ]);
        if ($validator->fails()) {
            session()->flash('fail_msg', $validator->errors()->first());
            return redirect()->back();
        }
        $clear_data['is_delete']=1;
        //Share::clearRecordBySharedFolder($request['shared_id'],$request['type'],$clear_data);
    	if($request['teamshare']){
            foreach ($request['teamshare'] as $key => $team){
        		$id=0;
        		$updated_data = array('team_id' =>$team,'type' =>$request['type'],'shared_id' =>$request['shared_id'],'created_at'=>date('Y-m-d h:i:s'), 'activation_date' => Carbon::parse($request->activation_date), 'expiration_date' => Carbon::parse($request->expiration_date));
    	    	Share::addUpdateRecord($updated_data,$id);
        	}
        	if($request['type']=='folder'){
                $folder = Folder::getRecordById($request['shared_id']);
    	        session()->flash('succ_msg','Folder shared succesfully.');
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have shared a folder '".$folder->name."' with team succesfully.";
                $notification['details'] = "You have shared a folder '".$folder->name."' with team succesfully.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
        	}else{
                $file = File::getRecordById($request['shared_id']);
    	        session()->flash('succ_msg','File shared succesfully.');
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have shared a file '".$file->name."' with team succesfully.";
                $notification['details'] = "You have shared a file '".$file->name."' with team succesfully.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
        	}
        }else{
            session()->flash('fail_msg','Please select a team.');
        }
        return back();
    }

    public function removeUserFromSharing($userId, $folderId, $folderType, $type) {
        if($type == "user") {
            DB::table('sharing')->where('user_id', $userId)->where('shared_id', $folderId)->where('type', $folderType)->delete();
        } else {
            DB::table('sharing')->where('team_id', $userId)->where('shared_id', $folderId)->where('type', $folderType)->delete();
        }
        
        session()->flash('succ_msg','Access removed.');
        return back();        
    }

    public function changeUserFromSharing(Request $request, $userId, $folderId, $folderType, $type) {

        $dataUpdate = [
            'activation_date' => Carbon::parse($request['act-date']),
            'expiration_date' => Carbon::parse($request['exp-date']),
        ];

        if($type == "user") {
            DB::table('sharing')->where('user_id', $userId)->where('shared_id', $folderId)->where('type', $folderType)->update($dataUpdate);
        } else {
            DB::table('sharing')->where('team_id', $userId)->where('shared_id', $folderId)->where('type', $folderType)->update($dataUpdate);
        }
        
        session()->flash('succ_msg','Access changed.');
        return back();        
    }

    public function removeUserFromSharingProfile($id) {
        DB::table('sharing')->where('id', $id)->delete();
        
        session()->flash('succ_msg','Access removed.');
        return back();        
    }

    public function changeUserFromSharingProfile(Request $request, $id) {

        $dataUpdate = [
            'activation_date' => Carbon::parse($request['act-date']),
            'expiration_date' => Carbon::parse($request['exp-date']),
        ];

        DB::table('sharing')->where('id', $id)->update($dataUpdate);
        session()->flash('succ_msg','Access changed.');
        return back();        
    }
}
