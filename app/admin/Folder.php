<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Arr;

class Folder extends Model
{
    protected $guarded = [];

	public function subFolder() {
                return $this->hasMany('App\Admin\Folder', 'parent_id')->with(['subFolder.Files' => function($q) {
			$q->where('is_delete', 0);
		}]);
    }

	public function Files() {
		return $this->hasMany(File::class, 'folder_id', 'id')->where('is_delete', 0);
	}
	public static function updateRecord($data,$id)
    {
		$updated=DB::table(FOLDER_TABLE)->where('id',$id)->update($data);
		if($updated){
			return true;
		}else{
			return false;
		}
    }
    public static function getRecordByUser($id)
    {
		$data=DB::table(FOLDER_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->get();
		return $data;
    }
    public static function recentFolder($search=''){
		if(empty($search)){
			$data=DB::table(FOLDER_TABLE)
	                ->select(FOLDER_TABLE.'.name',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id')
					// ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
					->leftJoin(FILE_TABLE,function ($join) {
						$join->on(FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id') ;
						$join->where(FILE_TABLE.'.is_delete','=',0) ;
					})
					->where([[FOLDER_TABLE.'.is_delete','=',0] ])
					->where([[FOLDER_TABLE.'.parent_id','=',0] ])
	                ->groupBy(FOLDER_TABLE.'.name')
					->orderByDesc(FOLDER_TABLE.'.id')
					->limit(2)
					->get();
		}else{
			$data=DB::table(FOLDER_TABLE)
	                ->select(FOLDER_TABLE.'.name',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id')
					// ->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
					->leftJoin(FILE_TABLE,function ($join) {
						$join->on(FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id') ;
						$join->where(FILE_TABLE.'.is_delete','=',0) ;
					})
					->where([[FOLDER_TABLE.'.is_delete','=',0] ])
					->where([[FOLDER_TABLE.'.parent_id','=',0] ])
					->where(FOLDER_TABLE.'.name','LIKE','%'.$search.'%')
	                ->groupBy(FOLDER_TABLE.'.name')
					->orderByDesc(FOLDER_TABLE.'.id')
					->limit(2)
					->get();
		}
		return $data;
    }
    public static function folderWithFileCount($search=''){
		if(empty($search)){
			$data=DB::table(FOLDER_TABLE)
	                ->select(FOLDER_TABLE.'.name',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id')
					->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
					->where([[FOLDER_TABLE.'.is_delete','=',0] ])
					->where([[FOLDER_TABLE.'.parent_id','=',0] ])
	                ->groupBy(FOLDER_TABLE.'.name')
					->orderByDesc(FOLDER_TABLE.'.id')
					->limit(4)
					->get();
		}else{
			$data=DB::table(FOLDER_TABLE)
	                ->select(FOLDER_TABLE.'.name',DB::raw('COUNT(files.folder_id) as nooffiles'),FOLDER_TABLE.'.id')
					->leftJoin(FILE_TABLE, FOLDER_TABLE.'.id', '=', FILE_TABLE.'.folder_id')
					->where([[FOLDER_TABLE.'.is_delete','=',0] ])
					->where([[FOLDER_TABLE.'.parent_id','=',0] ])
					->where(FOLDER_TABLE.'.name','LIKE','%'.$search.'%')
	                ->groupBy(FOLDER_TABLE.'.name')
					->orderByDesc(FOLDER_TABLE.'.id')
					->limit(4)
					->get();
		}
		return $data;
    }
    public static function fixfolderWithFileCount($search=''){
		if(empty($search)){
			$data=DB::table(FIX_FOLDER_TABLE)
	                ->select(FIX_FOLDER_TABLE.'.name',DB::raw('COUNT(fixfolderfiles.folder_id) as nooffiles'),FIX_FOLDER_TABLE.'.id')
					->leftJoin(FIX_FILE_TABLE, FIX_FOLDER_TABLE.'.id', '=', FIX_FILE_TABLE.'.folder_id')
					->where([[FIX_FOLDER_TABLE.'.is_delete','=',0] ])
	                ->groupBy(FIX_FOLDER_TABLE.'.name')
					->orderByDesc(FIX_FOLDER_TABLE.'.id')
					->limit(3)
					->get();
		}else{
			$data=DB::table(FIX_FOLDER_TABLE)
	                ->select(FIX_FOLDER_TABLE.'.name',DB::raw('COUNT(fixfolderfiles.folder_id) as nooffiles'),FIX_FOLDER_TABLE.'.id')
					->leftJoin(FIX_FILE_TABLE, FIX_FOLDER_TABLE.'.id', '=', FIX_FILE_TABLE.'.folder_id')
					->where([[FIX_FOLDER_TABLE.'.is_delete','=',0] ])
					->where(FIX_FOLDER_TABLE.'.name','LIKE','%'.$search.'%')
	                ->groupBy(FIX_FOLDER_TABLE.'.name')
					->orderByDesc(FIX_FOLDER_TABLE.'.id')
					->limit(3)
					->get();
		}
		return $data;
    }
    public static function getRecordByFolderName($name){
		$data=DB::table(FOLDER_TABLE)->where([ ['name','=',$name],['is_delete','=',0] ])->first();
		return $data;
    }
    public static function getRecordById($id){
		$data=DB::table(FOLDER_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->first();
		return $data;
    }
    public static function getFixRecordById($id){
		$data=DB::table(FIX_FOLDER_TABLE)->where([ ['id','=',$id],['is_delete','=',0] ])->first();
		return $data;
    }
    public static function addUpdateRecord($data,$id)
    {
    	if($id!=0){
   			$updated=DB::table(FOLDER_TABLE)->where('id',$id)->update($data);
    	}else{
   			$updated=DB::table(FOLDER_TABLE)->insert($data);
    	}
		if($updated){
			return true;
		}else{
			return false;
		}
    }

    //Recurring function to add folders
	public static function addFoldersToZip($zip, $folder_details, $parent_id, $name) {
		$name = $name;
		if(!$folder_details->Files->isEmpty()) {
			foreach($folder_details->Files as $key => $file) {
				self::addFilesToZip($zip, $file, $folder_details, $name);
			}
		} else {
			//$folder_details->Files->count() == 0
			self::addFilesToZip($zip, '', '', $name, 0);
		}
		if(!empty($folder_details->subFolder)) {
			foreach($folder_details->subFolder as $key => $folder) {
				$inner_folder_name = $name;
				$inner_folder_name = $inner_folder_name . '/' .$folder->name;
				self::addFoldersToZip($zip, $folder, $folder->id, $inner_folder_name);
			}
		}
		return $zip;
	}

	//Recurring function to add files
	public static function addFilesToZip($zip, $file, $folder, $folder_path, $add_file = 1) {
		if($add_file == 1) {
			//To add the files inside folder
			$zip->addFile(public_path(). '/document//' .$file->name.'.'.$file->ext, $folder_path.'/'.$file->name.'.'.$file->ext);
		} else {
			//To add the folder
			$zip->addEmptyDir($folder_path); 
		}
	}

	//Recurring function to copy folders
	public static function copyFolder($folder_details, $parent_id) {
		$updated_data = array('name' =>$folder_details->name,'parent_id' =>$parent_id,'created_at'=>date('Y-m-d h:i:s'));
		$action = Folder::create($updated_data);
		if(!empty($folder_details->Files)) {
			foreach($folder_details->Files as $key => $file) {
				self::copyFiles($file, $action);
			}
		} 
		if(!empty($folder_details->subFolder)) {
			foreach($folder_details->subFolder as $key => $folder) {
				self::copyFolder($folder, $action->id);
			}
		}
		return true;
	}

	//Recurring function to copy files
	public static function copyFiles($file, $folder) {
		$file_data = $file->attributesToArray();
		$file_data['folder_id'] =  $folder->id;
		$file_data['created_at'] =  date('Y-m-d h:i:s');
		$file_data['updated_at'] =  date('Y-m-d h:i:s');
		$finaliseFileData = Arr::except($file_data, ['id']);
		$newFile = File::create($finaliseFileData);
	}
}
