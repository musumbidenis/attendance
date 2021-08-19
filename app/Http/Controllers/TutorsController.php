<?php

namespace App\Http\Controllers;

use App\Tutor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TutorsController extends Controller
{
    /**
     * Adds New Tutor Record from Form
    */
    public function newTutor(Request $request)
    {
        $tutor = new Tutor();
        $tutor->tutorId = $request->tutorId;
        $tutor->firstname = $request->firstName;
        $tutor->surname = $request->surname;
        $tutor->email = $request->email;
        $tutor->phone = $request->phone;
        $tutor->role = "regular";
        $tutor->courseCode = $request->courseCode;

        try{
            
            $tutor->save();
            Alert::success('Success','Details have been submitted for approval. An email will be sent with your login credentials.');
            return redirect('/login');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){
                Alert::error('Oops', 'Tutor ID ' .$request->tutorId. ' is already registered. Please login to continue.')->persistent(true,false);
            }else{
                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            }

            return back();
        }

    }
}
