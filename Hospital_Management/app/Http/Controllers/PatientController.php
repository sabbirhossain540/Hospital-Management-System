<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Patient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = User::where('role','patient')->get();
        $this->activity_log("get patient list", "index");
        return view('admin.patient.index')->with('userlist', $userList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->activity_log("open patient create from", "create");
        return view('admin.patient.create');
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
            //'email' => 'unique:users',
            'age' => 'required',
            'mobile_no' => 'required|min:11'
        ]);

        $temp_password = rand(10000000,99999999);
        $username = $this->randomUsername();

        $user = new User;
        $user->password = Hash::make(trim($temp_password));
        $user->password_ref = trim($temp_password);
        $user->role = 'patient';
        $user->username = $username;
        $this->dataInsert($user,$request);

        session()->flash('success', 'Patient created successfully');
        $this->activity_log("store new patient. { name:".$request->name." }", "store");
        return redirect()->route('patientList.index');
    }

    /**
     * @return string
     */
    function randomUsername() {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < 8; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userInfo = User::where('id',$id)->first();
        $invoiceList = Invoice::with( 'getDoctor')->where('pataint_id', $id)->orderBy('id','DESC')->get();
        foreach($invoiceList as $list){
            $list['formated_ic_date'] = \Illuminate\Support\Carbon::parse($list->ic_date);
        }
        $this->activity_log("show patient details. { name:".$userInfo->name." id:".$userInfo->id." }", "show");
        return view('admin.patient.show',compact(array('userInfo', 'invoiceList')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userInfo = User::with('educationQualification', 'CollageName', 'Specialist')->where('id',$id)->first();
        $this->activity_log("edit patient. { name:".$userInfo->name." id:".$userInfo->id." }", "edit");
        return view('admin.patient.edit',compact(array('userInfo')));
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
            'mobile_no' => 'required|min:11'
        ]);

        $this->dataInsert($user, $request);
        $this->activity_log("update patient. { name:".$request->name." }", "edit");
        session()->flash('success', 'Patient updated successfully');
        return redirect()->route('patientList.index');
    }

    /**
     * @param $modelName
     * @param $request
     */
    public function dataInsert($modelName, $request){
        $years = Carbon::parse($request->birth_day)->age;

        $modelName->name = $request->name;
        $modelName->email = $request->email;
        $modelName->mobile_no = $request->mobile_no;
        $modelName->gander = $request->gander;
        $modelName->date_of_birth = $request->birth_day;
        $modelName->age = $request->age;
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
        $invoiceInfo = Invoice::where('pataint_id', $id)->get();
        if(count($invoiceInfo) > 0){
            session()->flash('warning', 'You can not delete this patient. Because an invoice already created using this patient');
            return redirect()->route('patientList.index');
        }else{
            $user = User::findOrFail($id);
            $this->activity_log("delete patient. { name:".$user->name." id:".$user->id." }", "delete");
            $user->delete();
            session()->flash('success', 'Patient deleted successfully');
            return redirect()->route('patientList.index');
        }
    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'PatientController', $fn);
    }
}
