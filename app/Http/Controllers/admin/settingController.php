<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\Team;
use App\admin\User;
use App\admin\File;
use App\admin\Notification;
use App\admin\QuestionnaireFolders;
use Validator;
use App\admin\TeamMember;

class settingController extends Controller
{
    public function index(Request $request){

        $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
        $data['movefolders'] =  DB::table(FOLDER_TABLE)
                                ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id as folderid')
                                ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                ->where([ [FOLDER_TABLE.'.parent_id','=',0],[FOLDER_TABLE.'.is_delete','=',0] ])
                                ->groupBy(FOLDER_TABLE.'.name')
                                ->get();
        
        if(isset($request['team_search'])){
            $query =  DB::table(TEAM_TABLE)
                            ->where([ ['is_active','=',1],['is_delete','=',0] ])
                            ->where('team_name','LIKE','%'.$request['ts'].'%');
            
            if(isset($request['team_sorting'])) {
                if($request['team_sorting'] == 1) {
                    $query->orderBy("created_at", 'DESC');    
                } else if ($request['team_sorting'] == 2) {
                    $query->orderBy("team_name", 'ASC');    
                } else {
                    $query->orderBy("team_name", 'DESC');    
                }
            } else {
                $query->orderBy("created_at", 'DESC');
            }


            $data['teams'] = $query->get();
        } 
        else{
            $query =  DB::table(TEAM_TABLE)
                            ->where([ ['is_active','=',1],['is_delete','=',0] ]);
                            
            if(isset($request['team_sorting'])) {
                if($request['team_sorting'] == 1) {
                    $query->orderBy("created_at", 'DESC');    
                } else if ($request['team_sorting'] == 2) {
                    $query->orderBy("team_name", 'ASC');    
                } else {
                    $query->orderBy("team_name", 'DESC');    
                }
            } else {
                $query->orderBy("created_at", 'DESC');
            }

            $data['teams'] = $query->get();
        }

        if(isset($request['user_search'])){
            $query =  DB::table(CUSTOMER_TABLE)
                            ->where('name','LIKE','%'.$request['us'].'%')
                            ->where([ ['is_active','=',1],['is_delete','=',0],['role_id','=',2] ]);
            if(isset($request['user_sorting'])) {
                if($request['user_sorting'] == 1) {
                    $query->orderBy("created_at", 'DESC');    
                } else if ($request['user_sorting'] == 2) {
                    $query->orderBy("name", 'ASC');    
                } else {
                    $query->orderBy("name", 'DESC');    
                }
            } else {
                $query->orderBy("created_at", 'DESC');
            }                
            
            $data['users'] = $query->get();
        }
        
        else{
            $query =  DB::table(CUSTOMER_TABLE)
                            ->where([ ['is_active','=',1],['is_delete','=',0],['role_id','=',2] ]);
            if(isset($request['user_sorting'])) {
                if($request['user_sorting'] == 1) {
                    $query->orderBy("created_at", 'DESC');    
                } else if ($request['user_sorting'] == 2) {
                    $query->orderBy("name", 'ASC');    
                } else {
                    $query->orderBy("name", 'DESC');    
                }
            } else {
                $query->orderBy("created_at", 'DESC');
            }
            $data['users'] = $query->get();
        }

        if(isset($request['usearch'])){
            $data['recentfiles']=File::getRecentFile($request['ups']);
        }else{
            $data['recentfiles']=File::getRecentFile();
        }
        
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['imagefile']=File::getTotalImageFile();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
    	$data['page']='setting';
        $model = Team::find(1);
    	return view('admin.settings')->with('data',$data);
    }
    public function addupdateteam(Request $request){
    	$validatedData=$request->validate([
    		'name'=>'required',
    	]);

        if(!empty($request['id'])){
    		$id=$request['id'];
    		$updated_data = array('team_name' =>$request['name']);
    	}else{
    		$id=0;
    		$updated_data = array('team_name' =>$request['name'],'created_at'=>date('Y-m-d h:i:s'));
    	}

    	$action=Team::addUpdateRecord($updated_data,$id);
    	if($action){
    		if($id==0){
    			session()->flash('succ_msg','Team Added Succesfully.');
    		}else{
    			session()->flash('succ_msg','Team Updated Succesfully.');
    		}
    	}else{
    		session()->flash('fail_msg','Something Went Wrong.');
    	}
    	return redirect('admin/setting');
    }
    public function addupdateuser(Request $request){
    	$validatedData=$request->validate([
    		'name'=>'required',
    		'email'=>'required',
    		'mobile'=>'required',
    		'password'=>'required',
    	]);

        if(!empty($request['id'])){
    		$id=$request['id'];
    		$updated_data = array('name' =>$request['name'],'email' =>$request['email'],'phone' =>$request['mobile'],'password' =>md5($request['password']),'updated_at'=>date('Y-m-d h:i:s'));
            $action = User::addUpdateRecord($updated_data,$id);
    	}else{
            $check_user = User::getRecordByEmail($request['email']);
            if($check_user){
                session()->flash('fail_msg','Email Address already exists.');
                return redirect('admin/setting?active=users');
                die();
            }else{
        	  $id=0;
    		  $updated_data = array('name' =>$request['name'],'email' =>$request['email'],'phone' =>$request['mobile'],'password' =>md5($request['password']),'created_at'=>date('Y-m-d h:i:s'));
              $action = User::create($updated_data);
            }
    	}

    	if($action){
    		if($id==0){
                //Create the user folder in queationnaire
                $questionnairefolder = new QuestionnaireFolders();
                $questionnairefolder->name = $updated_data['name'];
                $questionnairefolder->created_for = $action->id;
                $questionnairefolder->created_by = sp_decryption(session()->get('admin_id'));
                $questionnairefolder->save();
    			session()->flash('succ_msg','User Added Succesfully.');
    		}else{
    			session()->flash('succ_msg','User Updated Succesfully.');
    		}
    	}else{
    		session()->flash('fail_msg','Something Went Wrong.');
    	}
    	return redirect('admin/setting?active=users');
    }
    public function addteamuser(Request $request){
        $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
    	$data['team'] = Team::getRecordByUser($request->id);
    	$data['team_id'] = $request->id;

        if(isset($request['search'])){
           $data['team_members'] = Team::getMembersByTeam($request->id,$request['s']);
        }else{
    	   $data['team_members'] = Team::getMembersByTeam($request->id);
        }
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
                                ->where([ ['is_active','=',1],['is_delete','=',0],['role_id','=',2] ])
                                ->get();
    	$data['page']='setting';
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['imagefile']=File::getTotalImageFile();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
    	return view('admin.teammembers')->with('data',$data);
    }

