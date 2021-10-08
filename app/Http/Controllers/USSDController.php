<?php

namespace App\Http\Controllers;

use DB;
use App\Unit;
use App\Tutor;
Use App\Lesson;
use Illuminate\Http\Request;

class USSDController extends Controller
{
    /** USSD Functionality*/
    public function ussdMenu(Request $request)
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
