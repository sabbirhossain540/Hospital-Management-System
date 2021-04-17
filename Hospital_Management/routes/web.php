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
    return view('welcome');
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


Route::get('/getActiveLog', 'ActiveController@getActiveLog')->name('getActiveLog');


