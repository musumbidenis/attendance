<?php

namespace App\Http\Controllers;

Use DB;
use App\Unit;
use App\Course;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AcademicsController extends Controller
{
    /** Courses && Units Pages */
    public function coursesPage()
    {

        $courses = DB::select('select * from courses');

        return view('pages.courses',['courses'=>$courses]);

    }

    public function unitsPage()
    {
        
        $units = DB::select('select * from units');
        $courses = DB::select('select * from courses');

        return view('pages.units',['courses'=>$courses, 'units'=>$units]);
        
    }

    /**Ajax request for units */
    public function getUnits()
    {

        /** Get input details */
        $courseCode = $_GET['courseCode'];

        $units = Unit::where('courseCode', $courseCode)->get();

        return response()->json($units);
        
    }


    /** Add new Course to db */
    public function newCourse(Request $request)
    {

        /** Get input details */
        $course = new Course();
        $course->courseCode = $request->courseCode;
        $course->description = $request->description;

        try{
            
            $course->save();
            Alert::success('Success', 'New course record inserted successfully');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){
                Alert::error('Oops', 'Duplicate Entry for '.$request->courseCode)->persistent(true,false);
            }else{
                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            }
        }

        return back();
    }

    /** Add new Unit to db */
    public function newUnit(Request $request)
    {

        /** Get input details */
        $unit = new Unit();
        $unit->unitCode = $request->unitCode;
        $unit->description = $request->description;
        $unit->studyPeriod = $request->studyPeriod;
        $unit->courseCode = $request->courseCode;

        try{
            
            $unit->save();
            Alert::success('Success', 'New unit record inserted successfully');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){
                Alert::error('Oops', 'Duplicate Entry for '.$request->unitCode)->persistent(true,false);
            }else{
                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            }
        }

        return back();
    }

    /** Update Course details */
    public function updateCourse(Request $request)
    {

        /** Get input details */
        $courseCode = $request->courseCode;
        $description = $request->description;

       
        try{
            
            DB::update('UPDATE courses SET description = ? where courseCode = ?', [$description, $courseCode]);

            Alert::success('Success', 'Update was successful.');


        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            
        }

        return back();
        
    }

    /** Assign tutor units */
    public function assignUnits(Request $request)
    {

        /** Get input details */
        $tutorId = $request->tutorId;
        $unitCode = $request->unitCode;

        /** Assign units selected to tutor */
        foreach ($unitCode as $unit) {
            try{
            
                DB::update('UPDATE units SET tutorId = ? where unitCode = ?', [$tutorId, $unit]);
    
                Alert::success('Success', 'Tutor assigned units successfully.');
    
    
            } catch(\Illuminate\Database\QueryException $e){
    
                $errorCode = $e->errorInfo[1];
    
                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
                
            }
        }

        return back();
        
    }
}
