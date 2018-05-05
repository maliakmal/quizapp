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

Route::group( ['prefix' => 'admin', 'middleware'=>'authorize.roles:admin', 'as' => 'admin.'], function () {
    Route::resource('/teachers', 'Admin\TeacherController');
    Route::post('/teachers/update-status', 'Admin\TeacherController@updateStatus')->name('teachers.update-status');
    Route::get('/teachers/change_password/{teacher_id}', 'Admin\TeacherController@change_password')->name('teachers.change_password');
    Route::post('/teachers/process_change_password', 'Admin\TeacherController@process_change_password')->name('teachers.process_change_password');

    Route::post('/schools/update-status', 'Admin\SchoolController@updateStatus')->name('schools.update-status');
    Route::get('/schools/import', 'Admin\SchoolController@import')->name('schools.import');
    Route::post('/schools/import', 'Admin\SchoolController@postImport')->name('schools.post-import');
    Route::resource('/schools', 'Admin\SchoolController');
    Route::get('/quizzes/{id}/publish', 'Admin\QuizController@publish')->name('quizzes.publish');
    Route::get('/quizzes/{id}/unpublish', 'Admin\QuizController@unpublish')->name('quizzes.unpublish');
    Route::resource('/quizzes', 'Admin\QuizController');
});

Route::group( ['prefix' => 'school', 'middleware'=>'authorize.roles:teacher', 'as' => 'teacher.'], function () {
    Route::get('/', ['uses'=>'Teacher\HomeController@index', 'as'=>'home']);
    Route::resource('/students', 'Teacher\StudentController');
});


Route::group( ['prefix' => 'app', 'middleware'=>'authorize.roles:student', 'as' => 'student.'], function () {
    Route::get('/', [ 'uses'=>'Student\HomeController@home', 'as'=>'home']);
});


/*Route::get('test_email', function () {

    Mail::to('noman@gtechme.com')->send(new \App\Mail\ConfirmTeacherRegistration());

    dd("Email is Send.");

});*/
