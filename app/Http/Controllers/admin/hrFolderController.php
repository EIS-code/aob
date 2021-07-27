<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\admin\HrFolder;
use App\admin\Notification;
use App\admin\HrFolderLink;
use Carbon\Carbon;
use App\admin\HrFolderFile;
use Session;
use File;
use Barryvdh\DomPDF\Facade as PDF;
use \Response;

class hrFolderController extends Controller {

    public function index(Request $request) {
        session()->put('parent_id', 0);
        session()->put('folder_id', 0);
        $data['admin'] = DB::table(CUSTOMER_TABLE)->where([['id', '=', sp_decryption(session()->get('admin_id'))], ['role_id', '=', 1]])->get()->first();

        if (isset($request['search'])) {
            $data['parentfolders'] = HrFolder::with('links', 'files')->where('is_delete', 0)->where('name', 'LIKE', '%' . $request['s'] . '%')->get();
        } else {
            $data['parentfolders'] = HrFolder::with('links', 'files')->where('is_delete', 0)->get();
        }
        $data['parentfolders1'] = $data['parentfolders'] = HrFolder::with('links', 'files')->where('is_delete', 0)->get();
        $data['movefolders'] = [];
        $data['teams'] = [];
        $data['users'] = [];
        $data['recentnotifications'] = [];
        $data['page'] = 'hrfolder';
        return view('admin.hr.hr_folder')->with('data', $data);
    }

    public function addFolder(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $folder = HrFolder::getRecordByFolderName($request['name']);
        if ($folder) {
            Session::flash('fail_msg', 'Folder name already exists. Please enter anothor folder name.');
        } else {
            if (!empty($request['id'])) {
                $id = $request['id'];
                $updated_data = array('name' => $request['name'], 'parent_id' => session()->get('parent_id'), 'updated_at' => date('Y-m-d h:i:s'));
            } else {
                $id = 0;
                $updated_data = array('name' => $request['name'], 'parent_id' => session()->get('parent_id'), 'created_at' => date('Y-m-d h:i:s'));
            }

            $action = HrFolder::addUpdateRecord($updated_data, $id);
            if ($action) {
                $notification['user_id'] = sp_decryption(session()->get('admin_id'));
                $notification['title'] = "You have added a '" . $request['name'] . "' folder.";
                $notification['details'] = "You have added a '" . $request['name'] . "' folder.";
                $notification['created_at'] = date('Y-m-d h:i:s');
                $notification['updated_at'] = date('Y-m-d h:i:s');
                Notification::addUpdateRecord($notification, 0);
                if ($id == 0) {
                    Session::flash('succ_msg', 'Folder Added Succesfully.');
                } else {
                    Session::flash('succ_msg', 'Folder Updated Succesfully.');
                }
            } else {
                Session::flash('fail_msg', 'Something Went Wrong.');
            }
        }
        return back();
    }
    
    public function getForm($token) {

        $user = HrFolderLink::where(['random_string' => $token, 'is_expired' => '0'])->first();
        if(empty($user)) {
            return view('admin.hr.error')->with('msg', 'Link is expired!!');
        }
        $to = Carbon::createFromTimestampMs($user->date_time);
        $from = Carbon::now();
        $diff_in_hours = $to->diffInHours($from);
        
        if($diff_in_hours >= LINK_EXPIRED_LIMIT) {
            $user->update(['is_expired' => '1']);
            return view('admin.hr.error')->with('msg', 'Link is expired!!');
        }
        if (empty($user)) {
            return view('admin.hr.error')->with('msg', 'Link is expired!!');
        }
        
        return view('admin.hr.form')->with('token', $token);
    }
    
    public function fileUpload($file, $path) {
        
        $fileName = $file->getClientOriginalName();
        $file->move($path, $fileName);
        return $fileName;
    }
    
