<?php

namespace App\Http\Middleware;

use RealRashid\SweetAlert\Facades\Alert;
use Closure;

class isLoggedIn
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
        if(session()->has('tutorId')){
            return $next($request);
        }

        Alert::error('Oops', 'You must be logged in to access this resource.')->persistent(true,false);
        return redirect('login');
    }
}
