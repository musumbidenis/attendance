<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use App\Unit;
use App\Tutor;
Use App\Lesson;
use App\Student;
use App\Attendance;
use App\UnitRegistration;
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

            $response  = "CON Reply with: \n";
            $response .= "1. Create Lesson \n";
            $response .= "2. Class Attendance Record";

            echo $response;

        }elseif ($level == 2) {

            if ($ussd_string_exploded[1] == '1') {
                
                echo "CON Enter your Tutor ID:";

            }elseif ($ussd_string_exploded[1] == '2'){

                echo "END Menu construction in progress";

            }else{

                echo "END Invalid choice. Please try again.";

            }

        }elseif($level == 3){

            //Verify the Tutor ID
            $tutorId = $ussd_string_exploded[2];
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
        
        }elseif ($level == 4) {

            //Get the Unit Code selected
            $tutorId = $ussd_string_exploded[2];
            $units = Unit::where('tutorId', $tutorId)->get();
            $unitCode = $units[$ussd_string_exploded[3]-1]->unitCode;

            echo "CON Set the starting time for $unitCode in 24-hour format: e.g 08:00, 14:00";

        }elseif($level == 5){

            $tutorId = $ussd_string_exploded[2];
            $units = Unit::where('tutorId', $tutorId)->get();
            $unitCode = $units[$ussd_string_exploded[3]-1]->unitCode;
            $lessonStart = $ussd_string_exploded[4];

            if( strtotime($lessonStart) < strtotime(now()) ){//Trying to schedule a lesson "before" current time
                
                echo "END Specified time has elapsed. Unable to schedule a lesson at that time.";

            }else{//Confirmation menu

                $formatedDate = date_format(date_create($lessonStart), 'g:i A');

                $response = "CON You're scheduling $unitCode to start at $formatedDate. \n";
                $response .= "1. Save \n";
                $response .= "2. Cancel";

                echo $response;

            }
            
            

        }elseif($level == 6) {

            if($ussd_string_exploded[5] == '1'){
                
                //Get details
                $date = date('Y-m-d');
                $time = $ussd_string_exploded[4];//Start lesson time
                $lessonStart = $date.' '. $time;//Concatenate today's date and start time for lesson
                $lessonStop = date('Y-m-d H:i', strtotime('+2 hours', strtotime($lessonStart)));//2 hours per lesson rule;
                
                //Get the selected Unit Code using Tutors ID and response
                $tutorId = $ussd_string_exploded[2];
                $units = Unit::where('tutorId', $tutorId)->get();
                $unitCode = $units[$ussd_string_exploded[3]-1]->unitCode;

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

            $response  = "CON Reply with: \n";
            $response .= "1. Sign Attendance \n";
            $response .= "2. Class Attendance Record";

            echo $response;

        }elseif ($level == 2) {

            if ($ussd_string_exploded[1] == '1' || $ussd_string_exploded[1] == '2') {
                
                echo "CON Enter your admission number in the format, e.g ci/xxxxx/xx";

            }else{

                echo "END Invalid choice. Please try again.";

            }

        }elseif($level == 3){

            //Verify the Student ID
            $studentId = $ussd_string_exploded[2];
            $credentials = Student::where('studentId', $studentId)->count();

            //Student record does not exist
            if ($credentials == 0) {

                echo "END Student ID record does not exist. Contact the system admin for assistance.";

            //Student record exists
            }else{

                //Verify Phone Number against Student ID
                $verification = Student::where('studentId', $studentId)->where('phone', $phoneNumber)->count();

                //Not true
                if ($verification == 0) {

                    echo "END Phone Number is not registered to $studentId. Contact the system admin for assistance.";

                }else{

                    //Check if student has registered for units
                    $check = DB::table('unitRegistrations')
                            ->join('units', 'units.unitCode', '=', 'unitRegistrations.unitCode')
                            ->join('students', 'students.studyPeriod', '=', 'units.studyPeriod')
                            ->where('students.studentId', '=', $studentId)
                            ->count();
                    
                    //Not registered
                    if($check == 0 ){

                        //Notify user and display unit registration menu 
                        echo "END You've not registered for units. Please do so to continue.";

                    }else{

                        if ($ussd_string_exploded[1] == '1') {//User selected option one (Sign Attendance)
                            
                           //Use the Student ID and get units with lessons for that day
                           $lessons = DB::table('lessons')
                                ->join('units', 'units.unitCode', '=', 'lessons.unitCode')
                                ->join('students', 'students.courseCode', '=', 'units.courseCode')
                                ->where('students.studentId', '=', $studentId)
                                ->whereRaw('Date(lessons.lessonStart) = CURDATE()')
                                ->orderBy('lessons.lessonStart', 'asc')
                                ->get();

                            if ( count($lessons) > 0 ) {//There are lessons that day

                                $i = 1;
                                $response  = "CON Select unit to sign attendance:\n";

                                foreach ($lessons as $lesson) {

                                    //Format dates in AM, PM
                                    $lessonStart = date_format(date_create($lesson->lessonStart), 'g:i A');
                                    $lessonStop = date_format(date_create($lesson->lessonStop), 'g:i A');

                                    $response .= "$i. $lesson->unitCode - ($lessonStart to $lessonStop)\n";
                                    $i++;

                                }

                                echo $response;

                            }else{//No lessons have been created for that day

                                echo "END There are no active lessons today.\n";

                            }

                        }else{//User selected option two (Class Attendance record)

                            //Get all registered units for student
                            $units = DB::table('unitRegistrations')
                                ->select('unitRegistrations.unitCode')
                                ->join('units', 'units.unitCode', '=', 'unitRegistrations.unitCode')
                                ->join('students', 'students.studyPeriod', '=', 'units.studyPeriod')
                                ->where('students.studentId', '=', $studentId)
                                ->get();

                            foreach ($units as $unit) {

                                $unitCode = $unit->unitCode;

                                //Calculate attendance record for each unit
                                $details = DB::table('units')
                                        ->select(DB::raw("
                                            (SELECT units.unitCode) AS unitCode,
                                            (SELECT units.description) AS unitName, 
                                            (SELECT COUNT(*) FROM lessons WHERE unitCode = '$unitCode') AS lessons,
                                            (SELECT COUNT(*) FROM attendances JOIN lessons ON lessons.lessonId = attendances.lessonId WHERE lessons.unitCode = '$unitCode') AS lessonsAttended,

                                            ((SELECT COUNT(*) FROM attendances JOIN lessons ON lessons.lessonId = attendances.lessonId WHERE lessons.unitCode = '$unitCode') /
                                            (SELECT COUNT(*) FROM lessons WHERE unitCode = '$unitCode') * 100) AS record"),
                                        )
                                        ->join('students', 'students.studyPeriod', '=', 'units.studyPeriod')
                                        ->join('attendances', 'attendances.studentId', '=', 'students.studentId')
                                        ->join('lessons', 'lessons.lessonId', '=', 'attendances.lessonId')
                                        ->where('students.studentId', '=', $studentId)
                                        ->where('units.unitCode', '=', $unitCode)
                                        ->distinct()
                                        ->get();

                                //Fetch the calculations of each unit
                                foreach ($details as $detail){

                                    $records[] = $detail;//Add them to the records array

                                }


                            }

                            //Send the attendance record to the student's email address
                            $data = [
                                'records' => $records,
                                'email' => 'musumbidenis@gmail.com',
                            ];
                    
                            Mail::send('emails.studentAttendance', $data, function($message) use ($data) {
                                $message->to($data['email'])
                                        ->subject('Attendance Record');
                            });

                            
                        }
                        
                    }

                }
            }        
        
        }elseif($level == 4){

            //Use the Student ID and get units with lessons for that day
            $studentId = $ussd_string_exploded[2];
            $units = DB::table('lessons')
                    ->join('units', 'units.unitCode', '=', 'lessons.unitCode')
                    ->join('students', 'students.courseCode', '=', 'units.courseCode')
                    ->where('students.studentId', '=', $studentId)
                    ->whereRaw('Date(lessons.lessonStart) = CURDATE()')
                    ->orderBy('lessons.lessonStart', 'asc')
                    ->get();
            
            $lessonStop = $units[$ussd_string_exploded[3]-1]->lessonStop;
            $lessonStart = $units[$ussd_string_exploded[3]-1]->lessonStart;

            if(now() > $lessonStop){//Lesson ended

                $formatedDate = date_format(date_create($lessonStop), 'g:i A');

                echo "END You can't sign attendance. Lesson ended at $formatedDate. ";

            }else if(now() < $lessonStart){//lesson has not started

                $formatedDate = date_format(date_create($lessonStart), 'g:i A');

                echo "END You can't sign attendance. Lesson starts at $formatedDate. ";

            }else{//Lesson active ==> Sign attendance

                $attendance = new Attendance();
                $attendance->studentId = $studentId;
                $attendance->lessonId = $units[$ussd_string_exploded[3]-1]->lessonId;

                $attendance->save();

                echo "END Attendance signed successfully.";

            }
            
        }
    }

    Public function studentAttendanceMenu($ussd_string_exploded, $phoneNumber)
    {
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);

        if ($level == 2) {

            echo "CON Enter your admission number in the format, e.g ci/xxxxx/xx";

        }elseif($level == 3){

            //Verify the Student ID
            $studentId = $ussd_string_exploded[2];
            $credentials = Student::where('studentId', $studentId)->count();

            //Student record does not exist
            if ($credentials == 0) {

                echo "END Student ID record does not exist. Contact the system admin for assistance.";

            //Student record exists
            }else{

                //Verify Phone Number against Student ID
                $verification = Student::where('studentId', $studentId)->where('phone', $phoneNumber)->count();

                //Not true
                if ($verification == 0) {

                    echo "END Phone Number is not registered to $studentId. Contact the system admin for assistance.";

                }else{

                    //Check if student has registered for units
                    $check = DB::table('unitRegistrations')
                            ->join('units', 'units.unitCode', '=', 'unitRegistrations.unitCode')
                            ->join('students', 'students.studyPeriod', '=', 'units.studyPeriod')
                            ->where('students.studentId', '=', $studentId)
                            ->count();
                    
                    //Not registered
                    if($check == 0 ){

                        //Notify user and display unit registration menu 
                        echo "END You've not registered for units. Please do so to continue.";

                    }else{
                        
                    }

                }
            }    
        }

    }
}