    public function addDetails(Request $request) {

        DB::beginTransaction();
        try {
            $model = new HrFolderFile();
            $data = $request->all();
            $user = HrFolderLink::where(['random_string' => $request->access_token, 'is_expired' => '0'])->first();
            if(empty($user)) {
                return view('admin.hr.error')->with('msg', 'Link is expired!!');
            }
            $data['folder_id'] = $user->folder_id;
            
            if (isset($data['total_dependents'])) {
                if ($data['total_dependents'] == '4') {
                    $data['total_dependents'] = $data['others'];
                }
            }
            if (isset($data['iban_proof']) && $request->hasFile('iban_proof')) {
                $check = $model->checkPdfType($data, 'iban_proof');
                if ($check->fails()) {
                    Session::flash('fail_msg', $check->errors()->first());
                    return redirect()->back();
                }
            }
            if (isset($data['card_proof']) && $request->hasFile('card_proof')) {
                $check = $model->checkPdfType($data, 'card_proof');
                if ($check->fails()) {
                    Session::flash('fail_msg', $check->errors()->first());
                    return redirect()->back();
                }
            }
            if (isset($data['residence_proof']) && $request->hasFile('residence_proof')) {
                $check = $model->checkMimeTypes($data, 'residence_proof');
                if ($check->fails()) {
                    Session::flash('fail_msg', $check->errors()->first());
                    return redirect()->back();
                }
            }
            if (isset($data['educational_proof']) && $request->hasFile('educational_proof')) {
                $check = $model->checkMimeTypes($data, 'educational_proof');
                if ($check->fails()) {
                    Session::flash('fail_msg', $check->errors()->first());
                    return redirect()->back();
                }
            }
            if (isset($data['local_proof']) && $request->hasFile('local_proof')) {
                $check = $model->checkMimeTypes($data, 'local_proof');
                if ($check->fails()) {
                    Session::flash('fail_msg', $check->errors()->first());
                    return redirect()->back();
                }
            }
            $date = strtotime(Carbon::now()) * 1000;
            $path = public_path('/hr/' . $user->folder_id . '/' . $date);
            File::makeDirectory($path, 0777, true, true);

            $data['date_time'] = (string)$date;
            $data['iban_proof'] = $this->fileUpload($data['iban_proof'], $path);
            $data['card_proof'] = $this->fileUpload($data['card_proof'], $path);
            $data['residence_proof'] = $this->fileUpload($data['residence_proof'], $path);
            $data['educational_proof'] = $this->fileUpload($data['educational_proof'], $path);
            $data['local_proof'] = $this->fileUpload($data['local_proof'], $path);
            $data['dob'] = Carbon::parse($data['dob'])->format('Y-m-d');
            $data['passport_expired_date'] = Carbon::parse($data['passport_expired_date'])->format('Y-m-d');
            
            $check = $model->validator($data);
            if ($check->fails()) {
                Session::flash('fail_msg', $check->errors()->first());
                return redirect()->back();
            }
            PDF::loadView('admin.hr.pdf_view', ['data' => $data])->save($path . '/' . 'document.pdf');
            $create = $model->create($data);
            $update = $user->update(['is_expired' => '1']);
            if($create && $update) {
                DB::commit();
                return view('admin.hr.success');
            } else {
                return view('admin.hr.error')->with('msg', 'Something went wrong!!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    public function getFolder(request $request) {

        if($request['id']!=''){
            $folder = HrFolder::getRecordById($request['id']);
            $breadcrump = array();
            $folder_bred = $folder;
            $i=0;
           
            $breadcrump[$i] = new \stdClass();
            $breadcrump[$i]->id = $folder_bred->id;
            $breadcrump[$i]->name = $folder_bred->name;
            $data['breadcrumps'] = array_reverse($breadcrump);
            session()->put('parent_id',$folder->id);
            session()->put('folder_id',$folder->id);
            $data['admin']=DB::table(CUSTOMER_TABLE)->where([ ['id','=',sp_decryption(session()->get('admin_id'))],['role_id','=',1] ])->get()->first();
            
            $data['parentfolders']= HrFolderFile::where('folder_id', $request['id'])->get();
            
            $folders = [];
            foreach ($data['parentfolders'] as $key => $value) {
                
                $folders[] = [
                    'id' => $value->id,
                    'folder_id' => $value->folder_id,
                    'timestamp' => $value->date_time,
                    'name' => Carbon::createFromTimestampMs($value->date_time)->format('Y-m-d_H:i:s'),
                    'updated_at' => $value->updated_at
                ];
            }
            $data['parentfolders'] = $folders;
            $data['page']='hrfolder';
            $data['folder'] = $folder;
            return view('admin.hr.folderindex')->with('data',$data);
        }else{
            return redirect('admin/hrfolder');
        }
        
    }
    
    public function getExt($file) {
        $ext = explode('.', $file);
        return $ext[1];
    }

    public function getFolderDetails(request $request) {
        
        if($request['id']!=''){
            $data['file'] = HrFolderFile::find($request['id']);
            $data['file']->iban_proof_ext = $this->getExt($data['file']->iban_proof);
            $data['file']->card_proof_ext = $this->getExt($data['file']->card_proof);
            $data['file']->residence_proof_ext = $this->getExt($data['file']->residence_proof);
            $data['file']->educational_proof_ext = $this->getExt($data['file']->educational_proof);
            $data['file']->local_proof_ext = $this->getExt($data['file']->local_proof);
            
            $folder = HrFolder::getRecordById($data['file']->folder_id);
            $data['page']='hrfolder';
            $data['folder'] = $folder;
            $data['subfolder'] = Carbon::createFromTimestampMs($data['file']->date_time)->format('Y-m-d_H:i:s');
            return view('admin.hr.folderdetails')->with('data',$data);
        }else{
            return redirect('admin/hrfolder');
        }
    }
    
    public function download(Request $request) {
        
        $folder = HrFolderFile::where('id', $request['id'])->first();
        $key = $request['key'];
        if($key == 'iban') {
            $file_name = $folder->iban_proof;
            $path = public_path() . "/hr/" . $folder->folder_id . '/' . $folder->date_time. '/'. $folder->iban_proof;
        }
        if($key == 'card') {
            $file_name = $folder->card_proof;
            $path = public_path() . "/hr/" . $folder->folder_id . '/' . $folder->date_time. '/'. $folder->card_proof;
        }
        if($key == 'residence') {
            $file_name = $folder->residence_proof;
            $path = public_path() . "/hr/" . $folder->folder_id . '/' . $folder->date_time. '/'. $folder->residence_proof;
        }
        if($key == 'educational') {
            $file_name = $folder->educational_proof;
            $path = public_path() . "/hr/" . $folder->folder_id . '/' . $folder->date_time. '/'. $folder->educational_proof;
        }
        if($key == 'local') {
            $file_name = $folder->local_proof;
            $path = public_path() . "/hr/" . $folder->folder_id . '/' . $folder->date_time. '/'. $folder->local_proof;
        }
        if($key == 'document') {
            $file_name = 'document.pdf';
            $path = public_path() . "/hr/" . $folder->folder_id . '/' . $folder->date_time. '/'.'document.pdf';
        }
        return Response::download($path, $file_name);
    }

}
