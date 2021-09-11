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
        $userDetails = $request->session()->get('userDetails');

        if($userDetails->role == 'admin'){

            return $next($request);

        }else {

            Alert::error('Oops', 'You dont have admin priviledges to access this resource.')->persistent(true,false);
            return back();

        }
        
    }
}
