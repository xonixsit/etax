<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     if (! $request->expectsJson()) {
    //         if ($request->is('employee*')) {
    //             return route('employee.login');
    //         }
            
    //         return route('admin.login');
    //     }
        
    //     return null;
    // }

    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->is('employee*')) {
                return route('employee.login');
            }
            
            return route('admin.login');
        }
        
        return null;
    }

}