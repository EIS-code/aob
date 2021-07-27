<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireFiles extends Model
{
    protected $guarded = [];
    
    public function uploadedUser()
    {
        return $this->hasOne(User::class, 'id', 'uploaded_by');
    }
}
