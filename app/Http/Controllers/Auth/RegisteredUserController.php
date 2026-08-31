<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'role' => [
                'required',
                'string',
                'in:instruktur,medis',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buat akun sebagai PENDING
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),

            // Akun baru harus menunggu ACC Super Admin
            'status' => 'pending',
        ]);

        event(new Registered($user));

        /*
        |--------------------------------------------------------------------------
        | Jangan login otomatis
        |--------------------------------------------------------------------------
        |
        | Sebelumnya ada Auth::login($user).
        | Sekarang dihapus karena akun masih menunggu persetujuan.
        |
        */

        return redirect()
            ->route('login')
            ->with(
                'status',
                'Pendaftaran berhasil! Akun kamu sedang menunggu persetujuan Super Admin.'
            );
    }
}
