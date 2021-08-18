<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Get Courses from DB
    */
    public function import(Request $request){

        try{


        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];
            Alert::error('Duplicate Entry', $e->errorInfo[2])->persistent(true,false);
              
        }
   
           
        return back();
    }
}
