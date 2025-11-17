<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'welcome'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => '123',
            'hak_akses' => 'pengguna_jasa',
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        if (Auth::user()->hak_akses == 'admin') {
            return redirect()->route('dashboard')
            ->withSuccess('You have successfully logged in as admin!');
        } elseif (Auth::user()->hak_akses == 'pengguna_jasa') {
            return redirect()->route('dashboard-pj')
            ->withSuccess('You have successfully logged in as Pengguna Jasa!');
        } elseif (Auth::user()->hak_akses == 'customer_service') {
            return redirect()->route('dashboard-cs')
            ->withSuccess('You have successfully logged in as CS!');
        }
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->hak_akses == 'admin') {
                return redirect()->route('dashboard')
                    ->withSuccess('You have successfully logged in as admin!');
            } elseif (Auth::user()->hak_akses == 'pengguna_jasa') {
                return redirect()->route('dashboard-pj')
                    ->withSuccess('You have successfully logged in as Pengguna Jasa!');
            }elseif (Auth::user()->hak_akses == 'customer_service') {
                return redirect()->route('dashboard-cs')
                    ->withSuccess('You have successfully logged in as CS!');
            }
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }

    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect()->route('login')
        ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess('You have logged out successfully!');;
    }
}
