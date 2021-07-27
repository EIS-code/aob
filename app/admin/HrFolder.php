<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class HrFolder extends Model {

    protected $guarded = [];

    public function links() {
        return $this->hasMany(HrFolderLink::class, 'folder_id', 'id');
    }
    
    public function files() {
        return $this->hasMany(HrFolderFile::class, 'folder_id', 'id');
    }

    public static function getRecordById($id){
		$data=DB::table(HR_FOLDER_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->first();
		return $data;
    }
    
    public static function getRecordByFolderName($name) {
        $data = DB::table(HR_FOLDER_TABLE)->where([['name', '=', $name], ['is_delete', '=', 0]])->first();
        return $data;
    }

    public static function addUpdateRecord($data, $id) {
        if ($id != 0) {
            $updated = DB::table(HR_FOLDER_TABLE)->where('id', $id)->update($data);
        } else {
            $updated = DB::table(HR_FOLDER_TABLE)->insert($data);
        }
        if ($updated) {
            return true;
        } else {
            return false;
        }
    }

    //Recurring function to add folders
    public static function addFoldersToZip($zip, $folder_details, $parent_id, $name) {
        $name = $name;
        if (!$folder_details->Files->isEmpty()) {
            foreach ($folder_details->Files as $key => $file) {
                self::addFilesToZip($zip, $file, $folder_details, $name);
            }
        } else {
            //$folder_details->Files->count() == 0
            self::addFilesToZip($zip, '', '', $name, 0);
        }
        if (!empty($folder_details->subFolder)) {
            foreach ($folder_details->subFolder as $key => $folder) {
                $inner_folder_name = $name;
                $inner_folder_name = $inner_folder_name . '/' . $folder->name;
                self::addFoldersToZip($zip, $folder, $folder->id, $inner_folder_name);
            }
        }
        return $zip;
    }

    //Recurring function to add files
    public static function addFilesToZip($zip, $file, $folder, $folder_path, $add_file = 1) {
        if ($add_file == 1) {
            //To add the files inside folder
            $zip->addFile(public_path() . '/document//' . $file->name . '.' . $file->ext, $folder_path . '/' . $file->name . '.' . $file->ext);
        } else {
            //To add the folder
            $zip->addEmptyDir($folder_path);
        }
    }

}
