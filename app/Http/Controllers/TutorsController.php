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

    /** USSD Functionality*/
    public function createLesson(Request $request)
    {
       $sessionId   = $request->get('sessionId');
       $serviceCode = $request->get('serviceCode');
       $phoneNumber = $request->get('phoneNumber');
       $text        = $request->get('text');
       
        // use explode to split the string text response from Africa's talking gateway into an array.
        $ussd_string_exploded = explode("*", $text);

        if ($text == "") {

            // first response when a user dials our ussd code
            $response  = "CON Welcome. Reply with: \n";
            $response .= "1. Tutor \n";
            $response .= "2. Student";

            echo $response;

        }else{

            switch ($text) {
                case 1:
                    //Tutor Menu
                    $this->tutorMenu($ussd_string_exploded, $phoneNumber);
                    break;
                case 2:
                    //Student Menu
                    $this->studentMenu($ussd_string_exploded, $phoneNumber);
                    break;
                default:
                    //Invalid choice
                    echo "END Invalid choice. Please try again.";
                    break;
            }   

        }

    }

    /** Tutor USSD Menu */
    Public function tutorMenu($ussd_string_exploded, $phoneNumber)
    {
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);

        if ($level == 1) {

           echo "CON Enter your Tutor ID:";

        }elseif ($level == 2) {

            //Verify the Tutor ID
            $tutorId = $ussd_string_exploded[1];
            $credentials = Tutor::where('tutorId', $tutorId)->count();

            //Tutor record does not exist
            if ($credentials == 0) {

                echo "END Tutor ID record does not exist. Contact the system admin for assistance.";

            //Tutor record exists
            }else{

                //Verify Phone Number against Tutor ID
                $verification = Tutor::where('tutorId', $tutorId)->where('phone', $phoneNumber)->count();

                if ($verification == 0) {

                    echo "END Phone Number is not registered to $tutorId. Contact the system admin for assistance.";

                }else{

                    //Use the Tutor ID and get units they teach
                    $units = Unit::where('tutorId', $tutorId)->get();

                    $i = 1;

                    $response  = "CON Select unit to create a lesson:\n";
                    foreach ($units as $unit) {
                        $response .= "$i. $unit->unitCode \n";
                        $i++;
                    }

                    echo $response;

                }
            }
        
        }elseif ($level == 3) {

            //Get the Unit Code selected
            $tutorId = $ussd_string_exploded[1];
            $units = Unit::where('tutorId', $tutorId)->get();
            $unitCode = $units[$ussd_string_exploded[2]-1]->unitCode;

            echo "CON Set the starting time for $unitCode in the following formart, e.g 08:00";

        }elseif($level == 4){

            $tutorId = $ussd_string_exploded[1];
            $units = Unit::where('tutorId', $tutorId)->get();
            $unitCode = $units[$ussd_string_exploded[2]-1]->unitCode;
            $lessonStart = $ussd_string_exploded[3];

            $response = "CON You're setting $unitCode lesson to start at $lessonStart. \n";
            $response .= "1. Confirm \n";
            $response .= "2. Cancel";

            echo $response;

        }elseif($level == 5) {

            if($ussd_string_exploded[4] == '1'){
                
                //User chose saving lesson data
                $date = date('Y-m-d');
                $time = $ussd_string_exploded[3];
                $lessonStart = $date.' '. $time;
                $lessonStop = date('Y-m-d H:i', strtotime('+2 hours', strtotime($lessonStart)));
                $stop = now();
                
                //Get the selected Unit Code using Tutors ID and response
                $tutorId = $ussd_string_exploded[1];
                $units = Unit::where('tutorId', $tutorId)->get();
                $unitCode = $units[$ussd_string_exploded[2]-1]->unitCode;

                //Store lesson record to DB
                $lesson = new Lesson();
                $lesson->lessonStart = $lessonStart;
                $lesson->lessonStop = $lessonStop;
                $lesson->tutorId = $tutorId;
                $lesson->unitCode = $unitCode;

                $lesson->save();

                echo "END Lesson for $unitCode has been created successfully.";

            }else{

                echo "END You canceled lesson creation process.";

            }
        }
    }

    /** Student USSD Menu */
    Public function studentMenu($ussd_string_exploded, $phoneNumber){
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);

        if ($level == 1) {

            echo "CON Enter your admission number in the format, e.g ci/xxxxx/20xx";

        }
    }
}
