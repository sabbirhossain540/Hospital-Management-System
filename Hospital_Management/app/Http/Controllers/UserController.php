<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $userList = User::all();
        return view('admin.user.index')->with('userlist', $userList);
    }

    public function create($type){
        return view('admin.user.createForm')->with('usertype', $type);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);


        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->mobile_no = $request->mobile_no;
        $user->joining_date = $request->joining_date;
        $user->role = 'staff';
        $user->address = $request->address;
        $user->save();

        return redirect()->route('userList');
    }

}
