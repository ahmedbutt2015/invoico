<?php

namespace App\Http\Middleware;

use App\Plan;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Invoice extends Middleware
{
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            $plan = Plan::find(auth()->user()->plan_id);
            if($plan){
                if(\App\Invoice::where('user_id',auth()->id())->count() >= $plan->invoices){
                    return redirect('/')->withErrors('Your invoice limit exceeded, please switch to a better plan.');
                }
            }
        }

        return $next($request);
    }
}
