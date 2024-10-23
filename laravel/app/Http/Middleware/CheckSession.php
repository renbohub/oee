<?php

namespace App\Http\Middleware;

use Closure;
use Session;

use Illuminate\Support\Facades\Route;



class CheckSession
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
        $d = $request->session()->all();
        $data = isset($d['token']) ? $d['token'] : null;       
        if ($data != null) {
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}