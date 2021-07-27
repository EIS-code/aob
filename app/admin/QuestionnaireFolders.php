<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireFolders extends Model
{
	protected $guarded = [];
	
    public function Files() {
		return $this->hasMany(QuestionnaireFiles::class, 'questionnaire_folder_id', 'id')->where('is_delete', 0);
	}

	//Recurring function to add folders
	public static function addFoldersToZip($zip, $folder_details, $parent_id, $name) {
		$name = $name;
		if(!$folder_details->Files->isEmpty()) {
			foreach($folder_details->Files as $key => $file) {
				self::addFilesToZip($zip, $file, $folder_details, $name);
			}
		}
		return $zip;
	}

	//Recurring function to add files
	public static function addFilesToZip($zip, $file, $folder, $folder_path, $add_file = 1) {
		if($add_file == 1) {
			//To add the files inside folder
			$zip->addFile(public_path(). '/questionnaire_files//' .$file->name.'.'.$file->ext, $folder_path.'/'.$file->name.'.'.$file->ext);
		} else {
			//To add the folder
			$zip->addEmptyDir($folder_path); 
		}
	}
}
