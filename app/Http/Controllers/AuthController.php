<?php

namespace App\Http\Controllers;

use App\Tutor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class AuthController extends Controller
{
    /**
     * Adds New Tutor Record
    */
    public function register(Request $request)
    {
        $tutor = new Tutor();
        $tutor->tutorId = $request->tutorId;
        $tutor->firstname = $request->firstName;
        $tutor->surname = $request->surname;
        $tutor->email = $request->email;
        $tutor->phone = $request->phone;
        $tutor->role = "regular";
        $tutor->courseCode = $request->courseCode;
        $tutor->status = "pending";

        try{
            
            /*Adds record to db*/
            $tutor->save();
            Alert::success('Success','Details have been submitted successfully. An email will be sent with your login credentials upon approval.');
            return redirect('login');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            /*Catches duplicate error */
            if($errorCode == '1062'){

                Alert::error('Oops', 'Tutor ID ' .$request->tutorId. ' is already registered. Please login to continue.')->persistent(true,false);
                return redirect('login');

            /*Catches all other errors */
            }else{

                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
                return back();

            }

            
        }

    }


    /**
     * Authenticates Credentials
    */
    public function login(Request $request)
    {
        $tutorId = $request->tutorId;
        $password = $request->password;

        try{
            /*Checks if tutor record exists */
            $credentials = Tutor::where('tutorId', $tutorId)->where('password', $password)->count();

            /*Invalid credentials */
            if ($credentials == 0) {

                Alert::error('Oops', 'Invalid login credentials. Please try again.')->persistent(true,false);
                return back();

            /*Correct credentials -- Check tutor status */
            } else {

                $status = Tutor::select('status')->where('tutorId', $tutorId)->get()->first();

                if($status->status == 'active'){

                    $request->session()->put('tutorId',$tutorId);
                    return redirect('dashboard');

                }elseif($status->status == 'pending'){

                    Alert::error('Oops', 'Your details are still being processed. Please wait for approval.')->persistent(true,false);
                    return back();

                }else{

                    $request->session()->put('tutorId',$tutorId);
                    Alert::toast("You're required to change your password before proceeding.", 'info')->persistent(false, true);

                    return redirect('resetpassword');
                    
                    
                }
            }

        } catch(\Illuminate\Database\QueryException $e){

            /*Catches errors */
            Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            return back();
                
        }

    }

    /**
     * Resets Password
    */
    public function resetPassword(Request $request)
    {
        
        $tutorId = $request->tutorId;
        $password = $request->password;

        try{
            
            DB::update('UPDATE tutors SET password = ?, status = ? where tutorId = ?', [$password, 'active', $tutorId]);
            Alert::success('Success', 'Password reset was successful.')->persistent(true,false);

            $request->session()->put('tutorId',$tutorId);
            return redirect('dashboard');

        } catch(\Illuminate\Database\QueryException $e){

            /*Catches errors */
            Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
            return back();
                
        }

    }


    /**
     * Logsout user
    */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('login');
    }
}
