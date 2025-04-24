<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        /**
         * @var User $user
        */ 

        if (!$user || !$user->hasPermission($permission)) {
            return response()->view('403', [], 403);
        }

        return $next($request);
    }
}
