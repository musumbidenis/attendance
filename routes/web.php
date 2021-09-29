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


/* Page Routes */
Route::middleware(['isLoggedIn'])->group(function () {

    Route::get('dashboard', 'PagesController@dashboard');
    Route::get('users/tutors', 'TutorsController@tutors');
    Route::get('users/students', 'StudentsController@students');
    Route::get('academics/courses', 'AcademicsController@courses');
    Route::get('academics/units', 'AcademicsController@units');
    
});


Route::post('students/import', 'StudentsController@import');
Route::post('tutors/import', 'TutorsController@import');
Route::post('students/new', 'StudentsController@newStudent');
Route::post('tutors/new', 'TutorsController@newTutor');
Route::post('courses/new', 'AcademicsController@newCourse');
Route::post('units/new', 'AcademicsController@newUnit');
Route::post('approve/{tutorId}', 'TutorsController@approve');


/* Authentication Routes */
Route::get('login', 'AuthController@loginPage');
Route::get('admin', 'AuthController@adminLoginPage');
Route::get('register', 'AuthController@registerPage');
Route::get('resetpassword', 'AuthController@resetPasswordPage')->middleware('isLoggedIn');
Route::get('logout', 'AuthController@logout');

Route::post('login', 'AuthController@login');
Route::post('admin', 'AuthController@admin');
Route::post('register', 'AuthController@register');
Route::post('resetpassword', 'AuthController@resetPassword');
