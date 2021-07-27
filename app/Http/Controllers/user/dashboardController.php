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
use Carbon\Carbon;

class dashboardController extends Controller
{
    public function index(Request $request)
    {
        session()->put('parent_id', 0);
        session()->put('folder_id', 0);
        $data['user'] = DB::table(CUSTOMER_TABLE)->where([['id', '=', sp_decryption(session()->get('user_id'))], ['role_id', '=', 2]])->get()->first();

        $getAllTeams = DB::table(TEAM_MEMBER_TABLE)->where("user_id", sp_decryption(session()->get('user_id')))->where("is_delete", 0)->pluck('team_id')->toArray();
        
        $foldersDetails1 = $foldersDetails = $fileDetails = $fileDetails1 = array();
        if (isset($request['search'])) {
            $foldersDetails = DB::table(FOLDER_TABLE)
                ->select(FOLDER_TABLE . '.*', DB::raw('COUNT(files.folder_id) as nooffiles'), SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->Join(FILE_TABLE, FOLDER_TABLE . '.id', '=', FILE_TABLE . '.folder_id')
                ->Join(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FOLDER_TABLE . '.id')
                // ->leftjoin(CUSTOMER_TABLE, SHARE_TABLE . '.user_id', '=', CUSTOMER_TABLE . '.id')
                ->where([[FOLDER_TABLE . '.is_delete', '=', 0]])
                ->where(FOLDER_TABLE . '.name', 'LIKE', '%' . $request['search'] . '%')
                ->where(SHARE_TABLE . '.user_id', sp_decryption(session()->get('user_id')))
                ->where(SHARE_TABLE . '.type', "folder")
                ->offset(0)->limit(8)
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();


                
                $fileDetails1 =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->where(FILE_TABLE . '.name', 'LIKE', '%' . $request['search'] . '%')
                ->where(SHARE_TABLE . '.user_id', sp_decryption(session()->get('user_id')))
                ->where(SHARE_TABLE . '.type', "file")
                ->offset(0)->limit(8)
                ->get()->toArray();
                

            if(!empty($getAllTeams)) {
                $foldersDetails1 = DB::table(FOLDER_TABLE)
                ->select(FOLDER_TABLE . '.*', DB::raw('COUNT(files.folder_id) as nooffiles'), SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->Join(FILE_TABLE, FOLDER_TABLE . '.id', '=', FILE_TABLE . '.folder_id')
                ->Join(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FOLDER_TABLE . '.id')
                // ->leftjoin(CUSTOMER_TABLE, SHARE_TABLE . '.user_id', '=', CUSTOMER_TABLE . '.id')
                ->where([[FOLDER_TABLE . '.is_delete', '=', 0]])
                ->where(FOLDER_TABLE . '.name', 'LIKE', '%' . $request['search'] . '%')
                ->whereIn(SHARE_TABLE . '.team_id', $getAllTeams)
                ->where(SHARE_TABLE . '.type', "folder")
                ->offset(0)->limit(8)
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();

                
                $fileDetails1 =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->where(FILE_TABLE . '.name', 'LIKE', '%' . $request['search'] . '%')
                ->whereIn(SHARE_TABLE . '.team_id', $getAllTeams)
                ->where(SHARE_TABLE . '.type', "file")
                ->offset(0)->limit(8)
                ->get()->toArray();
                
            }
        } else {
            $foldersDetails = DB::table(FOLDER_TABLE)
                ->select(FOLDER_TABLE . '.*', DB::raw('COUNT(files.folder_id) as nooffiles'), SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->Join(FILE_TABLE, FOLDER_TABLE . '.id', '=', FILE_TABLE . '.folder_id')
                ->join(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FOLDER_TABLE . '.id')
                // ->leftjoin(CUSTOMER_TABLE, SHARE_TABLE . '.user_id', '=', CUSTOMER_TABLE . '.id')
                ->where([[FOLDER_TABLE . '.is_delete', '=', 0]])
                ->where(SHARE_TABLE . '.user_id', sp_decryption(session()->get('user_id')))
                ->where(SHARE_TABLE . '.type', "folder")
                ->offset(0)->limit(8)
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();

            
                $fileDetails =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->where(SHARE_TABLE . '.user_id', sp_decryption(session()->get('user_id')))
                ->where(SHARE_TABLE . '.type', "file")
                ->offset(0)->limit(8)
                ->get()->toArray();
            
            
            if(!empty($getAllTeams)) {
                
                $foldersDetails1 = DB::table(FOLDER_TABLE)
                ->select(FOLDER_TABLE . '.*', DB::raw('COUNT(files.folder_id) as nooffiles'), SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftJoin(FILE_TABLE, FOLDER_TABLE . '.id', '=', FILE_TABLE . '.folder_id')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FOLDER_TABLE . '.id')
                // ->leftjoin(CUSTOMER_TABLE, SHARE_TABLE . '.user_id', '=', CUSTOMER_TABLE . '.id')
                ->where([[FOLDER_TABLE . '.is_delete', '=', 0]])
                ->whereIn(SHARE_TABLE . '.team_id', $getAllTeams)
                ->where(SHARE_TABLE . '.type', "folder")
                ->offset(0)->limit(8)
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();

                
                $fileDetails1 =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->whereIn(SHARE_TABLE . '.team_id', $getAllTeams)
                ->where(SHARE_TABLE . '.type', "file")
                ->offset(0)->limit(8)
                ->get()->toArray();                
            }            
        }

        $allFoldersDetails = array_merge($foldersDetails,$foldersDetails1);

        $todayDate = Carbon::now();
        $todayDate = $todayDate->toDateString();

        $newArray = $newArray1 = array();
        if(!empty($allFoldersDetails)) {
            foreach($allFoldersDetails as $value) {
                if($value->expiration_date >= $todayDate && $value->activation_date <= $todayDate) {
                    $newArray[] = $value;
                }
            }
        }

        $allFileDetails = array_merge($fileDetails,$fileDetails1);
        if(!empty($allFileDetails)) {
            foreach($allFileDetails as $value) {
                if($value->expiration_date >= $todayDate && $value->activation_date <= $todayDate) {
                    $newArray1[] = $value;
                }
            }
        }

        $data['parentfolders'] = $newArray;
        $data['parentfiles'] = $newArray1;
        
        $data['recentnotifications'] = Notification::where('is_delete',0)
                                        ->where('user_id',sp_decryption(session()->get('user_id')))
                                        // ->whereDate('created_at','>=',date('Y-m-d',strtotime('-7 days')))
                                        ->orderByDesc('id')
                                        ->limit(6)
                                        ->get();
        $data['page'] = 'dashboard';

        return view('user.dashboard')->with('data', $data);
    }
    public function updateprofile(Request $request)
    {

        if (!empty($_FILES['fileToUpload']['name'])) {
            $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            if ($ext == 'png' || $ext == 'jpeg' || $ext == 'jpg') {
                $file_name = $_FILES['fileToUpload']['name'];
                $target_file = $_SERVER["DOCUMENT_ROOT"] . ROOT_PATH . 'public/users/';
                $size = (filesize($_FILES["fileToUpload"]["tmp_name"])) / 1024; //KB
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file . $file_name);
                $image = $file_name;
            } else {
                $image = $request['image_file'];
            }
        } else {
            $image = $request['image_file'];
        }
        
        if (isset($request['reminder_email'])) {
            $reminder_email = 1;
        } else {
            $reminder_email = 0;
        }
        $id = sp_decryption(session()->get('user_id'));
        $updated_data = array('name' => $request['fname'] . ' ' . $request['lname'], 'image' => $image, 'dob' => $request['dob'], 'initials' => $request['initials'], 'position' => $request['position'], 'reminder_email' => $reminder_email, 'updated_at' => date('Y-m-d h:i:s'));
        $action = User::addUpdateRecord($updated_data, $id);
        if ($action) {
            session()->flash('succ_msg', 'Profile Updated Succesfully.');
        } else {
            session()->flash('fail_msg', 'Something Went Wrong.');
        }
        return back();
    }
    public function updatepassword(Request $request)
    {
        if ($request['npassword'] == $request['rnpassword']) {
            $user_details = DB::table(CUSTOMER_TABLE)->where([['id', sp_decryption(session()->get('user_id'))], ['password',md5($request['cpassword'])]])->get()->first();
            if ($user_details) {
                $id = sp_decryption(session()->get('user_id'));
                $updated_data = array('password' => md5($request['npassword']), 'updated_at' => date('Y-m-d h:i:s'));
                $action = User::addUpdateRecord($updated_data, $id);
                if ($action) {
                    session()->flash('succ_msg', 'Password Updated Succesfully.');
                } else {
                    session()->flash('fail_msg', 'Something Went Wrong.');
                }
            } else {
                session()->flash('fail_msg', 'Please enter right current password.');
            }
        } else {
            session()->flash('fail_msg', 'New password and Re-Entered password does not match.');
        }
        return back();
    }
    public function logout()
    {
        session()->forget('user_id');
        session()->forget('login_token');
        session()->forget('role_id');

        $cookie = \Cookie::forget('login_token');
        $cookie = \Cookie::forget('user_id');
        $cookie = \Cookie::forget('role_id');

        return redirect('/')->withCookie($cookie);
    }
}
