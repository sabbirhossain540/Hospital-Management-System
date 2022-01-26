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

Route::resource('expenseCategory','ExpenceCategoryController');
Route::post('/deleteExpCategory/{id}', 'ExpenceCategoryController@destroy')->name('deleteExpCategory');

Route::resource('patientList','PatientController');
Route::post('/deletePatient/{id}', 'PatientController@destroy')->name('deletePatient');

Route::resource('services','ServicesController');
Route::post('/deleteService/{id}', 'ServicesController@destroy')->name('deleteService');

Route::resource('references','ReferencesController');
Route::post('/deleteReference/{id}', 'ReferencesController@destroy')->name('deleteReference');

Route::resource('invoices','InvoiceController');
Route::get('/printInvoice/{id}', 'InvoiceController@printInvoice')->name('printInvoice');

Route::resource('expenses','ExpenseController');
Route::post('/deleteExpense/{id}', 'ExpenseController@destroy')->name('deleteExpense');
Route::get('/getExpenseCategoryInfo/{id}', 'ExpenseController@getExpenseCategoryInfo')->name('getExpenseCategoryInfo');
Route::get('/printExpanse/{id}', 'ExpenseController@printExpanse')->name('printExpanse');



Route::get('/getServiceInfo/{id}', 'InvoiceController@getServiceInfo')->name('getServiceInfo');
Route::post('/postServiceInfo', 'InvoiceController@postServiceInfo')->name('postServiceInfo');
Route::get('/getTempInvoiceDetails', 'InvoiceController@getTempInvoiceDetails')->name('getTempInvoiceDetails');
Route::get('/deleteTempService/{id}', 'InvoiceController@deleteTempService')->name('deleteTempService');
Route::get('/getTempServiceForEdit/{id}', 'InvoiceController@getTempServiceForEdit')->name('getTempServiceForEdit');

Route::post('/deleteInvoice/{id}', 'InvoiceController@destroy')->name('deleteInvoice');

//Sales Report
Route::get('/getSalesReport', 'ReportController@getSalesReport')->name('getSalesReport');
Route::get('/generateSalesReport/{fromDate}/{toDate}', 'ReportController@generateSalesReport')->name('generateSalesReport');
Route::get('/generatePdfSalesReport/{fromDate}/{toDate}', 'ReportController@generatePdfSalesReport')->name('generatePdfSalesReport');


//Expense Report
Route::get('/getExpenseReport', 'ReportController@getExpenseReport')->name('getExpenseReport');
Route::get('/generateExpenseReport/{fromDate}/{toDate}', 'ReportController@generateExpenseReport')->name('generateExpenseReport');
Route::get('/generatePdfExpenseReport/{fromDate}/{toDate}', 'ReportController@generatePdfExpenseReport')->name('generatePdfExpenseReport');

//Category Wise Expense Report
Route::get('/getCategoryWiseExpenseReport', 'ReportController@getCategoryWiseExpenseReport')->name('getCategoryWiseExpenseReport');
Route::get('/generateCategoryWiseExpenseReport/{fromDate}/{toDate}/{catId}', 'ReportController@generateCategoryWiseExpenseReport')->name('generateCategoryWiseExpenseReport');
Route::get('/generatePdfCategoryWiseExpenseReport/{fromDate}/{toDate}/{serviceId}', 'ReportController@generatePdfCategoryWiseExpenseReport')->name('generatePdfCategoryWiseExpenseReport');


//Service Wise Sales Report
Route::get('/getServiceWiseSalesReport', 'ReportController@getServiceWiseSalesReport')->name('getServiceWiseSalesReport');
Route::get('/generateServiceWiseSalesReport/{fromDate}/{toDate}/{serviceId}', 'ReportController@generateServiceWiseSalesReport')->name('generateServiceWiseSalesReport');
Route::get('/generatePdfServiceWiseSalesReport/{fromDate}/{toDate}/{serviceId}', 'ReportController@generatePdfServiceWiseSalesReport')->name('generatePdfServiceWiseSalesReport');

//Reference Wise Report
Route::get('/getReferenceWiseReport', 'ReportController@getReferenceWiseReport')->name('getReferenceWiseReport');
Route::get('/generateReferenceWiseReport/{fromDate}/{toDate}/{serviceId}', 'ReportController@generateReferenceWiseReport')->name('generateReferenceWiseReport');
Route::get('/generatePdfReferenceWiseReport/{fromDate}/{toDate}/{referenceId}', 'ReportController@generatePdfReferenceWiseReport')->name('generatePdfReferenceWiseReport');

//Doctor Wise Sales Report
Route::get('/getDoctorWiseReport', 'ReportController@getDoctorWiseReport')->name('getDoctorWiseReport');
Route::get('/generateDoctorWiseReport/{fromDate}/{toDate}/{doctorId}/{type}', 'ReportController@generateDoctorWiseReport')->name('generateDoctorWiseReport');
Route::get('/generatePdfDoctorWiseReport/{fromDate}/{toDate}/{doctorId}/{type}', 'ReportController@generatePdfDoctorWiseReport')->name('generatePdfDoctorWiseReport');


Route::get('/getActiveLog', 'ActiveController@getActiveLog')->name('getActiveLog');


Route::get('/test', 'ReportController@test')->name('test');

//


