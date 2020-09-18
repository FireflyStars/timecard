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

Route::get('/', 'LoginController@showLoginForm')->name('show.login.form');
Route::post('login', 'LoginController@authenticate')->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('dashboard', 'TimecardController@showDashboard')->name('dashboard');
    Route::get('archived-timecards', 'TimecardController@showArchivedTimecards')->name('archived.timecard');

    // setting routes for employees
    Route::get('employees', 'EmployeeController@showAllEmployee')->name('show.all.employee');
    Route::post('employee/add', 'EmployeeController@addEmployee')->name('add.employee');
    Route::post('employee/update', 'EmployeeController@updateEmployee')->name('update.employee');
    
    //routes for projects
    Route::get('projects', 'ProjectController@showAllProject')->name('show.all.project');
    Route::post('project/add', 'ProjectController@addProject')->name('add.project');
    Route::post('project/update', 'ProjectController@updateProject')->name('update.project');

    //routes for timecard
    Route::get('timecard', 'TimecardController@showTimecard')->name('timecard');
    Route::get('add-timecard', 'TimecardController@showAddTimecardForm')->name('show.add.timecard');
    Route::get('edit-timecard/{id}', 'TimecardController@showEditTimecardForm')->name('show.edit.timecard');
    Route::post('add-timecard-by-admin', 'TimecardController@addTimecardByAdmin')->name('add.timecard.by.admin');
    Route::post('update-timecard-by-admin/{id}', 'TimecardController@updateTimecardByAdmin')->name('update.timecard.by.admin');
    Route::post('timecard/add', 'TimecardController@addTimecard')->name('add.timecard');
    Route::get('delete-timecard/{id}', 'TimecardController@deleteTimecard')->name('delete.timecard');

    Route::get('print/{key}', 'TimecardController@printWeekWork')->name('print.work.week');
});