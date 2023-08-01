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
    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Lakukan validasi login
        if (Auth::attempt($credentials)) {
            // Jika login berhasil
            return redirect()->intended('dashboard');
        } else {
            // Jika login gagal
            dd("Gagal login", $credentials); // Tampilkan pesan "Gagal login" dan data yang dikirimkan oleh pengguna
            return redirect()->back()->withInput();
        }
    }

    public function showRegisterForm()
    {
        return view('auth/register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:data_pengguna_jasa',
            'password' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'hak_akses' => 'required|string',
        ]);

        // Simpan data pelanggan ke dalam database
        $kodePJ = DB::table('data_pengguna_jasa')
        ->where('id_pengguna', 'like', "CUST%")
        ->orderBy('id_pengguna', 'desc')
        ->value('id_pengguna');

        if ($kodePJ) {
            // Jika sudah ada kode keluhan pada bulan dan tahun yang sama, ambil nomor urut terakhir
            $lastNumberPJ = (int) substr($kodePJ, -4);
            $newNumberPJ = str_pad($lastNumberPJ + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada kode keluhan pada bulan dan tahun yang sama, nomor urut dimulai dari 1
            $newNumberPJ = '0001';
        }
        $newKodePJ = "CUST-$newNumberPJ";

        // UserModel::create([
        //     'id_pengguna' => $newKodePJ,
        //     'nama' => $request->nama,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'no_telepon' => $request->no_telepon,
        //     'hak_akses' => $request->hak_akses,
        // ]);
        $dataPelanggan = [
            'id_pengguna' => $newKodePJ,
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'no_telepon' => $request->input('no_telepon'),
            'hak_akses' =>'pengguna_jasa',
        ];
        DB::table('data_pengguna_jasa')->insert($dataPelanggan);

        // Tambahkan proses login otomatis setelah registrasi jika diperlukan
        // Auth::login($dataPenggunaJasa);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun yang baru saja dibuat.');
    }
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
