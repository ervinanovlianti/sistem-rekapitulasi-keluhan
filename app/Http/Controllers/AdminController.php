<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use Illuminate\Support\Facades\Hash;
use App\Models\PenggunaJasaModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// use PDF;
use App\Exports\ExportKeluhan;
use App\Imports\ImportKeluhan;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data_keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.nama')
            ->orderBy('tgl_keluhan', 'desc')
            ->paginate(10);
        return view('data_keluhan', compact('data_keluhan'));
    }
    public function rekapitulasi(Request $request)
    {
        $kategoriIds = [1, 2, 3, 4, 5];
        $viaKeluhan = ['Visit', 'Wa/HP', 'Web', 'Walkie Talkie'];
        $statusKeluhan = ['menunggu verifikasi', 'dialihkan ke cs', 'ditangani oleh cs', 'selesai', 'tidak selesai'];

        // Menentukan tanggal awal dan akhir untuk filter
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $rekapData = [];
        foreach ($kategoriIds as $kategoriId) {
            $rekapData[$kategoriId]['kategori'] = DB::table('data_kategori')
                ->where('id_kategori', $kategoriId)
                ->value('kategori_keluhan');

            foreach ($viaKeluhan as $viaOption) {
                $query = DB::table('data_keluhan')
                ->where('kategori_id', $kategoriId)
                ->where('via_keluhan', $viaOption);

                if ($tanggalAwal && $tanggalAkhir) {
                    $query->whereBetween('tgl_keluhan', [$tanggalAwal, $tanggalAkhir]);
                }

                $rekapData[$kategoriId][$viaOption] = $query->count();
            }

            // Filter data berdasarkan tanggal
            $rekapData[$kategoriId]['status']['selesai'] = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId)
            ->whereIn('status_keluhan', ['selesai'])
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('tgl_keluhan', [$tanggalAwal, $tanggalAkhir]);
            })
            ->count();

            $rekapData[$kategoriId]['status']['belum_selesai'] = DB::table('data_keluhan')
                ->where('kategori_id', $kategoriId)
                ->whereIn('status_keluhan', ['menunggu verifikasi', 'dialihkan ke cs', 'ditangani oleh cs'])
                ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                    return $query->whereBetween('tgl_keluhan', [$tanggalAwal, $tanggalAkhir]);
                })
                ->count();

            $rekapData[$kategoriId]['status']['tidak_selesai'] = DB::table('data_keluhan')
                ->where('kategori_id', $kategoriId)
                ->whereIn('status_keluhan', ['tidak selesai'])
                ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                    return $query->whereBetween('tgl_keluhan', [$tanggalAwal, $tanggalAkhir]);
                })
                ->count();

            // Filter data berdasarkan tanggal 
            $rekapData[$kategoriId]['total'] = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId)
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('tgl_keluhan', [$tanggalAwal, $tanggalAkhir]);
            })
            ->count();
        }

        return view('rekapitulasi', compact(
            'rekapData', 
            'viaKeluhan',
            'statusKeluhan',
            'kategoriIds',
        ));
    }
    
    public function laporan()
    {
        $keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.nama')
            ->orderBy('tgl_keluhan', 'desc')
            ->paginate(10);
        return view('laporan', compact('keluhan'));
    }

    public function cari(Request $request)
    {
        $keyword = $request->input('cari');
        $bulan = $request->input('bulan');
        $kategori = $request->input('kategori');

        $keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.nama')
            ->where(function ($query) use ($keyword, $bulan, $kategori) {
                if (!empty($keyword)) {
                    $query->where('uraian_keluhan', 'LIKE', "%$keyword%")
                        ->orWhere('via_keluhan', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('status_keluhan', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('users.nama', 'LIKE', '%' . $keyword . '%'); 
                }
                if (!empty($bulan)) {
                    $query->whereRaw("DATE_FORMAT(tgl_keluhan, '%Y-%m') = ?", [$bulan]);
                }
                if (!empty($kategori)) {
                    $query->where('kategori_keluhan', $kategori);
                }
            })
            ->orderBy('tgl_keluhan', 'desc')
            ->paginate(10);

        return view('laporan', compact('keluhan', 'keyword', 'bulan', 'kategori'));
    }

    public function dashboard()
    {
        // Menghitung total keluhan
        $totalKeluhan = KeluhanModel::count();
        $keluhanBaru = DB::table('data_keluhan')
            ->where('status_keluhan', 'menunggu verifikasi')
            ->count();
        $keluhanDiproses = DB::table('data_keluhan')
            ->where('status_keluhan', 'ditangani oleh cs')
            ->orWhere('status_keluhan', 'dialihkan ke cs')
            ->count();
        $keluhanSelesai = DB::table('data_keluhan')
            ->where('status_keluhan', 'selesai')
            ->count();
        date_default_timezone_set('Asia/Makassar');

        // Mendapatkan waktu sekarang
        $today = date("Y-m-d");

        // Mengambil data keluhan yang tercatat pada hari ini
        $keluhanHariIni = DB::table('data_keluhan')
            ->where('status_keluhan', 'menunggu verifikasi')
            ->whereDate('tgl_keluhan', $today)
            ->get();

        return view('dashboard', compact('totalKeluhan', 'keluhanBaru', 'keluhanDiproses', 'keluhanSelesai', 'keluhanHariIni'));
    }
    public function notifikasi() {
        // Mendapatkan waktu sekarang
        $today = date('d/m/y');
        // Mengambil data keluhan yang tercatat pada hari ini
        $notifikasiKeluhan = DB::table('data_keluhan')
            ->where('status_keluhan','menunggu verifikasi')
            ->whereDate('tgl_keluhan', $today)
            ->get();

        return view('partials/navbar', compact('notifikasiKeluhan'));
    }
    public function dataPenggunaJasa()
    {
        $data_penggunajasa = DB::table('users')
            ->where('hak_akses', 'pengguna_jasa')
            ->paginate(10);

        return view('data_penggunajasa', compact('data_penggunajasa'));
    }
    public function detailPenggunaJasa($id)
    {
        $pengguna_jasa = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.*')
            ->where('users.id', $id)
            ->get();
        $penggunajasa = DB::table('data_keluhan')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'users.nama')
            ->where('users.id', $id)
            ->first();
            
        return view('detail_penggunajasa', compact('pengguna_jasa', 'penggunajasa'));
    }
    public function dataCS()
    {
        $data_cs = DB::table('users')
            ->where('hak_akses', 'customer_service')
            ->get();

        return view('data_cs', compact('data_cs'));
    }
    public function showInputForm()
    {
        return view('input_keluhan');
    }
    public function formInputDataCS()
    {
        return view('input_datacs');
    }
    public function inputDataCS(Request $request)
    {
        // Simpan data pelanggan ke dalam database
        $lastCS = DB::table('users')
            ->where('id', 'like', "CS%")
            ->orderBy('id', 'desc')
            ->value('id');

        if ($lastCS) {
            // Jika sudah ada kode keluhan pada bulan dan tahun yang sama, ambil nomor urut terakhir
            $lastNumberCS = (int) substr($lastCS, -1);
            $newNumberCS = str_pad($lastNumberCS + 1, 1, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada kode keluhan pada bulan dan tahun yang sama, nomor urut dimulai dari 1
            $newNumberCS = '01';
        }
        $newKodeCS = "CS-$newNumberCS";
        // return $newKodeKeluhan;


        $dataPelanggan = [
            // 'id' => $newKodeCS,
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'no_telepon' => $request->input('no_telepon'),
            'jenis_pengguna' => 'Customer Service',
            'hak_akses' => 'customer_service',
            'foto_profil' => 'default.jpg',
        ];

        DB::table('users')->insert($dataPelanggan);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect('cs');
    }
    public function detailKeluhan($id)
    {
        $keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            // ->join('users', 'data_keluhan.penanggungjawab', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.*')
            ->where('data_keluhan.id_keluhan', $id)
            ->first();
        $namaCS = DB::table('data_keluhan')
            ->join('users', 'data_keluhan.penanggungjawab', '=', 'users.id')
            ->select('data_keluhan.*', 'users.nama')
            ->where('data_keluhan.id_keluhan', $id)
            ->first();
        $cs = DB::table('users')
            ->where('hak_akses', 'customer_service')
            ->get();

        return view('detail_keluhan', compact('keluhan', 'cs','namaCS'));
    }
    public function verifikasiKeluhan(Request $request)
    {
        // Dapatkan data keluhan berdasarkan id_keluhan
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $request->id_keluhan)->first();

        if (!$keluhan) {
            return redirect()->back()->with('error', 'Keluhan tidak ditemukan.');
        }

        // Update data keluhan dengan data verifikasi
        DB::table('data_keluhan')
            ->where('id_keluhan', $request->id_keluhan)
            ->update([
                'status_keluhan' => 'dialihkan ke cs',
                'penanggungjawab' => $request->penanggungjawab,
            ]);

        return redirect()->back()->with('success', 'Keluhan berhasil diverifikasi.');
    }
    public function terimaKeluhan($id)
    {
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();
        if ($keluhan) {
            DB::table('data_keluhan')
                ->where('id_keluhan', $id)
                ->update([
                    'status_keluhan' => 'ditangani oleh cs',
                    // 'penanggungjawab' => 'CS 1',
                ]);
            return redirect()->back()->with('success', 'Keluhan sedang ditangan CS.');
        } else {
            return redirect()->back()->with('error', 'Keluhan tidak ditemukan.');
        }
    }
    public function keluhanSelesai(Request $request)
    {
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $request->id_keluhan)->first();

        if (!$keluhan) {
            return redirect()->back()->with('error', 'Keluhan tidak ditemukan.');
        }
        date_default_timezone_set("Asia/Makassar");
        DB::table('data_keluhan')
            ->where('id_keluhan', $request->id_keluhan)
            ->update([
                'status_keluhan' => 'selesai',
                'waktu_penyelesaian' => date("Y-m-d H:i:s"),
                'aksi' => $request->aksi,
            ]);
        return redirect()->back()->with('success', 'Keluhan Terselesaikan!!!');
    }

    function formImportData()
    {
        return view('import');
    }

    public function importKeluhan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);
        
        // try {
            Excel::import(new ImportKeluhan, $request->file('file')->store('files'));
            return redirect()->back()->with('success', 'Data keluhan berhasil diimport.');
        // } catch (\Exception $e) {
        //     $errorMessage = 'Terjadi kesalahan saat mengimport data keluhan. Pastikan format file Excel sesuai.';
        //     return redirect()->back()->with('error', $errorMessage);
        // }
    }

    public function exportKeluhan(Request $request)
    {
        return Excel::download(new ExportKeluhan(), 'laporan_keluhan.xlsx');
        return redirect()->back()->with('success', 'Data keluhan berhasil diexport.');
    }
    public function exportToPDF()
    {
        // Query untuk mendapatkan data keluhan dari tiga tabel yang di-join
        $dataKeluhan = DB::table('data_keluhan')
        ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
        ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
        ->select('data_keluhan.*', 'users.nama', 'data_kategori.kategori_keluhan')
        ->get();

        $pdf = PDF::loadView('export_pdf', ['dataKeluhan' => $dataKeluhan]);

        return $pdf->download('data_keluhan.pdf');
    }
}
