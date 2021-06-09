<?php

namespace App\Http\Controllers;

use App\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $this->validate($request, [
            'data'  => 'required|mimes:xls,xlsx'
           ]);
      
           $path = $request->file('data')->getRealPath();
      
           $data = Excel::import($path);
      
           if($data->count() > 0)
           {
            foreach($data->toArray() as $key => $value)
            {
             foreach($value as $row)
             {
              $insert_data[] = array(
               'studentId'  => $row['Student Id'],
               'firstname'   => $row['First Name'],
               'surname'   => $row['Surname'],
               'email'    => $row['Email'],
               'phone'  => $row['Phone'],
               'courseCode'   => $row['Course Code']
              );
             }
            }
      
            if(!empty($insert_data))
            {
             DB::table('students')->insert($insert_data);
            }
           }
           return back()->with('success', 'Excel Data Imported successfully.');
          }
    }

