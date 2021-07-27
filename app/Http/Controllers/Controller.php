<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\admin\Chat;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $user_id = sp_decryption(session()->get('user_id'));
        $send_users = Chat::where('is_delete', 0)->where('toid', $user_id)->where('is_read',0)->count();
        $data['unread_count'] = $send_users;
        view()->share('data1', $data);
    }
}
