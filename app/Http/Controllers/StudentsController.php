<?php

namespace App\Http\Controllers;

use App\Students;
use App\Imports\StudentImports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
Use Alert;

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
            'excel'  => 'required|mimes:xls,xlsx'
           ]);

           try{

            Excel::import(new StudentImports ,$request->file('excel'));

           } catch(\Illuminate\Database\QueryException $e){

              $errorCode = $e->errorInfo[2];
              Alert::error('Error Title', $errorCode);
           }
   
           
           return back()->with('success', 'Excel Data Imported successfully.');
          }
    }

