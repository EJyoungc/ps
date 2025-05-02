<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSupplier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( Auth::user()->hasRole('supplier') && empty(Auth::user()->supplier_id)) {
            // User is a supplier and has a supplier ID
           return redirect()->route('check.supplier');
        }else{

            return $next($request);

        }

       
    }
}
