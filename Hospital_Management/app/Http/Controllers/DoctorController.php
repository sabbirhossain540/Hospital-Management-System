<?php

namespace App\Http\Controllers;

use App\EducationalQualification;
use App\MedicalCollege;
use App\SpecialistArea;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = User::with('educationQualification')->where('role','doctor')->get();
        $this->activity_log("get doctor list", "index");
        return view('admin.doctor.index')->with('userlist', $userList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collegeList = MedicalCollege::all();
        $qualificationList = EducationalQualification::all();
        $specialistAreaList = SpecialistArea::all();
        $this->activity_log("open doctor create from", "create");
        return view('admin.doctor.create',compact(array('collegeList', 'qualificationList', 'specialistAreaList')));
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
            'mobile_no' => 'required|min:11',
            'educational_qualification' => 'required',
            'specialist' => 'required',
            'institute_name' => 'required',
        ]);


        $genUser = Str::random(11);

        $temp_password = rand(10000000,99999999);

        $user = new User;
        $user->password = Hash::make(trim($temp_password));
        $user->password_ref = trim($temp_password);
        $user->role = 'doctor';
        $user->username = trim($genUser);
        $this->dataInsert($user,$request);

        session()->flash('success', 'Doctor created successfully');
        $this->activity_log("store new doctor. { name:".$request->name." }", "store");
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
        $userInfo = User::with('educationQualification', 'CollageName', 'Specialist')->where('id',$id)->first();
        $this->activity_log("show doctor details. { name:".$userInfo->name." id:".$userInfo->id." }", "show");
        return view('admin.doctor.show',compact(array('userInfo')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collegeList = MedicalCollege::all();
        $qualificationList = EducationalQualification::all();
        $specialistAreaList = SpecialistArea::all();
        $userInfo = User::with('educationQualification', 'CollageName', 'Specialist')->where('id',$id)->first();
        $this->activity_log("edit doctor. { name:".$userInfo->name." id:".$userInfo->id." }", "edit");
        return view('admin.doctor.edit',compact(array('collegeList', 'qualificationList', 'specialistAreaList', 'userInfo')));
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
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'mobile_no' => 'required|min:11'
        ]);

        $user->password = Hash::make(trim($request->password));
        $user->password_ref = trim($request->password);
        $this->dataInsert($user, $request);
        $this->activity_log("update doctor. { name:".$request->name." }", "edit");
        session()->flash('success', 'Doctor updated successfully');
        return redirect()->route('doctorList.index');
    }

    /**
     * @param $modelName
     * @param $request
     */
    public function dataInsert($modelName, $request){
        $modelName->name = $request->name;
        $modelName->email = $request->email;
        //$modelName->username = $request->username;
        $modelName->mobile_no = $request->mobile_no;
        $modelName->gander = $request->gander;
        $modelName->date_of_birth = $request->birth_day;
        $modelName->degree = $request->educational_qualification;
        $modelName->doctor_specialist = $request->specialist;
        $modelName->institute_name = $request->institute_name;
        $modelName->passing_year = $request->passing_year;
        $modelName->address = $request->address;
        $modelName->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->activity_log("delete doctor. { name:".$user->name." id:".$user->id." }", "delete");
        $user->delete();
        session()->flash('success', 'Doctor deleted successfully');
        return redirect()->route('doctorList.index');
    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'DoctorController', $fn);
    }
}
