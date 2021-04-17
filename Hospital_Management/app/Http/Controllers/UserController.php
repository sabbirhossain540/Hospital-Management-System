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
        $user->password = Hash::make(trim($temp_password));
        $user->password_ref = trim($temp_password);
        $user->mobile_no = $request->mobile_no;
        $user->gander = $request->gander;
        $user->joining_date = $request->joining_date;
        $user->role = 'staff';
        $user->address = $request->address;
        $user->save();
        session()->flash('success', 'User created successfully');
        $this->activity_log("store new user. { name:".$request->name." id:".$user->id." }", "store");
        return redirect()->route('userList');
    }

    public function edit($id){
        $userInfo = User::where('id',$id)->first();
        $this->activity_log("edit user. { name:".$userInfo->name." id:".$userInfo->id." }", "edit");
        return view('admin.user.edit')->with('userInfo', $userInfo)->with('editStatus','Normal');
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
        $user->password = Hash::make(trim($request->password));
        $user->password_ref = trim($request->password);
        $user->mobile_no = $request->mobile_no;
        $user->gander = $request->gander;
        $user->joining_date = $request->joining_date;
        //$user->role = 'staff';
        $user->address = $request->address;
        $userlist = $user->save();
        session()->flash('success', 'User updated successfully');

        if($request->edittype == "PE"){
            $this->activity_log("update my profile", "update");
            return redirect()->route('showProfile');
        }else{
            $this->activity_log("update user. { name:".$user->name." id:".$user->id." }", "update");
            return redirect()->route('userList');
        }

    }

    public function delete($id){
        $user = User::findOrFail($id);
        $this->activity_log("delete user. { name:".$user->name." id:".$user->id." }", "delete");
        $user->delete();
        session()->flash('success', 'User deleted successfully');
        return redirect()->route('userList');
    }

    public function showProfile(){
        $userProfile = User::where('id',auth()->user()->id)->first();
        $this->activity_log("Show ". $userProfile->name ." user profile", "showProfile");
        return view('admin.user.userProfile')->with('userProfile', $userProfile);
    }

    public function editProfile(){
        $userProfile = User::where('id',auth()->user()->id)->first();
        $this->activity_log("Edit ". $userProfile->name ." user profile", "editProfile");
        return view('admin.user.edit')->with('userInfo', $userProfile)->with('editStatus','PE');
    }

    public function changePassword(){
        $this->activity_log("View to password change page", "changePassword");
        return view('admin.user.passwordChange');
    }

    public function updatePassword(Request $request){
        $getUserPassword = $userProfile = User::where('id',auth()->user()->id)->first();

        if($getUserPassword->password_ref == $request->old_pasword){
            if($request->new_password == $request->confirm_password){
                $getUserPassword->password = Hash::make(trim($request->new_password));
                $getUserPassword->password_ref = trim($request->new_password);
                $getUserPassword->save();

                session()->flash('success', 'Password has been changed successfully');
                $this->activity_log("Successfully Password Chage", "updatePassword");
                return redirect()->route('showProfile');
            }else{
                session()->flash('error', 'new password and confirm password not match!!');
                $this->activity_log("new password and confirm password not match!!", "updatePassword");
                return redirect()->route('changePassword')->with('passwordSubmitData',$request->all());
            }
        }else{
            session()->flash('error', 'Old password not match!!');
            $this->activity_log("Old password not match", "updatePassword");
            return redirect()->route('changePassword')->with('passwordSubmitData',$request->all());
        }
    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'UserController', $fn);
    }



}
