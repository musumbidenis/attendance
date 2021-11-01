<?php

namespace App\Http\Controllers;

use DB;
use App\Course;
use App\Student;
use Illuminate\Http\Request;
use App\Imports\StudentImports;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class StudentsController extends Controller
{
    /**
     * Fetches Students records from DB
    */
    public function studentsPage(Request $request)
    {
        $students = DB::table('students')
                ->select('students.studentId', 'students.firstname', 'students.surname', 'students.email', 'students.phone', 'students.courseCode', 'students.studyPeriod', 'courses.description')
                ->join('courses', 'courses.courseCode', '=', 'students.courseCode')
                ->get();

        $courses = DB::select('select * from courses');

        return view('pages.students',['students'=>$students,'courses'=>$courses]);
    }


    /**
     * Adds New Student Record from Form
    */
    public function newStudent(Request $request)
    {
        /** Get input details */
        $phoneNumber = $request->phone;

        /** Format the phone input */
        $phoneNumber = (substr($phoneNumber, 0, 2) == '07') ? preg_replace('/^0/','+254', $phoneNumber) : $phoneNumber;
        $phoneNumber = (substr($phoneNumber, 0, 3) == '254') ? str_replace('254','+254', $phoneNumber) : $phoneNumber;

        $student = new Student();
        $student->studentId = $request->studentId;
        $student->firstname = $request->firstName;
        $student->surname = $request->surname;
        $student->email = $request->email;
        $student->phone = $phoneNumber;
        $student->courseCode = $request->courseCode;
        $student->studyPeriod = $request->studyPeriod;

        try{
            
            $student->save();
            Alert::success('Success', 'Student record inserted successfully');

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
            Alert::success('Success','Students records inserted successfully');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){
                Alert::error('Duplicate Entry', $e->errorInfo[2])->persistent(true,false);
            }else{
                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            }
              
        }
   
           
        return back();
    }

     /** Update Student details */
     public function updateStudent(Request $request)
     {
        /** Get input details */
        $phoneNumber = $request->phone;

        /** Format the phone input */
        $phoneNumber = (substr($phoneNumber, 0, 2) == '07') ? preg_replace('/^0/','+254', $phoneNumber) : $phoneNumber;
        $phoneNumber = (substr($phoneNumber, 0, 3) == '254') ? str_replace('254','+254', $phoneNumber) : $phoneNumber;

        $studentId = $request->studentId;
        $firstname = $request->firstName;
        $surname = $request->surname;
        $email = $request->email;
        $phone = $phoneNumber;
        $courseCode = $request->courseCode;
        $studyPeriod = $request->studyPeriod;

       
        try{
           
            DB::update('UPDATE students SET firstname = ?, surname = ?, email = ?, phone = ?, courseCode = ?, studyPeriod = ? where studentId = ?', [$firstname, $surname, $email, $phone, $courseCode, $studyPeriod, $studentId]);

            Alert::success('Success', 'Update was successful.'); 
 
        } catch(\Illuminate\Database\QueryException $e){
 
            $errorCode = $e->errorInfo[1];
 
            Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
             
        }
 
        return back();
         
     }

    public function deleteStudent($id)
    {
 
        Student::where('studentId', $id)->delete();
 
        return response()->json('Success');
 
    }

}

