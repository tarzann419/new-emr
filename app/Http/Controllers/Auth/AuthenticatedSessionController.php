<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Redirect based on role
        if ($user->hasRole('admin')) {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->hasRole('doctor')) {
            return redirect()->intended('/doctor/dashboard');
        } elseif ($user->hasRole('nurse')) {
            return redirect()->intended('/nurse/dashboard');
        } elseif ($user->hasRole('pharmacy')) {
            return redirect()->intended('/pharmacy/dashboard');
        } elseif ($user->hasRole('patient')) {
            return redirect()->intended('/patient/home');
        }

        return redirect()->intended('/dashboard'); // fallback
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
