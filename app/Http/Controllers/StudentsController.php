<?php

namespace App\Http\Controllers;

use DB;
use App\Course;
use App\Student;
use App\Imports\StudentImports;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class StudentsController extends Controller
{
    /**
     * Fetches Students records from DB
    */
    public function students(Request $request)
    {
        $courses = DB::select('select * from courses');

        return view('pages.students',['courses'=>$courses]);
    }


    /**
     * Adds New Student Record from Form
    */
    public function newStudent(Request $request)
    {
        $student = new Student();
        $student->studentId = $request->studentId;
        $student->firstname = $request->firstName;
        $student->surname = $request->surname;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->courseCode = $request->courseCode;

        try{
            
            $student->save();
            Alert::success('Student record inserted successfully');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){
                Alert::error('Oops', 'Duplicate Entry for '.$request->studentId)->persistent(true,false);
            }else{
                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            }
        }

        return back();
    }

    /**
     * Imports new students from excel.
    */
    public function import(Request $request)
    {
        $this->validate($request, [
            'excel'  => 'required|mimes:xls,xlsx'
           ]);

        try{

            Excel::import(new StudentImports ,$request->file('excel'));
            Alert::success('Students records inserted successfully');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){
                Alert::error('Duplicate Entry', $e->errorInfo[2])->persistent(true,false);
            }
              
        }
   
           
        return back();
    }

    public function onlineUssdMenu(Request $request)
    {
       $sessionId   = $request->get('sessionId');
       $serviceCode = $request->get('serviceCode');
       $phoneNumber = $request->get('phoneNumber');
       $text        = $request->get('text');
       
        // use explode to split the string text response from Africa's talking gateway into an array.
        $ussd_string_exploded = explode("*", $text);
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);
        if ($text == "") {
            // first response when a user dials our ussd code
            $response  = "CON Welcome to Online Classes at HLAB \n";
            $response .= "1. Register \n";
            $response .= "2. About HLAB";
        }
        elseif ($text == "1") {
            // when user respond with option one to register
            $response = "CON Choose which framework to learn \n";
            $response .= "1. Django Web Framework \n";
            $response .= "2. Laravel Web Framework";
        }
        elseif ($text == "1*1") {
            // when use response with option django
            $response = "CON Please enter your first name";
        }
        elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 3) {
            $response = "CON Please enter your last name";
        }
        elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 4) {
            $response = "CON Please enter your email";
        }
        elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 5) {
            // save data in the database
            $response = "END Your data has been captured successfully! Thank you for registering for Django online classes at HLAB.";
        }
        elseif ($text == "1*2") {
            // when use response with option Laravel
            $response = "CON Please enter your first name. ";
        }
        elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 3) {
            $response = "CON Please enter your last name";
        }
        elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 4) {
            $response = "CON Please enter your email";
        }
        elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 5) {
            // save data in the database
            $response = "END Your data has been captured successfully! Thank you for registering for Laravel online classes at HLAB.";
        }
        elseif ($text == "2") {
            // Our response a user respond with input 2 from our first level
            $response = "END At HLAB we try to find a good balance between theory and practical!.";
        }
        // send your response back to the API
        header('Content-type: text/plain');
        echo $response;
    }
}

