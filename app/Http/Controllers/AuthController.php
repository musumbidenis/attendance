<?php

namespace App\Http\Controllers;

use App\Tutor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
            
            $tutor->save();
            Alert::success('Success','Details have been submitted for approval. An email will be sent with your login credentials.');
            return redirect('/login');

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){

                Alert::error('Oops', 'Tutor ID ' .$request->tutorId. ' is already registered. Please login to continue.')->persistent(true,false);
                return redirect('/login');

            }else{

                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
                return back();

            }

            
        }

    }


    /**
     * Adds New Tutor Record
    */
    public function login(Request $request)
    {
        $tutorId = $request->tutorId;
        $password = $request->password;

        try{
            /*Check if tutor record exists */
            $credentials = Tutor::where('tutorId', $tutorId)->count();

            /*Tutor does not exist */
            if ($credentials == 0) {

                Alert::error('Oops', 'Invalid login credentials. Please register for an account.')->persistent(true,false);
                return back();

            /*Tutor exists -- Check tutor status */
            } else {

                $status = Tutor::select('status')->where('tutorId', $tutorId)->get()->first();

                switch ($status) {
                    case 'active':

                        $request->session()->put('tutorId',$tutorId);
                        return redirect('/dashboard');
                        break;

                    case 'approved':

                        $request->session()->put('tutorId',$tutorId);
                        return view('auth.resetPassword');

                        break;

                    default:

                        Alert::error('Oops', 'Incorrect login credentials. Please try again.')->persistent(true,false);
                        break;
                }
            }

        } catch(\Illuminate\Database\QueryException $e){

            $errorCode = $e->errorInfo[1];

            if($errorCode == '1062'){

                Alert::error('Oops', 'Tutor ID ' .$request->tutorId. ' is already registered. Please login to continue.')->persistent(true,false);
                return redirect('/login');

            }else{

                Alert::error('Oops', $e->errorInfo[2])->persistent(true,false);
                return back();
                
            }

            
        }

    }
}
