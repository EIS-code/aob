<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\Folder;
use App\admin\File;
use App\admin\Notification;
// use Illuminate\Support\Facades\Storage;
use \Response;
use Carbon\Carbon;

class folderController extends Controller
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
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();


                
                $fileDetails1 =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->where(FILE_TABLE . '.name', 'LIKE', '%' . $request['search'] . '%')
                ->whereIn(SHARE_TABLE . '.team_id', $getAllTeams)
                ->where(SHARE_TABLE . '.type', "file")
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
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();

                
                $fileDetails1 =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->where(FILE_TABLE . '.name', 'LIKE', '%' . $request['search'] . '%')
                ->whereIn(SHARE_TABLE . '.team_id', $getAllTeams)
                ->where(SHARE_TABLE . '.type', "file")
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
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();

            
                $fileDetails =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->where(SHARE_TABLE . '.user_id', sp_decryption(session()->get('user_id')))
                ->where(SHARE_TABLE . '.type', "file")
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
                ->groupBy(FOLDER_TABLE . '.name')
                ->get()->toArray();

                
                $fileDetails1 =    DB::table(FILE_TABLE)
                ->select(FILE_TABLE. ".*", SHARE_TABLE . '.activation_date', SHARE_TABLE . '.expiration_date')
                ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FILE_TABLE . '.id')
                ->where([[FILE_TABLE .'.is_delete', '=', 0], ['filetype', '=', 'normal']])
                ->whereIn(SHARE_TABLE . '.team_id', $getAllTeams)
                ->where(SHARE_TABLE . '.type', "file")
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
        
        $data['recentnotifications'] = Notification::where('is_delete', 0)
            ->where('user_id', sp_decryption(session()->get('user_id')))
            // ->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
            ->orderByDesc('id')
            ->limit(6)
            ->get();
        $data['page'] = 'folder';
        return view('user.folder')->with('data', $data);
    }

    public function fixfolderindex(request $request)
    {
        // ini_set('memory_limit', '-1');
        if ($request['folder1'] != '') {

            $folder = Folder::getFixRecordById($request['folder1']);

            session()->put('fixfolder_id', $folder->id);
            $data['user'] = DB::table(CUSTOMER_TABLE)->where([['id', '=', sp_decryption(session()->get('admin_id'))], ['role_id', '=', 1]])->get()->first();

            if (isset($request['search'])) {
                $data['parentfiles'] =  DB::table(FIX_FILE_TABLE)
                    ->where([['folder_id', '=', session()->get('fixfolder_id')], ['is_delete', '=', 0]])
                    ->where(FIX_FILE_TABLE . '.name', 'LIKE', '%' . $request['s'] . '%')
                    ->get();
            } else {
                $data['parentfiles'] =  DB::table(FIX_FILE_TABLE)
                    ->where([['folder_id', '=', session()->get('fixfolder_id')], ['is_delete', '=', 0]])
                    ->get();
            }

            $data['recentnotifications'] = Notification::where('is_delete', 0)
                ->where('user_id', sp_decryption(session()->get('user_id')))
                // ->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
                ->orderByDesc('id')
                ->limit(6)
                ->get();
            $data['page'] = 'folder';
            $data['fixfolder'] = $folder;
            $data['user'] = DB::table(CUSTOMER_TABLE)->where([['id', sp_decryption(session()->get('user_id'))], ['role_id',  2]])->get()->first();
            return view('user.fixfolderindex')->with('data', $data);
        } else {
            return redirect('user/fixfolders');
        }
    }

    public function downloadfixfile(Request $request)
    {
        $file = File::getFixRecordById($request['path']);
        $notification['user_id'] = sp_decryption(session()->get('user_id'));
        $notification['title'] = "You have downloaded " . $file->name . " file.";
        $notification['details'] = "You have downloaded " . $file->name . " file.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification, 0);
        $path = public_path() . "/document/" . $file->name . '.' . $file->ext;
        $headers = array(
            'Content-Type: application/' . $file->ext,
        );
        return Response::download($path, $file->name . '.' . $file->ext);
    }

    public function download(Request $request)
    {
        
        $file = File::getRecordById($request['path']);
        $notification['user_id'] = sp_decryption(session()->get('user_id'));
        $notification['title'] = "You have downloaded " . $file->name . " file.";
        $notification['details'] = "You have downloaded " . $file->name . " file.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification, 0);
        $path = public_path() . "/document/" . $file->name . '.' . $file->ext;
        $headers = array(
            'Content-Type: application/' . $file->ext,
        );
        return Response::download($path, $file->name . '.' . $file->ext);
    }

    public function folderindex(request $request)
    {
        
        // ini_set('memory_limit', '-1');
        if ($request['folder1'] != '') {
            $folder = Folder::getRecordById($request['folder1']);
            session()->put('parent_id', $folder->id);
            session()->put('folder_id', $folder->id);
            $data['user'] = DB::table(CUSTOMER_TABLE)->where([['id', '=', sp_decryption(session()->get('user_id'))], ['role_id', '=', 2]])->get()->first();

            if (isset($request['search'])) {
                $data['parentfolders'] = DB::table(FOLDER_TABLE)
                    ->select(FOLDER_TABLE . '.*', DB::raw('COUNT(files.folder_id) as nooffiles'))
                    ->leftJoin(FILE_TABLE, FOLDER_TABLE . '.id', '=', FILE_TABLE . '.folder_id')
                    ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FOLDER_TABLE . '.id')
                    // ->leftjoin(CUSTOMER_TABLE, SHARE_TABLE . '.user_id', '=', CUSTOMER_TABLE . '.id')
                    ->where([[FOLDER_TABLE . '.parent_id', '=', session()->get('parent_id')], [FOLDER_TABLE . '.is_delete', '=', 0]])
                    ->where(FOLDER_TABLE . '.name', 'LIKE', '%' . $request['s'] . '%')
                    // ->where(CUSTOMER_TABLE . '.id', sp_decryption(session()->get('user_id')))
                    ->groupBy(FOLDER_TABLE . '.name')
                    ->get();


                $data['parentfiles'] =  DB::table(FILE_TABLE)
                    ->where([['folder_id', '=', session()->get('folder_id')], ['is_delete', '=', 0], ['filetype', '=', 'normal']])
                    ->where(FILE_TABLE . '.name', 'LIKE', '%' . $request['s'] . '%')
                    ->get();
            } else {
                $data['parentfolders'] = DB::table(FOLDER_TABLE)
                    ->select(FOLDER_TABLE . '.*', DB::raw('COUNT(files.folder_id) as nooffiles'))
                    ->leftJoin(FILE_TABLE, FOLDER_TABLE . '.id', '=', FILE_TABLE . '.folder_id')
                    ->leftjoin(SHARE_TABLE, SHARE_TABLE . '.shared_id', '=', FOLDER_TABLE . '.id')
                    // ->leftjoin(CUSTOMER_TABLE, SHARE_TABLE . '.user_id', '=', CUSTOMER_TABLE . '.id')
                    ->where([[FOLDER_TABLE . '.parent_id', '=', session()->get('parent_id')], [FOLDER_TABLE . '.is_delete', '=', 0]])
                    // ->where(CUSTOMER_TABLE . '.id', sp_decryption(session()->get('user_id')))
                    ->groupBy(FOLDER_TABLE . '.name')
                    ->get();
                $data['parentfiles'] =  DB::table(FILE_TABLE)
                    ->where([['folder_id', '=', session()->get('folder_id')], ['is_delete', '=', 0], ['filetype', '=', 'normal']])
                    ->get();
            }

            $data['page'] = 'folder';
            $data['recentnotifications'] = Notification::where('is_delete', 0)
                ->where('user_id', sp_decryption(session()->get('user_id')))
                // ->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
                ->orderByDesc('id')
                ->limit(6)
                ->get();
            $data['folder'] = $folder;
            // echo "<pre>"; print_r($data); die();
            return view('user.folderindex')->with('data', $data);
        } else {
            return redirect('user/folder');
        }
    }

    //Function to download the zip of full folder
    public function downloadFolder(Request $request, $id)
    {
        $folderDetails = Folder::with(['Files', 'subFolder.Files'])->find($id);
        //Set the zip name
        $zip_file = $folderDetails->name . '.zip';
        //Initialize the zip object
        $zip = new \ZipArchive();
        //Create the new zip
        $zip->open(public_path() . '/document/' . $zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $folder = new Folder();
        $zip = $folder->addFoldersToZip($zip, $folderDetails, $parent_id = 0, $folderDetails->name);
        $zip->close();
        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath = public_path() . '/document/' . $zip_file;
        // Create Download Response
        if (file_exists($filetopath)) {
            return response()->download($filetopath, $zip_file, $headers)->deleteFileAfterSend(true);;
        }
    }
}
