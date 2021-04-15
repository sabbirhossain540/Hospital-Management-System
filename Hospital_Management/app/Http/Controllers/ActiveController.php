<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActiveLog;

class ActiveController extends Controller
{
    public function saveLogData($user_id, $log_details, $cn, $fn){
        $active_log = new ActiveLog();
        $active_log->user_id = $user_id;
        $active_log->log_details = $log_details;
        $active_log->controller_name = $cn;
        $active_log->function_name = $fn;
        $active_log->save();
    }
}
