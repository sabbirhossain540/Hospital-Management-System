<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = User::where('role','doctor')->get();
        return view('admin.doctor.index')->with('userlist', $userList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $user->date_of_birth = $request->birth_day;
        $user->role = 'doctor';
        $user->degree = $request->educational_qualification;
        $user->doctor_specialist = $request->specialist;
        $user->institute_name = $request->institute_name;
        $user->passing_year = $request->passing_year;
        $user->address = $request->address;
        $user->save();
        session()->flash('success', 'Doctor created successfully');
        //$this->activity_log("store new user. { name:".$request->name." id:".$user->id." }", "store");
        return redirect()->route('doctorList.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userInfo = User::where('id',$id)->first();
        dd($userInfo);
//        return view('admin.user.edit')->with('userInfo', $userInfo)->with('editStatus','Normal');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
