<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ApiController;
use Closure;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;

class UserMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $result=(new ApiController())->check_user();
        if ($result){
            return $next($request);
        }else{
            return redirect()->route('login')->withErrors('ابتدا وارد شوید!');
        }
    }
}
