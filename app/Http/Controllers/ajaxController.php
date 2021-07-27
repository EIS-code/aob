<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ajaxModel;
use App\admin\User;
use App\admin\Chat;
use App\admin\Folder;
use App\admin\File;
use App\admin\Team;
use DB;
use App\admin\HrFolder;
use App\admin\HrFolderLink;
use Carbon\Carbon;

class ajaxController extends Controller
{
    public function getuserdetails(Request $request){
        $users = User::getRecordById($request['userid']);
        $data['status']=200;
        $data['code']=1;
        $data['user']=$users;
        
        $sharedFiles = DB::table(SHARE_TABLE)->where('user_id',$request['userid'])->where("is_delete",0)->get();
        $folderArray = $fileArray = [];

        if(!empty($sharedFiles)) {
            $i = $j = 0;
            foreach($sharedFiles as $key => $value) {
                if($value->type == 'folder') {
                    $getFoderDetails = Folder::where("id",$value->shared_id)->where("is_delete",0)->where("final_delete",0)->first();
                    if(!empty($getFoderDetails)) {
                        $folderArray[$i] = $getFoderDetails;
                        $folderArray[$i]['activation_date'] = $value->activation_date;
                        $folderArray[$i]['expiration_date'] = $value->expiration_date;
                        $folderArray[$i]['share_table_id'] = $value->id;
                        $i++;
                    }
                } else {
                    $getFileDetails = File::where("id",$value->shared_id)->where("is_delete",0)->where("final_delete",0)->first();
                    if(!empty($getFileDetails)) {
                        $fileArray[$j] = $getFileDetails;
                        $fileArray[$j]['activation_date'] = $value->activation_date;
                        $fileArray[$j]['expiration_date'] = $value->expiration_date;
                        $fileArray[$i]['share_table_id'] = $value->id;
                        $j++;
                    }
                }
                
            }
        }

        $data['sharedFolders'] = $folderArray;
        $data['sharedFiles'] = $fileArray;
        $returnHTML = view('admin.shareduserview')->with('data', $data)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));

        echo json_encode($data);
    }
    public function getSubFolder(Request $request){
    	$subfolders = ajaxModel::getSubFolder($request['folderid']);
    	$data['status']=200;
    	$html = '';
    	if(count($subfolders)>0){
    		$data['code']=1;
    		foreach ($subfolders as $subfolder) {
    			$html.='<tr><td><a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="'.SYSTEM_SITE_URL.'assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="'.$subfolder->folderid.'" onclick="openSubFolder('.$subfolder->folderid.')" name="move"/><strong>'.$subfolder->name.'</strong><a></a><ul id="subfolder_'.$subfolder->folderid.'"></ul></td></tr>';
    		}
    		$data['html']=$html;
    	}else{
    		$data['code']=0;
    	}
    	echo json_encode($data);
    }
    public function getCopySubFolder(Request $request){
    	$subfolders = ajaxModel::getSubFolder($request['folderid']);
    	$data['status']=200;
    	$html = '';
    	if(count($subfolders)>0){
    		$data['code']=1;
    		foreach ($subfolders as $subfolder) {
    			$html.='<tr><td><a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="'.SYSTEM_SITE_URL.'assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="'.$subfolder->folderid.'" onclick="openSubFolder('.$subfolder->folderid.')" name="copy"/><strong>'.$subfolder->name.'</strong><a></a><ul id="subfolder_'.$subfolder->folderid.'"></ul></td></tr>';
    		}
    		$data['html']=$html;
    	}else{
    		$data['code']=0;
    	}
    	echo json_encode($data);
    }

	// Function to get the updated users chat list based on message send or recieve
	public function getUpdatedUsersList(Request $request){
    	$admin_id = sp_decryption(session()->get('admin_id'));

        //Get all users those have chat history
        $send_users = Chat::where('is_delete', 0)
                            ->where(function ($q) use ($admin_id) {
                                $q->where('fromid', $admin_id)
                                    ->orWhere('toid', $admin_id);
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $user_list = array();
        //To set the users based on message created
        foreach($send_users as $key => $user) {
            if($user->fromid == sp_decryption(session()->get('admin_id'))) {
                $id = $user->toid;
            } else {
                $id = $user->fromid;
            }
            if(array_key_exists($id, $user_list)) {
                if(strtotime($user_list[$id]) < strtotime($user->created_at)) {
                    unset($user_list[$id]);
                    $user_list[$id] = $user->created_at; 
                }
            } else {
                $user_list[$id] = $user->created_at;
            }
        }
        //Get user details
        $users = User::where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ]);
        //Set users desc order
        if(!empty($user_list)) {
            $users->whereIn('id', array_keys($user_list))
            ->orderByRaw("field(id,".implode(',',array_keys($user_list)).")");
        }
        //Fetch users who has not chat history
        $remaining_users = User::where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ])
                        ->whereNotIn('id', array_keys($user_list));

        //Search users data
        if(isset($request['search'])) {
            $users = $users->where(CUSTOMER_TABLE.'.name','LIKE','%'.$request['search'].'%')->get();
            $remaining_users = $remaining_users->where(CUSTOMER_TABLE.'.name','LIKE','%'.$request['search'].'%')->get();
        } else {
            $users = $users->get();
            $remaining_users = $remaining_users->get();
        }
        
        //To get the recent chat of user and set the message sending time
        foreach($users as $key => $user) {
            $recent_chat = Chat::getLastChatByUser(sp_decryption(session()->get('admin_id')),$user->id);
            $users[$key]['recent_chat'] = $recent_chat;
            if(!empty($recent_chat)) {
                $time2 = date('Y-m-d h:i:s');
                $time1 = strtotime($recent_chat->created_at);
                $time2 = strtotime($time2);
                $difference = ($time2 - $time1);
                $min = (int) $difference;
                $interval = '';
                if($min > (3600*24)){
                    $time = $min/(3600*24);
                    $day = (int)$time;
                    $interval = $day.' Days ago';
                }elseif($min > 3600){
                    $time = $min/3600;
                    $day = (int)$time;
                    $interval = $day.' Hours ago';
                }elseif($min > 60){
                    $time = $min/60;
                    $day = (int)$time;
                    $interval = $day.' Min ago';
                }else{
                    $interval = $min.' Second ago';
                }
            }
            $users[$key]['interval'] = $interval;
        }
        $all_users = $users->merge($remaining_users);
    	$data['status'] = 200;
    	$data['code'] = 1;
    	$data['msg'] = 'Users fetched Successfully.';
        $data['data'] = $all_users;
    	echo json_encode($data);
    }

    //Function to set the message count
    public function readMessages(Request $request) {
        $logged_id = sp_decryption(session()->get('admin_id'));
        $id = $request->id;
        $count = $request->count;
        //Get users chat which have unread messages from $id
        $chats = Chat::where('is_delete', 0)
                        ->where('fromid', $id)
                        ->where('toid', $logged_id)
                        ->where('is_read', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();

        if(!$chats->isEmpty()) {
            $count = $count - count($chats);
            foreach($chats as $key => $chat) {
                $chats = Chat::find($chat->id);
                $chats->is_read = 1;
                $chats->save();
            }
        }
        
        $data['status'] = 200;
    	$data['code'] = 1;
        $data['count'] = $count;
    	echo json_encode($data);
    }

    public function getSharedUserDetails(Request $request){
        if($request['datatYpe'] == "folder") {
            $getFoderDetails = Folder::where("id",$request['id'])->where("is_delete",0)->where("final_delete",0)->first();
            $sharedFiles = DB::table(SHARE_TABLE)->where('shared_id',$request['id'])->where("type", "folder")->where("is_delete",0)->get();
            $data['folderId'] = $getFoderDetails->id;
            $data['type'] = "folder";
        } else {
            $getFoderDetails = File::where("id",$request['id'])->where("is_delete",0)->where("final_delete",0)->first();
            $sharedFiles = DB::table(SHARE_TABLE)->where('shared_id',$request['id'])->where("type", "file")->where("is_delete",0)->get();

            $data['folderId'] = $getFoderDetails->id;
            $data['type'] = "file";
        }
        
        $i = $j = 0;
        $teamName = $userNames = [];
        if(!empty($sharedFiles)) {
            foreach($sharedFiles as $value) {
                if(!empty($value->team_id)) {
                    $teamDetails = Team::where("id", $value->team_id)->where("is_delete", 0)->first();
                    if(!empty($teamDetails)) {
                        $teamName[$i] = $teamDetails;
                        $teamName[$i]['activation_date'] = $value->activation_date;
                        $teamName[$i]['expiration_date'] = $value->expiration_date;
                        $i++;
                    }
                    
                } else {
                    $teamDetails = User::where("id", $value->user_id)->where("is_delete", 0)->first();
                    if(!empty($teamDetails)) {
                        $userNames[$j] = $teamDetails;
                        $userNames[$j]['activation_date'] = $value->activation_date;
                        $userNames[$j]['expiration_date'] = $value->expiration_date;
                        $j++;
                    }
                }
            }
        }
        
        $data['folderName'] = $getFoderDetails->name;
        $data['sharedTeams'] = $teamName;
        $data['sharedUsers'] = $userNames;
        $data['status']=200;
        $data['code']=1;

        $returnHTML = view('admin.sharedview')->with('data', $data)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
        
        echo json_encode($data);
    }

    // Function to get the updated users chat list based on message send or recieve for users
	public function getUpdatedUsersListForUsers(Request $request){
    	$user_id = sp_decryption(session()->get('user_id'));

        //Get all users those have chat history
        $send_users = Chat::where('is_delete', 0)
                            ->where(function ($q) use ($user_id) {
                                $q->where('fromid', $user_id)
                                    ->orWhere('toid', $user_id);
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $user_list = array();
        //To set the users based on message created
        foreach($send_users as $key => $user) {
            if($user->fromid == sp_decryption(session()->get('user_id'))) {
                $id = $user->toid;
            } else {
                $id = $user->fromid;
            }
            if(array_key_exists($id, $user_list)) {
                if(strtotime($user_list[$id]) < strtotime($user->created_at)) {
                    unset($user_list[$id]);
                    $user_list[$id] = $user->created_at; 
                }
            } else {
                $user_list[$id] = $user->created_at;
            }
        }
        //Get user details
        $users = User::where([ ['is_active','=',1],['is_delete','=',0],['role_id','!=', 2] ]);
        //Set users desc order
        if(!empty($user_list)) {
            $users->whereIn('id', array_keys($user_list))
            ->orderByRaw("field(id,".implode(',',array_keys($user_list)).")");
        }
        //Fetch users who has not chat history
        $remaining_users = User::where([ ['is_active','=',1],['is_delete','=',0],['role_id','!=', 2] ])
                        ->whereNotIn('id', array_keys($user_list));

        //Search users data
        if(isset($request['search'])) {
            $users = $users->where(CUSTOMER_TABLE.'.name','LIKE','%'.$request['search'].'%')->get();
            $remaining_users = $remaining_users->where(CUSTOMER_TABLE.'.name','LIKE','%'.$request['search'].'%')->get();
        } else {
            $users = $users->get();
            $remaining_users = $remaining_users->get();
        }
        
        //To get the recent chat of user and set the message sending time
        foreach($users as $key => $user) {
            $recent_chat = Chat::getLastChatByUser(sp_decryption(session()->get('user_id')),$user->id);
            $users[$key]['recent_chat'] = $recent_chat;
            if(!empty($recent_chat)) {
                $time2 = date('Y-m-d h:i:s');
                $time1 = strtotime($recent_chat->created_at);
                $time2 = strtotime($time2);
                $difference = ($time2 - $time1);
                $min = (int) $difference;
                $interval = '';
                if($min > (3600*24)){
                    $time = $min/(3600*24);
                    $day = (int)$time;
                    $interval = $day.' Days ago';
                }elseif($min > 3600){
                    $time = $min/3600;
                    $day = (int)$time;
                    $interval = $day.' Hours ago';
                }elseif($min > 60){
                    $time = $min/60;
                    $day = (int)$time;
                    $interval = $day.' Min ago';
                }else{
                    $interval = $min.' Second ago';
                }
            }
            $users[$key]['interval'] = $interval;
        }
        $all_users = $users->merge($remaining_users);
        $users_data = array();
        foreach($all_users as $userKey => $userValue) {
            $unReadMessages = Chat::where('is_delete', 0)->where('fromid', $userValue->id)->where('toid', $user_id)->where('is_read', 0)->count();
            $userValue['userUnreadMessages'] = $unReadMessages;
            $users_data[] = $userValue;
        }
    	$data['status'] = 200;
    	$data['code'] = 1;
    	$data['msg'] = 'Users fetched Successfully.';
        $data['data'] = $users_data;
    	echo json_encode($data);
    }

    //Function to set the message count
    public function readUserMessages(Request $request) {
        $logged_id = sp_decryption(session()->get('user_id'));
        $id = $request->id;
        $count = $request->count;
        //Get users chat which have unread messages from $id
        $chats = Chat::where('is_delete', 0)
                        ->where('fromid', $id)
                        ->where('toid', $logged_id)
                        ->where('is_read', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();

        if(!$chats->isEmpty()) {
            $count = $count - count($chats);
            foreach($chats as $key => $chat) {
                $chats = Chat::find($chat->id);
                $chats->is_read = 1;
                $chats->save();
            }
        }
        
        $data['status'] = 200;
    	$data['code'] = 1;
        $data['count'] = $count;
    	echo json_encode($data);
    }
    
    
    function generateRandomString($length, $id) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $check = HrFolderLink::where('random_string', $randomString.$id)->first();

        if (empty($check)) {
            return $randomString;
        } else {
            return $this->generateRandomString(10, $id);
        }
        return $randomString;
    }
    
    public function generateLink(Request $request, $getFoderDetails) {

        $randomKey = $this->generateRandomString(10, $request['id']);

        $data['folderName'] = $getFoderDetails->name;
        $data['link'] = SYSTEM_SITE_URL . 'user/hr/form/' . $randomKey . $getFoderDetails->id;

        $linkData = [
            'folder_id' => $getFoderDetails->id,
            'random_string' => $randomKey . $getFoderDetails->id,
            'date_time' => (string)strtotime(Carbon::now()) * 1000
        ];
        $linkModel = new HrFolderLink();
        $checks = $linkModel->validator($linkData);
        if ($checks->fails()) {
            return response()->json(array('success' => false, 'msg' => $checks->errors()->first()));
        }
        HrFolderLink::create($linkData);
        return $data;
    }

    public function getSharableLink(Request $request) {
        
        $is_exist = HrFolderLink::where(['folder_id' => $request['id'], 'is_expired' => '0'])->first();
        $getFoderDetails = HrFolder::where("id", $request['id'])->where("is_delete",0)->where("final_delete",0)->first();
        
        if(!empty($is_exist)) {
            
            $to = $to = Carbon::createFromTimestampMs($is_exist->date_time);
            $from = Carbon::now();
            $diff_in_hours = $to->diffInHours($from);

            if($diff_in_hours >= LINK_EXPIRED_LIMIT) {
                $is_exist->update(['is_expired' => '1']);
                $data['folderName'] = $getFoderDetails->name;
                $data['link'] = 'Current link is expired, please create new link!!';
            } else {
                
                $data['folderName'] = $getFoderDetails->name;
                $data['link'] = SYSTEM_SITE_URL.'user/hr/form/'.$is_exist->random_string;
            }
        } else {
            
            $data = $this->generateLink($request, $getFoderDetails);
        }
        $returnHTML = view('admin.linkview')->with('data', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
    
    public function generateNewLink(Request $request) {

        $getFoderDetails = HrFolder::where("id", $request['id'])->where("is_delete", 0)->where("final_delete", 0)->first();
        $old_links = HrFolderLink::where(['folder_id' => $request['id'], 'is_expired' => '0'])->get();
        foreach ($old_links as $key => $oldLink) {
            $oldLink->update(['is_expired' => '1']);
        }
        $data = $this->generateLink($request, $getFoderDetails);
        $returnHTML = view('admin.linkview')->with('data', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

}
