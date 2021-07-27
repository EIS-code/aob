<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class HrFolderLink extends Model
{
    protected $fillable = [
        'folder_id',
        'random_string',
        'is_expired',
        'date_time'
    ];
    
    public function validator(array $data)
    {
        return Validator::make($data, [
            'folder_id'         => ['required', 'integer'],
            'random_string'     => ['required', 'string'],
            'date_time'         => ['required']
        ]);
    }
}
