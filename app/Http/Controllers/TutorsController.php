<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use App\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class TutorsController extends Controller
{
    /**
     * Fetches Tutors records from DB
    */
    public function tutors(Request $request)
    {
        $tutors = DB::select('select * from tutors');
        $courses = DB::select('select * from courses');

        return view('pages.tutors',['tutors'=>$tutors, 'courses'=>$courses]);
    }

    /**
     * Fetches Tutors records from DB
    */
    public function approve($tutorId)
    {

       /*Generate random password (Hashed) for tutor*/
       $password = uniqid();
       $hashedPassword = Hash::make($password);

       /*Update tutor status and assign password */
       DB::update('UPDATE tutors SET password = ?, status = ? where tutorId = ?', [$hashedPassword, 'approved', $tutorId]);

       /*Email login credentials to the tutor */
       $tutorDetails = Tutor::where('tutorId', $tutorId)->get()->first();
       $data = [
            'subject' => 'Account Approval',
            'tutorId' => $tutorDetails->tutorId,
            'firstname' => $tutorDetails->firstname,
            'surname' => $tutorDetails->surname,
            'email' => $tutorDetails->email,
            'password' => $password,
        ];

        Mail::send('emails.approval', $data, function($message) use ($data) {
            $message->to($data['email'])
                    ->subject($data['subject']);
        });

       Alert::success('Success','Approval was succesfull. Login credentials emailed to the tutor.');
       return back();
        
    }
}