    public function removeuser(Request $request){
        $add_data['is_delete']=1;
        User::addUpdateRecord($add_data,$request['id']);

        TeamMember::removeUserFromTeam($request['id']);
        session()->flash('succ_msg','User Removed Succesfully.');
        return back();
    }
    public function removefromteam(Request $request){
        $add_data['is_delete']=1;
        Team::memberAddUpdateRecord($add_data,$request['id']);
        session()->flash('succ_msg','User Removed From Team Succesfully.');
        return back();
    }
    public function addteamwithuser(Request $request){

        
        $validatedData=$request->validate([
            'team_name'=>'required',
        ]);
        if($request['useradd']){
            if(isset($_FILES['fileToUpload'])){
                if($_FILES['fileToUpload']['name']!=''){
                    $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if($ext=='png' || $ext=='jpeg' || $ext=='jpg'){
                        $file_name = 'team_'.$_FILES['fileToUpload']['name'];
                        $target_file = $_SERVER["DOCUMENT_ROOT"].ROOT_PATH.'public/team/';
                        $size = (filesize($_FILES["fileToUpload"]["tmp_name"]))/1024; //KB
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.$file_name);
                        $data['document_size']=$size;
                        $profile_picture = $file_name;
                    }else{
                        $profile_picture = 'user.png';
                    }
                }else{
                    $profile_picture = 'user.png';
                }
            }else{
                $profile_picture = 'user.png';
            }

            $id=0;
            $updated_data = array('profile_picture'=>$profile_picture,'team_name' =>$request['team_name'],'created_at'=>date('Y-m-d h:i:s'));
            $team_id=Team::addUpdateRecord($updated_data,$id);
            $id=$team_id;
            foreach ($request['useradd'] as $value) {
                $add_data['team_id']=$id;
                $add_data['user_id']=$value;
                Team::memberAddUpdateRecord($add_data,0);
            }
            $updated_data = array('members' =>implode(',', $request['useradd']) );
            $action=Team::addUpdateRecord($updated_data,$id);
            if($action){
                $notification['user_id']=sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have added a team and members.";
                $notification['details'] = "You have added a team and members.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification,0);
                session()->flash('succ_msg','Team with Member Added Succesfully.');
            }else{
                session()->flash('fail_msg','Something Went Wrong.');
            }
        }else{
            session()->flash('fail_msg','Please select user first.');
        }
        return back();
    }
    public function addteammember(Request $request){
        $id=$request['team_id'];
        $clear_data['is_delete']=1;
        $action=Team::clearRecordByTeam($id,$clear_data);
        if($request['addmember']){
            foreach ($request['addmember'] as $value) {
                $add_data['team_id']=$id;
                $add_data['user_id']=$value;
                Team::memberAddUpdateRecord($add_data,0);
            }
            $updated_data = array('members' =>implode(',', $request['addmember']) );
            $action=Team::addUpdateRecord($updated_data,$id);
            if($action){
                session()->flash('succ_msg','Team Members Added Succesfully.');
            }else{
                session()->flash('fail_msg','Something Went Wrong.');
            }
        }else{
            session()->flash('succ_msg','Team member removed');
        }
        return back();
    }
    public function submitteamuser(Request $request){
    	$data['team'] = Team::getRecordByUser($request->id);
    	$data['team_id'] = $request->id;
    	$data['team_members'] = Team::getMembersByTeam($request->id);
    	$data['users'] = User::get();
    	$data['page']='setting';
    	return view('admin.teammembers')->with('data',$data);
    }

    public function addUsersToTeams(Request $request){
        $rules = [
            'users.*' => 'required',
            'addmember' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'users.*.required' => 'Please select the users.',
            'addmember.required' => 'Please select the teams.'
        ]);
        if ($validator->fails()) {
            session()->flash('fail_msg', $validator->errors()->first());
            return redirect()->back();
        }
        $users = explode(',', $request->users[0]);
        foreach($request->addmember as $key => $team) {
            foreach($users as $user_key => $user) {
                $teamMembers = TeamMember::updateOrCreate(
                    ['team_id' => $team, 'user_id' => $user],
                    ['team_id' => $team, 'user_id' => $user, 'is_delete' => 0, 'is_active' => 1]
                );
            }
        }
        session()->flash('succ_msg','Team Members Added Succesfully.');
        return back();
    }
}
