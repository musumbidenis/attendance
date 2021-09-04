<?php

namespace App\Http\Middleware;

use RealRashid\SweetAlert\Facades\Alert;
use App\Tutor;
use Closure;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tutorId = $request->session()->get('tutorId');
        $role = Tutor::select('role')->where('tutorId', $tutorId)->get()->first();

        if($role->role == 'admin'){

            return $next($request);

        }else {

            Alert::error('Oops', 'You dont have admin priviledges to access this resource.')->persistent(true,false);
            return back();

        }
        
    }
}
