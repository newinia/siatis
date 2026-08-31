<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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
        /*
        |--------------------------------------------------------------------------
        | Cek akun sebelum proses login
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $request->email)->first();

        // Kalau email ditemukan dan akun masih pending
        if ($user && $user->status === 'pending') {
            return back()
                ->withErrors([
                    'email' => 'Akun kamu masih menunggu persetujuan Super Admin.',
                ])
                ->withInput($request->only('email'));
        }

        // Kalau akun ditolak
        if ($user && $user->status === 'rejected') {
            return back()
                ->withErrors([
                    'email' => 'Akun kamu ditolak oleh Super Admin. Silakan hubungi administrator.',
                ])
                ->withInput($request->only('email'));
        }

        /*
        |--------------------------------------------------------------------------
        | Lanjutkan proses login
        |--------------------------------------------------------------------------
        */

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(
            route('dashboard', absolute: false)
        );
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
