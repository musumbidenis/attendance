<?php

namespace App\Http\Controllers;

use DB;
use App\Tutor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TutorsController extends Controller
{
    /**
     * Fetches Tutors records from DB
    */
    public function tutors(Request $request)
    {
        $tutors = DB::select('select * from tutors');
        
        return view('pages.tutors',['tutors'=>$tutors]);
    }
}
