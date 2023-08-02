<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserModel;
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
     * @return \Illuminate\Http\Response
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

        UserModel::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => '123',
            'hak_akses' => 'pengguna_jasa',
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect('dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            }elseif (Auth::user()->hak_akses == 'cs') {
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
     * @return \Illuminate\Http\Response
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

    // public function showLoginForm()
    // {
    //     return view('auth/login');
    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     // Lakukan validasi login
    //     if (Auth::attempt($credentials)) {
    //         // Jika login berhasil
    //         return redirect()->intended('dashboard');
    //     } else {
    //         // Jika login gagal
    //         dd("Gagal login", $credentials); // Tampilkan pesan "Gagal login" dan data yang dikirimkan oleh pengguna
    //         return redirect()->back()->withInput();
    //     }
    // }

    // public function showRegisterForm()
    // {
    //     return view('auth/register');
    // }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'email' => 'required|string|email|unique:data_pengguna_jasa',
    //         'password' => 'required|string',
    //         'no_telepon' => 'required|string|max:15',
    //         'hak_akses' => 'required|string',
    //     ]);

    //     // Simpan data pelanggan ke dalam database
    //     $kodePJ = DB::table('data_pengguna_jasa')
    //     ->where('id_pengguna', 'like', "CUST%")
    //     ->orderBy('id_pengguna', 'desc')
    //     ->value('id_pengguna');

    //     if ($kodePJ) {
    //         // Jika sudah ada kode keluhan pada bulan dan tahun yang sama, ambil nomor urut terakhir
    //         $lastNumberPJ = (int) substr($kodePJ, -4);
    //         $newNumberPJ = str_pad($lastNumberPJ + 1, 4, '0', STR_PAD_LEFT);
    //     } else {
    //         // Jika belum ada kode keluhan pada bulan dan tahun yang sama, nomor urut dimulai dari 1
    //         $newNumberPJ = '0001';
    //     }
    //     $newKodePJ = "CUST-$newNumberPJ";

    //     // UserModel::create([
    //     //     'id_pengguna' => $newKodePJ,
    //     //     'nama' => $request->nama,
    //     //     'email' => $request->email,
    //     //     'password' => Hash::make($request->password),
    //     //     'no_telepon' => $request->no_telepon,
    //     //     'hak_akses' => $request->hak_akses,
    //     // ]);
    //     $dataPelanggan = [
    //         'id_pengguna' => $newKodePJ,
    //         'nama' => $request->input('nama'),
    //         'email' => $request->input('email'),
    //         'password' => Hash::make($request->input('password')),
    //         'no_telepon' => $request->input('no_telepon'),
    //         'hak_akses' =>'pengguna_jasa',
    //     ];
    //     DB::table('data_pengguna_jasa')->insert($dataPelanggan);

    //     // Tambahkan proses login otomatis setelah registrasi jika diperlukan
    //     // Auth::login($dataPenggunaJasa);

    //     return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun yang baru saja dibuat.');
    // }
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     UserModel::create([
    //         'nama' => $request->nama,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'no_telepon' => $request->no_telepon,
    //         'jenis_pengguna' => 'pengguna_jasa',
    //     ]);
    //     // $dataPelanggan = [
    //     //     'nama' => $request->name,
    //     //     'email' => $request->email,
    //     //     'password' => Hash::make($request->password),
    //     //     'no_telepon' => $request->no_telepon,
    //     //     'jenis_pengguna' => 'pengguna_jasa',
    //     // ];
    //     // DB::table('data_pengguna_jasa')->insert($dataPelanggan);

    //     // Jika registrasi berhasil, redirect ke halaman yang diinginkan
    //             return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');

    // }
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'no_telepon' => 'required|string|max:15',
    //         'hak_akses' => 'required|string|in:admin,user',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     UserModel::create([
    //         'nama' => $request->input('nama'),
    //         'email' => $request->input('email'),
    //         'password' => Hash::make($request->input('password')),
    //         'no_telepon' => $request->input('no_telepon'),
    //         'hak_akses' => $request->input('hak_akses'),
    //     ]);

    //     return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    // }
}
