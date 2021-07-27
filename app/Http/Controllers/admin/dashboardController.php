<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\Folder;
use App\admin\File;
use App\admin\User;
use App\admin\Notification;
use \Response;
use App\admin\Team;

class dashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
        $data['movefolders'] =  DB::table(FOLDER_TABLE)
                                ->select(FOLDER_TABLE.'.*',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id as folderid')
                                ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
                                ->where([ [FOLDER_TABLE.'.parent_id','=',0],[FOLDER_TABLE.'.is_delete','=',0] ])
                                ->groupBy(FOLDER_TABLE.'.name')
                                ->get();
        $data['allfolders'] = Folder::where('is_delete',0)->get();
        
        if(isset($request['search'])){
            $data['recentfolders'] = Folder::recentFolder($request['s']);
            $data['folders'] = Folder::folderWithFileCount($request['s']);
            $data['fixfolders'] = Folder::fixfolderWithFileCount($request['s']);
            $data['teams'] =  DB::table(TEAM_TABLE)->where([ ['is_active','=',1],['is_delete','=',0] ])->where(TEAM_TABLE.'.team_name','LIKE','%'.$request['s'].'%')->get();
            $data['users'] =  DB::table(CUSTOMER_TABLE)->where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ])->where(CUSTOMER_TABLE.'.name','LIKE','%'.$request['s'].'%')->get();
        }else{
            $data['recentfolders'] = Folder::recentFolder();
            $data['folders'] = Folder::folderWithFileCount();
            $data['fixfolders'] = Folder::fixfolderWithFileCount();
            $data['teams'] =  DB::table(TEAM_TABLE)->where([ ['is_active','=',1],['is_delete','=',0] ])->get();
            $data['users'] =  DB::table(CUSTOMER_TABLE)->where([ ['is_active','=',1],['is_delete','=',0],['id','!=',sp_decryption(session()->get('admin_id'))] ])->get();
        }

        $data['fixfilecount']=File::getfixfilecount();
        $data['recentnotifications']=Notification::getrecentnotification();
        $data['imagefile']=File::getTotalImageFile();
        $data['documentfile']=File::getTotalDocumentFile();
        $data['mediafile']=File::getTotalMediaFile();
        $data['otherfile']=File::getTotalOtherFile();
        $model = Team::find(1);
    	$data['page']='dashboard';
    	return view('admin.dashboard')->with('data',$data);
    }
    public function updateprofile(Request $request){

        if($_FILES['fileToUpload']['name']!=''){
            $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            if($ext=='png' || $ext=='jpeg' || $ext=='jpg'){
                $file_name = $_FILES['fileToUpload']['name'];
                $target_file = $_SERVER["DOCUMENT_ROOT"].ROOT_PATH.'public/users/';
                $size = (filesize($_FILES["fileToUpload"]["tmp_name"]))/1024; //KB
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.$file_name);
                $image = $file_name;
            }else{
                $image = $request['image_file'];
            }
        }else{
            $image = $request['image_file'];
        }

        if(isset($request['reminder_email'])){
            $reminder_email = 1;
        }else{
            $reminder_email = 0;
        }
        $id=sp_decryption(session()->get('admin_id'));
        $updated_data = array('name' =>$request['fname'].' '.$request['lname'],'image' =>$image,'dob' =>$request['dob'],'initials'=>$request['initials'],'position'=>$request['position'],'reminder_email'=>$reminder_email, 'updated_at'=>date('Y-m-d h:i:s'));
        $action=User::addUpdateRecord($updated_data,$id);
        if($action){
            session()->flash('succ_msg','Profile Updated Succesfully.');
        }else{
            session()->flash('fail_msg','Something Went Wrong.');
        }
        return back();
    }
    public function updatepassword(Request $request){
        if($request['npassword']==$request['rnpassword']){
            $user_details=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['password','=',md5($request['cpassword'])] ])->get()->first();
            if($user_details){
                $id=sp_decryption(session()->get('admin_id'));
                $updated_data = array('password' =>md5($request['npassword']), 'updated_at'=>date('Y-m-d h:i:s'));
                $action=User::addUpdateRecord($updated_data,$id);
                if($action){
                    session()->flash('succ_msg','Password Updated Succesfully.');
                }else{
                    session()->flash('fail_msg','Something Went Wrong.');
                }
            }else{
                session()->flash('fail_msg','Please enter right current password.');
            }
        }else{
            session()->flash('fail_msg','New password and Re-Entered password does not match.');
        }
        return back();
    }
    public function logout()
    {
    	session()->forget('admin_id');
    	session()->forget('login_token');
    	session()->forget('role_id');

        $cookie = \Cookie::forget('login_token');
        $cookie = \Cookie::forget('admin_id');
        $cookie = \Cookie::forget('role_id');

    	return redirect('admin')->withCookie($cookie);
    }
}
