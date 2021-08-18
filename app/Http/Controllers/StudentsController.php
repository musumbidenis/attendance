<?php

namespace App\Http\Controllers;

use App\Student;
use App\Imports\StudentImports;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class StudentsController extends Controller
{
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
        $student->courseCode = "Bsc IT2";

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
}

