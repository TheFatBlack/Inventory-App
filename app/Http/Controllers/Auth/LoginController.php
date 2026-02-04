<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if (!$user) {
            return '/home';
        }

        $role = strtolower((string) $user->role);

        if ($role === 'admin') {
            return '/admin';
        }

        if ($role === 'petugas') {
            return '/petugas/dashboard';
        }

        if ($role === 'pengguna') {
            return '/pengguna/dashboard';
        }

        return '/home';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
