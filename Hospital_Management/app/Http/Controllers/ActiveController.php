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

    public function getActiveLog(){
        $activityList = ActiveLog::with('users')->Where('user_id', auth()->user()->id)->orderBy('id','desc')->get();
        //dd($activityList);
        $this->activity_log("show activity log", "getActiveLog");
        return view('admin.activityLog.index')->with('activityList', $activityList);
    }


    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'ActiveController', $fn);
    }
}
