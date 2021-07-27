<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class HrFolderFile extends Model
{
    protected $fillable = [
        'folder_id',
        'full_name',
        'dob',
        'passport_number',
        'passport_expired_date',
        'nif',
        'niss',
        'niss_type',
        'total_dependents',
        'iban',
        'address',
        'contact_no',
        'email',
        'emergency_contact_name',
        'emergency_contact_details',
        'last_employer',
        'designation',
        'total_work_time',
        'reason_of_leaving',
        'iban_proof',
        'card_proof',
        'residence_proof',
        'educational_proof',
        'local_proof',
        'date_time'
    ];
    
    public function validator(array $data)
    {
        return Validator::make($data, [
            'folder_id'                         => ['required', 'integer', 'exists:hr_folders,id'],
            'full_name'                         => ['required', 'string'],
            'dob'                               => ['required', 'string'],
            'passport_number'                   => ['required', 'string'],
            'passport_expired_date'             => ['required', 'string'],
            'nif'                               => ['nullable', 'string'],
            'niss'                              => ['nullable', 'string'],
            'niss_type'                         => ['required', 'integer'],
            'total_dependents'                  => ['required', 'string'],
            'iban'                              => ['required', 'string'],
            'address'                           => ['required', 'string'],
            'contact_no'                        => ['required', 'string'],
            'email'                             => ['required', 'string', 'email'],
            'emergency_contact_name'            => ['required', 'string'],
            'emergency_contact_details'         => ['required', 'string'],
            'last_employer'                     => ['nullable', 'string'],
            'designation'                       => ['nullable', 'string'],
            'total_work_time'                   => ['nullable', 'string'],
            'reason_of_leaving'                 => ['nullable', 'string'],
            'iban_proof'                        => ['required', 'string'],
            'card_proof'                        => ['required', 'string'],
            'residence_proof'                   => ['required', 'string'],
            'educational_proof'                 => ['required', 'string'],
            'local_proof'                       => ['required', 'string'],
            'date_time'                         => ['required'],
        ]);
    }
    
    public function checkPdfType($request, $file, $mimes = 'pdf')
    {
        return Validator::make($request, [
            $file => 'mimes:' . $mimes,
        ], [
            $file => 'Please select proper file. The file must be a file of type: ' . $mimes . '.'
        ]);
    }
    
    public function checkMimeTypes($request, $file, $mimes = 'jpeg,png,jpg,doc,docx,pdf')
    {
        return Validator::make($request, [
            $file => 'mimes:' . $mimes,
        ], [
            $file => 'Please select proper file. The file must be a file of type: ' . $mimes . '.'
        ]);
    }
}
