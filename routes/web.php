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


/* Authentication Routes */
Route::get('/login', function () {
    return view('auth.authentication');
});
Route::get('/register', function () {
    return view('auth.authentication');
});


/* Page Routes */
Route::get('/', function () {
    return view('pages.dashboard');
});
Route::get('/users/tutors', function () {
    return view('pages.tutors');
});
Route::get('/users/students', function () {
    return view('pages.students');
});


Route::post('/students/import', 'StudentsController@import');
Route::post('/students/new', 'StudentsController@newStudent');