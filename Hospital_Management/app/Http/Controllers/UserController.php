<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(){
        $userList = User::all();
        return view('admin.user.index')->with('userlist', $userList);
    }

    public function create($type){
        return view('admin.user.createForm')->with('usertype', $type);
    }

}
