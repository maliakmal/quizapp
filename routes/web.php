<?php

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

Route::get('/', 'HomeController@index')->name('root');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registration-success', 'HomeController@registration_success')->name('registration_success');
Route::get('/admin', 'HomeController@admin')->name('admin');
Route::get('/teacher', 'HomeController@teacher')->name('teacher');
Route::get('/student', 'HomeController@student')->name('student');

Route::get('/verify_login', 'HomeController@verify_login')->name('verify_login');

# Admin
Route::get('/admin', 'BackendAdminHomeController@index')->name('admin_home');

Route::group( ['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('/teachers', 'BackendAdminTeacherController');
    Route::post('/teachers/statuses', 'BackendAdminTeacherController@statuses')->name('teachers.statuses');
    Route::get('/teachers/change_password/{teacher_id}', 'BackendAdminTeacherController@change_password')->name('teachers.change_password');
    Route::post('/teachers/process_change_password', 'BackendAdminTeacherController@process_change_password')->name('teachers.process_change_password');

    Route::resource('/schools', 'BackendAdminSchoolController');
    Route::post('/schools/statuses', 'BackendAdminSchoolController@statuses')->name('schools.statuses');
    Route::get('/schools/mass_upload/1', 'BackendAdminSchoolController@mass_upload')->name('schools.mass_upload');
    Route::post('/schools/store_mass_upload', 'BackendAdminSchoolController@store_mass_upload')->name('schools.store_mass_upload');
});



/*Route::get('test_email', function () {

    Mail::to('noman@gtechme.com')->send(new \App\Mail\ConfirmTeacherRegistration());

    dd("Email is Send.");

});*/
