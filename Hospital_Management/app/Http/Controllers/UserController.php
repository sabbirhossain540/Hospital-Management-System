<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function index(){
        $userList = User::all();
        $this->activity_log("get user list", "index");
        return view('admin.user.index')->with('userlist', $userList);
    }

    public function create($type){
        $this->activity_log("open user from", "create");
        return view('admin.user.createForm')->with('usertype', $type);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'mobile_no' => 'required|min:11'
        ]);

        $temp_password = rand(10000000,99999999);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($temp_password);
        $user->password_ref = $temp_password;
        $user->mobile_no = $request->mobile_no;
        $user->gander = $request->gander;
        $user->joining_date = $request->joining_date;
        $user->role = 'staff';
        $user->address = $request->address;
        $userList = $user->save();
        session()->flash('success', 'User created successfully');
        $this->activity_log("store new user. { name:".$userList->name." id:".$userList->id." }", "store");
        return redirect()->route('userList');
    }

    public function edit($id){
        $userInfo = User::where('id',$id)->first();
        $this->activity_log("edit user. { name:".$userInfo->name." id:".$userInfo->id." }", "edit");
        return view('admin.user.edit')->with('userInfo', $userInfo);
    }

    public function update(Request $request){
        $user = User::findOrFail($request->id);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'mobile_no' => 'required|min:11'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->password_ref = $request->password;
        $user->mobile_no = $request->mobile_no;
        $user->gander = $request->gander;
        $user->joining_date = $request->joining_date;
        $user->role = 'staff';
        $user->address = $request->address;
        $userlist = $user->save();
        session()->flash('success', 'User updated successfully');
        $this->activity_log("update user. { name:".$userList->name." id:".$userList->id." }", "update");
        return redirect()->route('userList');
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $this->activity_log("delete user. { name:".$user->name." id:".$user->id." }", "delete");
        $user->delete();
        session()->flash('success', 'User deleted successfully');
        return redirect()->route('userList');

    }

    public function activity_log($log_details, $fn){

        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'UserController', $fn);
    }

}
