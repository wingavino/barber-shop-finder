<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class ShopOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      if (Auth::user()->type == 'shopowner'
        or Auth::user()->pending_request
                  ->where('request_type', 'change-user-type')
                  ->where('change_to_user_type', 'shopowner')
                  ->first()
      ){
        return $next($request);
      }else {
        return redirect('/home');
      }
    }
}
