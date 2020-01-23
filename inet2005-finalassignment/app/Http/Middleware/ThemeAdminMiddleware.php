<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThemeAdminMiddleware
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
        if(Auth::check())
        {
            $existId = DB::table('role_user')->select('role_user.user_id')->where('role_user.role_id', '=', '2')->distinct()->pluck('role_user.user_id')->toArray();
            if(in_array($request->user()->id, $existId))
            {
                return $next($request);
            }
            return redirect('/feed');
        }

        return redirect('/auth/login');
    }
}
