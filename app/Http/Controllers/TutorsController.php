<?php

namespace App\Http\Controllers;

use DB;
use File;
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
    /** Tutors Page */
    public function tutorsPage(Request $request)
    {
        $courses = DB::select('select * from courses');
        $tutors = DB::table('tutors')
                ->select('tutors.tutorId', 'tutors.firstname', 'tutors.surname', 'tutors.email', 'tutors.phone', 'tutors.courseCode', 'courses.description')
                ->join('courses', 'courses.courseCode', '=', 'tutors.courseCode')
                ->get();

        return view('pages.tutors',['tutors'=>$tutors, 'courses'=>$courses]);
    }

    /** Add New Tutor Record from Form */
    public function newTutor(Request $request)
    {

        /** Get input details */
        $phoneNumber = $request->phone;

        /** Format the phone input */
        $phoneNumber = (substr($phoneNumber, 0, 2) == '07') ? preg_replace('/^0/','+254', $phoneNumber) : $phoneNumber;
        $phoneNumber = (substr($phoneNumber, 0, 3) == '254') ? str_replace('254','+254', $phoneNumber) : $phoneNumber;

        $tutor = new Tutor();
        $tutor->tutorId = $request->tutorId;
        $tutor->firstname = $request->firstName;
        $tutor->surname = $request->surname;
        $tutor->email = $request->email;
        $tutor->phone = $phoneNumber;
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
        /** Get input details */
        $phoneNumber = $request->phone;

        /** Format the phone input */
        $phoneNumber = (substr($phoneNumber, 0, 2) == '07') ? preg_replace('/^0/','+254', $phoneNumber) : $phoneNumber;
        $phoneNumber = (substr($phoneNumber, 0, 3) == '254') ? str_replace('254','+254', $phoneNumber) : $phoneNumber;

        $tutorId = $request->tutorId;
        $firstname = $request->firstName;
        $surname = $request->surname;
        $email = $request->email;
        $phone = $phoneNumber;
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

    public function deleteTutor($id)
    {

        Tutor::where('tutorId', $id)->delete();

        return response()->json('Success');

    }

}
