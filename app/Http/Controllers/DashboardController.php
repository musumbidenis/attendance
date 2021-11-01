<?php

namespace App\Http\Controllers;

Use DB;
use App\Unit;
use App\Tutor;
use App\Course;
use App\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*GET
    */
    public function dashboard(Request $request)
    {
        $courses = Course::count();
        $units = Unit::count();
        $tutors = Tutor::count();
        $students = Student::count();


        return view('pages.dashboard', ['courses'=>$courses, 'units'=>$units, 'tutors'=>$tutors, 'students'=>$students]);
    }
    
}
