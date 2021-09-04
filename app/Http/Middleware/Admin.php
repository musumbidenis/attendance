<?php

namespace App\Http\Middleware;

use RealRashid\SweetAlert\Facades\Alert;
use Closure;
use Session;

class Admin
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

        Alert::success('Student record inserted successfully');
        return redirect('login');
        
    }
}
