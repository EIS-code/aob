<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\admin\User;
use App\admin\Chat;
use App\admin\File;
use App\admin\Notification;

class chatController extends Controller
{
    public function index(Request $request){
        $data['user'] = DB::table(CUSTOMER_TABLE)->where([['id',sp_decryption(session()->get('user_id'))], ['role_id',  2]])->get()->first();
        $data['page']='questionnaire';
        $data['users'] =  DB::table(CUSTOMER_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('user_id'))] ])
                                ->get();
        $data['teams'] =  DB::table(TEAM_TABLE)
                                ->where([ ['is_active','=',1],['is_delete','=',0] ])
                                ->get();
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['movefolders'] =	DB::table(FOLDER_TABLE)
    							->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id as folderid')
    							->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
    							->where([ [FOLDER_TABLE.'.parent_id','=',0],[FOLDER_TABLE.'.is_delete','=',0] ])
    							->groupBy(FOLDER_TABLE.'.name')
    							->get();
                                
        //Get users data based on chat
        $user_id = sp_decryption(session()->get('user_id'));
        $send_users = Chat::where('is_delete', 0)
                            ->where(function ($q) use ($user_id) {
                                $q->where('fromid', $user_id)
                                    ->orWhere('toid', $user_id);
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
        $user_list = array();
        $unread_messages_count = 0;
        //To set the users as per created time
        foreach($send_users as $key => $user) {
            if($user->fromid == sp_decryption(session()->get('user_id'))) {
                $id = $user->toid;
            } else {
                if($user->is_read == 0) {
                    $unread_messages_count = $unread_messages_count + 1; 
                }
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
        //Get all users from chats
        $users = User::where([ ['is_active','=',1],['is_delete','=',0],['role_id','!=', 2]]);

        if(!empty($user_list)) {
            $users->whereIn('id', array_keys($user_list))
            ->orderByRaw("field(id,".implode(',',array_keys($user_list)).")");
        }

        //Get those users who are not available in chat
        $remaining_users = User::where([ ['is_active','=',1],['is_delete','=',0],['role_id','!=', 2] ])
        ->whereNotIn('id', array_keys($user_list));

        //Search query 
        if(isset($request['search'])){
            $users = $users->where(CUSTOMER_TABLE.'.name','LIKE','%'.$request['s'].'%')->get();
            $remaining_users = $remaining_users->where(CUSTOMER_TABLE.'.name','LIKE','%'.$request['s'].'%')->get();
            $data['users'] = $users->merge($remaining_users);
        }else{
            $users = $users->get();
            $remaining_users = $remaining_users->get();
            $data['users'] = $users->merge($remaining_users);
        }
        $users_data = array();
        foreach($data['users'] as $userKey => $userValue) {
            $unReadMessages = Chat::where('is_delete', 0)->where('fromid', $userValue->id)->where('toid', $user_id)->where('is_read', 0)->count();
            $userValue['userUnreadMessages'] = $unReadMessages;
            $users_data[] = $userValue;
        }
        $data['users'] = $users_data;
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['imagefile']=File::getTotalImageFile();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
    	$data['page']='chats';
        $data['unread_messages']= $unread_messages_count;
    	return view('user.chats')->with('data',$data);
    }
    public function sendMessage(Request $request){
    	$validatedData=$request->validate([
    		'toid'=>'required',
    		'msg'=>'required',
    	]);

    	if(!empty($request['id'])){
    		$id=$request['id'];
    		$updated_data = array('fromid'=>sp_decryption(session()->get('user_id')),'toid' =>$request['toid'],'messages' =>$request['msg'],'updated_at'=>date('Y-m-d h:i:s'));
    	}else{
    		$id=0;
    		$updated_data = array('fromid'=>sp_decryption(session()->get('user_id')),'toid' =>$request['toid'],'messages' =>$request['msg'],'created_at'=>date('Y-m-d h:i:s'));
    	}
    	Chat::addUpdateRecord($updated_data,$id);
    	$data['status']=200;
    	$data['code']=1;
    	$data['msg']='Message Sent Successfully.';
    	echo json_encode($data);
    }
}
