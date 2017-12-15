<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class CheckTeacher
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
        return $next($request);
        $role = User::find(Auth::id())->role;
        if ($role ==1 || $role == 2) {
            return $next($request);
        } else {
            return redirect(route('home'));
        }
    }
}
