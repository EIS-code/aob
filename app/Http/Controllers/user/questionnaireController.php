<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\admin\QuestionnaireFolders;
use App\admin\QuestionnaireFiles;
use App\admin\Notification;
use DB;
use \Response;

class questionnaireController extends Controller
{
    //function to open the questionnaires module
    public function index(Request $request, $id) {
        if(sp_decryption(session()->get('user_id')) !== $id) {
            session()->flash('fail_msg','Access Denied!!');
            return redirect()->route('dashboard');
        }
        $admin_id = sp_decryption(session()->get('user_id'));
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

        $folders = QuestionnaireFolders::with(['Files' => function($q) use ($request, $id) {
                        $q->with('uploadedUser');
                        if($request->has('s') && !empty($request->s) && !empty($id)) {
                            $search = $request->s;
                            $q->where('name', 'like', '%' . $search . '%');
                        }
                    }])->where('is_delete', 0);

        if(!empty($id)) {
            session()->put('parent_id',$id);
            session()->put('folder_id',$id);
            $folder = $folders->where('created_for', $id)->first();
            $parentFiles = array();
            if(isset($folder->Files) && !$folder->Files->isEmpty()) {
                foreach($folder->Files as $key => $file) {
                    if (file_exists( public_path() . '/questionnaire_files/' . $file->name .'.'. $file->ext)) {
                        $parentFiles[] = $file;
                    }
                }
                $folder->Files = $parentFiles;
            }
            return view('user.questionnaires-folders')->with(['data' => $data, 'folder' => $folder]);
        } else {
            if($request->has('s') && !empty($request->s)) {
                $search = $request->s;
                $folders = $folders->Where('name', 'like', '%' . $search . '%');
            }
            $folders = $folders->get();
        }
        
        return view('user.questionnaires')->with(['data' => $data, 'folders' => $folders]);
    }

    //Function to add the files to specific folder
    public function addQuestionnaireFile(Request $request){
        if(isset($_FILES['fileToUpload'])){
          if($_FILES['fileToUpload']['name']!=''){
            $file = QuestionnaireFiles::where('name', $_FILES['fileToUpload']['name'])->where('filetype', 'normal')->first();
            if($file){
                session()->flash('fail_msg','Filename already exists !!');
            }else{
                $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
                $file_name = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_FILENAME);
                $ext = strtolower($ext);
                    $target_file = $_SERVER["DOCUMENT_ROOT"].ROOT_PATH.'public/questionnaire_files/';
                    $size = (filesize($_FILES["fileToUpload"]["tmp_name"]))/1024; //KB
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.$file_name.'.'.$ext);
                    $data['document_size']=$size;
                    $id=0;
                    $folder_details = QuestionnaireFolders::where('created_for', sp_decryption(session()->get('user_id')))->first();
                    $updated_data = array('name' =>$file_name,'ext' =>$ext,'size' =>$size,'questionnaire_folder_id' =>$folder_details->id,'uploaded_by' => sp_decryption(session()->get('user_id')), 'created_at'=>date('Y-m-d h:i:s'));
                    $action = QuestionnaireFiles::create($updated_data);
                    if($action){
                        $notification['user_id']=sp_decryption(session()->get('user_id'));
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

    //Function to download the zip of full folder
    public function downloadFolder(Request $request, $id) {
        $folderDetails = QuestionnaireFolders::with(['Files'])->find($id);
        //Set the zip name
        $zip_file = $folderDetails->name .'.zip';
        //Initialize the zip object
        $zip = new \ZipArchive();
        //Create the new zip
        $zip->open(public_path() .'/questionnaire_files/'.$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $folder = new QuestionnaireFolders();
        $zip = $folder->addFoldersToZip($zip, $folderDetails, $parent_id = 0, $folderDetails->name);
        $zip->close();
        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath = public_path() .'/questionnaire_files/'.$zip_file;
        // Create Download Response
        if(file_exists($filetopath)){
            return response()->download($filetopath,$zip_file,$headers)->deleteFileAfterSend(true);;
        }
    }

    //Function to download the files
    public function downloadFile(Request $request, $id){
        $file = QuestionnaireFiles::find($id);
        $notification['user_id']=sp_decryption(session()->get('user_id'));
        $notification['title'] = "You have downloaded ".$file->name." file.";
        $notification['details'] = "You have downloaded ".$file->name." file.";
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notification['updated_at'] = date('Y-m-d h:i:s');
        Notification::addUpdateRecord($notification,0);
        $path = public_path()."/questionnaire_files/".$file->name.'.'.$file->ext;
    
        $headers = array(
                  'Content-Type: application/'.$file->ext,
                );
        return Response::download($path, $file->name.'.'.$file->ext);
    }

    //Function to remove the file
    public function deleteFile(Request $request, $id) {
        $id=$request['id'];
        $file = QuestionnaireFiles::find($id);
        $file->is_delete = 1;
        $file->save();
        if($file->id){
            $notification['user_id']=sp_decryption(session()->get('user_id'));
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
}
