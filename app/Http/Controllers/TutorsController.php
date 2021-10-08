<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use App\Unit;
use App\Tutor;
Use App\Lesson;
use Illuminate\Http\Request;
use App\Imports\TutorImports;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TutorsController extends Controller
{
    /** Fetch Tutors records from DB */
    public function tutors(Request $request)
    {
        $tutors = DB::select('select * from tutors');

        return $tutors->json();
    }

    /** Tutors Page */
    public function tutorsPage(Request $request)
    {
        $tutors = DB::select('select * from tutors');
        $courses = DB::select('select * from courses');

        return view('pages.tutors',['tutors'=>$tutors, 'courses'=>$courses]);
    }

    /** Add New Tutor Record from Form */
    public function newTutor(Request $request)
    {
        $tutor = new Tutor();
        $tutor->tutorId = $request->tutorId;
        $tutor->firstname = $request->firstName;
        $tutor->surname = $request->surname;
        $tutor->email = $request->email;
        $tutor->phone = $request->phone;
        $tutor->courseCode = $request->courseCode;

        try{
            
            $tutor->save();
            Alert::success('Success', 'Tutor record inserted successfully');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){
                Alert::error('Oops', 'Duplicate Entry for '.$request->tutorId)->persistent(true,false);
            }else{
                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            }
        }

        return back();
    }

    /** Import new tutors from excel */
    public function import(Request $request)
    {
        $this->validate($request, [
            'excel'  => 'required|mimes:xls,xlsx'
        ]);
    
        try{
    
            Excel::import(new TutorImports ,$request->file('excel'));
            Alert::success('Success', 'Tutors records inserted successfully');
    
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

    /** Update Tutor details */
    public function updateTutor(Request $request)
    {

        $tutorId = $request->tutorId;
        $firstname = $request->firstName;
        $surname = $request->surname;
        $email = $request->email;
        $phone = $request->phone;
        $courseCode = $request->courseCode;

       
        try{
            
            DB::update('UPDATE tutors SET firstname = ?, surname = ?, email = ?, phone = ?, courseCode = ? where tutorId = ?', [$firstname, $surname, $email, $phone, $courseCode, $tutorId]);

            Alert::success('Success', 'Update was successful.');


        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            
        }

        return back();
        
    }

    /** Fetch Tutors records from DB */
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
