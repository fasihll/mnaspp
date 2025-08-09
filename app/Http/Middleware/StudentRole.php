<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek jika biodata belum lengkap
        if (!Student::where('user_id', Auth::id())->exists()) {
            if ($request->route()->getName() != 'student.biodata') {
                return redirect()->route('student.biodata')
                    ->with('error', 'Silakan lengkapi biodata terlebih dahulu');
            }
        }

        return $next($request);
    }
}
