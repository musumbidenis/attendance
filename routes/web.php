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

    Route::get('users/tutors', function () {
        return view('pages.tutors');
    });
    Route::get('users/students', function () {
        return view('pages.students');
    });
});


Route::post('students/import', 'StudentsController@import');
Route::post('students/new', 'StudentsController@newStudent');


/* Authentication Routes */
Route::get('login', 'PagesController@login');
Route::get('register', 'PagesController@register');
Route::get('resetpassword', 'PagesController@resetPassword');

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('resetpassword', 'AuthController@resetPassword');
