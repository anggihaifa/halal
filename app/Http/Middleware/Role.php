<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\System\User;
use Illuminate\Support\Facades\Session;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        if (!Auth::check()){
            // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
            return redirect('login');
        } 

        $user = Auth::user();
        
        foreach($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            if($user->usergroup_id == $role)
                return $next($request);
        }
        Session::flash('warning', 'Anda tidak memiliki akses ke halaman yang dimaksud!');   
        return redirect('login');
    }
}
