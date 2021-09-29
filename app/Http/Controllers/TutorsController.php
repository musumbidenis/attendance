<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use App\Unit;
use App\Tutor;
Use App\Lesson;
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

    /**
     * Tutor creates a lesson
    */
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
            $response  = "CON Welcome. Select your category \n";
            $response .= "1. Tutor \n";
            $response .= "2. Student";

        }else{

            switch ($text) {
                case 1:
                    //Tutor Menu
                    $this->tutorMenu($ussd_string_exploded);
                    // $response = "CON Please enter your Tutor ID";
                    break;
                case 2:
                    //Student Menu
                    break;
                default:
                    //Invalid choice
                    $response = "END Invalid choice. Please try again.";
                    break;
            }

            

        }
        // elseif ($level == 2) {

        //     //Verify the Tutor ID
        //     $tutorId = $ussd_string_exploded[1];
        //     $credentials = Tutor::where('tutorId', $tutorId)->count();

        //     //Tutor record does not exist
        //     if ($credentials == 0) {

        //         $response = "END Tutor ID record does not exist. Please contact the system admin for assistance.";

        //     //Tutor record exists
        //     }else{

        //         //Verify Phone Number against Tutor ID
        //         $credentials = Tutor::where('tutorId', $tutorId)->where('phone', $phoneNumber)->count();

        //         if ($credentials == 0) {

        //             $response = "END Phone Number is not registered to $tutorId. Contact the system admin for assistance.";

        //         }else{

        //             //Use the Tutor ID and get units they teach
        //             $units = Unit::where('tutorId', $tutorId)->get();

        //             $i = 1;

        //             $response  = "CON Select unit to create a lesson.\n";
        //             foreach ($units as $unit) {
        //                 $response .= "$i. $unit->unitCode \n";
        //                 $i++;
        //             }

        //         }
        //     }
        
        // }elseif ($level == 3) {

        //     //Get the Unit Code selected
        //     $tutorId = $ussd_string_exploded[1];
        //     $units = Unit::where('tutorId', $tutorId)->get();
        //     $unitCode = $units[$ussd_string_exploded[2]-1]->unitCode;

        //     $response = "CON Set the starting time for $unitCode in the following formart, e.g 08:00";

        // }elseif($level == 4){

        //     $tutorId = $ussd_string_exploded[1];
        //     $units = Unit::where('tutorId', $tutorId)->get();
        //     $unitCode = $units[$ussd_string_exploded[2]-1]->unitCode;
        //     $lessonStart = $ussd_string_exploded[3];

        //     $response = "CON You're setting $unitCode lesson to start at $lessonStart. \n";
        //     $response .= "1. Save \n";
        //     $response .= "2. Cancel";

        // }elseif($level == 5) {

        //     if($ussd_string_exploded[4] == '1'){
                
        //         //User chose saving lesson data
        //         $date = date('Y-m-d');
        //         $time = $ussd_string_exploded[3];
        //         $lessonStart = $date.' '. $time;
        //         $lessonStop = date('Y-m-d H:i', strtotime('+2 hours', strtotime($lessonStart)));
        //         $stop = now();
                
        //         //Get the selected Unit Code using Tutors ID and response
        //         $tutorId = $ussd_string_exploded[1];
        //         $units = Unit::where('tutorId', $tutorId)->get();
        //         $unitCode = $units[$ussd_string_exploded[2]-1]->unitCode;

        //         //Store lesson record to DB
        //         $lesson = new Lesson();
        //         $lesson->lessonStart = $lessonStart;
        //         $lesson->lessonStop = $lessonStop;
        //         $lesson->tutorId = $tutorId;
        //         $lesson->unitCode = $unitCode;

        //         $lesson->save();

        //         $response = "END Lesson for $unitCode has been created successfully";

        //     }else{

        //         $response = "END You canceled lesson creation process";

        //     }
        // }elseif ($text == "2") {

        //     //If user selected 2, send them to the student menu
        //     $response = "CON Please enter your Admission Number";

        // }elseif ($level == 2) {

        //     $response = "CON $ussd_string_exploded[1]";
            
        // }
        // send your response back to the API
        header('Content-type: text/plain');
        echo $response;
    }

    Public function tutorMenu($ussd_string_exploded){
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);

        if ($level == 1) {
           echo "CON Please enter your Tutor ID";
        }
    }
}
