<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() != true) {
            return redirect('/login')
                ->with('cannot', 'กรุณาเข้าสู่ระบบ.');
        }

        if (Auth::user()->active == 0) {

            Auth::logout();

            return redirect('/login')
                ->with('cannot', 'บัญชีนี้ถูกยกเลิกการใช้งาน.');
        }

        return $next($request);
    }
}
