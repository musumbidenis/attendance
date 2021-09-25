<?php

namespace App\Http\Controllers;

Use DB;
use App\Course;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /*GET
    */
    public function dashboard(Request $request)
    {
        return view('pages.dashboard',['tutorId'=>$request->session()->get('tutorId')]);
    }
    
}
