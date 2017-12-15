<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class CheckManager
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
        $role = User::find(Auth::id())->role;
        if ($role ==1 || $role == 4) {
            return $next($request);
        } else {
            return redirect(route('home'));
        }
    }
}
