<?php

namespace App\Http\Controllers;

use App\Course;
Use DB;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /*GET
    */
    public function register(Request $request)
    {
        $courses = DB::select('select * from courses');
        
        return view('auth.authentication',['courses'=>$courses]);
    }

    /*GET
    */
    public function login()
    {
        return view('auth.authentication');
    }
}
