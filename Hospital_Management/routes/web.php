<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/userList', 'UserController@index')->name('userList');
Route::get('/createUser/{user}', 'UserController@create')->name('createUser');
Route::post('/postUserDate', 'UserController@store')->name('postUserDate');
Route::get('/editUser/{id}', 'UserController@edit')->name('editUser');
Route::post('/updateUser', 'UserController@update')->name('updateUser');
Route::post('/deleteUser/{id}', 'UserController@delete')->name('deleteUser');
Route::get('/showProfile', 'UserController@showProfile')->name('showProfile');
Route::get('/editProfile', 'UserController@editProfile')->name('editProfile');
Route::get('/changePassword', 'UserController@changePassword')->name('changePassword');
Route::post('/updatePassword', 'UserController@updatePassword')->name('updatePassword');

Route::resource('doctorList','DoctorController');
Route::post('/deleteDoctor/{id}', 'DoctorController@destroy')->name('deleteDoctor');

Route::resource('medicalCollege','MedicalCollegeController');
Route::post('/deleteCollege/{id}', 'MedicalCollegeController@destroy')->name('deleteCollege');

Route::resource('educationalQualification','EducationalQualificationController');
Route::post('/deleteQualification/{id}', 'EducationalQualificationController@destroy')->name('deleteQualification');

Route::resource('specialistArea','SpecialistAreaController');
Route::post('/deleteSA/{id}', 'SpecialistAreaController@destroy')->name('deleteQualification');

Route::resource('patientList','PatientController');
Route::post('/deletePatient/{id}', 'PatientController@destroy')->name('deletePatient');

Route::resource('services','ServicesController');
Route::post('/deleteService/{id}', 'ServicesController@destroy')->name('deleteService');

Route::resource('references','ReferencesController');
Route::post('/deleteReference/{id}', 'ReferencesController@destroy')->name('deleteReference');

Route::resource('invoices','InvoiceController');



Route::get('/getServiceInfo/{id}', 'InvoiceController@getServiceInfo')->name('getServiceInfo');
Route::post('/postServiceInfo', 'InvoiceController@postServiceInfo')->name('postServiceInfo');
Route::get('/getTempInvoiceDetails', 'InvoiceController@getTempInvoiceDetails')->name('getTempInvoiceDetails');
Route::get('/deleteTempService/{id}', 'InvoiceController@deleteTempService')->name('deleteTempService');
Route::get('/getTempServiceForEdit/{id}', 'InvoiceController@getTempServiceForEdit')->name('getTempServiceForEdit');

Route::post('/deleteInvoice/{id}', 'InvoiceController@destroy')->name('deleteInvoice');

//Report Path
Route::get('/getSalesReport', 'ReportController@getSalesReport')->name('getSalesReport');
Route::get('/generateSalesReport/{fromDate}/{toDate}', 'ReportController@generateSalesReport')->name('generateSalesReport');

Route::get('/generatePdfSalesReport', 'ReportController@generatePdfSalesReport')->name('generatePdfSalesReport');



Route::get('/getActiveLog', 'ActiveController@getActiveLog')->name('getActiveLog');

//


