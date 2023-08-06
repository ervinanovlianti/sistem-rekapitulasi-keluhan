<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
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
    public function rekapitulasi()
    {
        $jumlahPembayaran = DB::table('data_keluhan')
            ->where('kategori_id', 1)
            ->where('via_keluhan', 'Visit')
            ->count();
        $jumlahPengiriman = DB::table('data_keluhan')
            ->where('kategori_id', 2)
            ->where('via_keluhan', 'Visit')
            ->count();
        $jumlahPenerimaan = DB::table('data_keluhan')
            ->where('kategori_id', 3)
            ->where('via_keluhan', 'Visit')
            ->count();
        $jumlahAdministrasi = DB::table('data_keluhan')
            ->where('kategori_id', 4)
            ->where('via_keluhan', 'Visit')
            ->count();
        $jumlahLainnya = DB::table('data_keluhan')
            ->where('kategori_id', 5)
            ->where('via_keluhan', 'Visit')
            ->count();

        $jumlahPembayaran1 = DB::table('data_keluhan')
            ->where('kategori_id', 1)
            ->where('via_keluhan', 'Wa/HP')
            ->count();
        $jumlahPengiriman1 = DB::table('data_keluhan')
            ->where('kategori_id', 2)
            ->where('via_keluhan', 'Wa/HP')
            ->count();
        $jumlahPenerimaan1 = DB::table('data_keluhan')
            ->where('kategori_id', 3)
            ->where('via_keluhan', 'Wa/HP')
            ->count();
        $jumlahAdministrasi1 = DB::table('data_keluhan')
            ->where('kategori_id', 4)
            ->where('via_keluhan', 'Wa/HP')
            ->count();
        $jumlahLainnya1 = DB::table('data_keluhan')
            ->where('kategori_id', 5)
            ->where('via_keluhan', 'Wa/HP')
            ->count();

        $jumlahPembayaran2 = DB::table('data_keluhan')
            ->where('kategori_id', 1)
            ->where('via_keluhan', 'Web')
            ->count();
        $jumlahPengiriman2 = DB::table('data_keluhan')
            ->where('kategori_id', 2)
            ->where('via_keluhan', 'Web')
            ->count();
        $jumlahPenerimaan2 = DB::table('data_keluhan')
            ->where('kategori_id', 3)
            ->where('via_keluhan', 'Web')
            ->count();
        $jumlahAdministrasi2 = DB::table('data_keluhan')
            ->where('kategori_id', 4)
            ->where('via_keluhan', 'Web')
            ->count();
        $jumlahLainnya2 = DB::table('data_keluhan')
            ->where('kategori_id', 5)
            ->where('via_keluhan', 'Web')
            ->count();

        $jumlahPembayaran3 = DB::table('data_keluhan')
            ->where('kategori_id', 1)
            ->where('via_keluhan', 'Walkie Talkie')
            ->count();
        $jumlahPengiriman3 = DB::table('data_keluhan')
            ->where('kategori_id', 2)
            ->where('via_keluhan', 'Walkie Talkie')
            ->count();
        $jumlahPenerimaan3 = DB::table('data_keluhan')
            ->where('kategori_id', 3)
            ->where('via_keluhan', 'Walkie Talkie')
            ->count();
        $jumlahAdministrasi3 = DB::table('data_keluhan')
            ->where('kategori_id', 4)
            ->where('via_keluhan', 'Walkie Talkie')
            ->count();
        $jumlahLainnya3 = DB::table('data_keluhan')
            ->where('kategori_id', 5)
            ->where('via_keluhan', 'Walkie Talkie')
            ->count();

        $kategoriId = 1;
        $kategoriId2 = 2;
        $kategoriId3 = 3;
        $kategoriId4 = 4;
        $kategoriId5 = 5;
        $statusKeluhan = ['menunggu verifikasi', 'dialihkan ke cs', 'ditangani oleh cs'];

        $statusKeluhanPembayaran1 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId)
            ->whereIn('status_keluhan', $statusKeluhan)
            ->count();

        $statusKeluhanPembayaran2 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId)
            ->where('status_keluhan', 'selesai')
            ->count();

        $statusKeluhanPembayaran3 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId)
            ->where(function ($query) {
                $query->where('status_keluhan', 'ditolak')
                    ->orWhere('status_keluhan', 'tidak selesai');
            })->count();

        $statusKeluhanPengiriman1 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId2)
            ->whereIn('status_keluhan', $statusKeluhan)
            ->count();

        $statusKeluhanPengiriman2 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId2)
            ->where('status_keluhan', 'selesai')
            ->count();

        $statusKeluhanPengiriman3 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId2)
            ->where(function ($query) {
                $query->where('status_keluhan', 'ditolak')
                    ->orWhere('status_keluhan', 'tidak selesai');
            })->count();
        $statusKeluhanPenerimaan1 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId3)
            ->whereIn('status_keluhan', $statusKeluhan)
            ->count();

        $statusKeluhanPenerimaan2 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId3)
            ->where('status_keluhan', 'selesai')
            ->count();

        $statusKeluhanPenerimaan3 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId3)
            ->where(function ($query) {
                $query->where('status_keluhan', 'ditolak')
                    ->orWhere('status_keluhan', 'tidak selesai');
            })->count();

        $statusKeluhanAdministrasi1 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId4)
            ->whereIn('status_keluhan', $statusKeluhan)
            ->count();

        $statusKeluhanAdministrasi2 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId4)
            ->where('status_keluhan', 'selesai')
            ->count();

        $statusKeluhanAdministrasi3 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId4)
            ->where(function ($query) {
                $query->where('status_keluhan', 'ditolak')
                    ->orWhere('status_keluhan', 'tidak selesai');
            })->count();

        $statusKeluhanLainnya1 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId5)
            ->whereIn('status_keluhan', $statusKeluhan)
            ->count();

        $statusKeluhanLainnya2 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId5)
            ->where('status_keluhan', 'selesai')
            ->count();

        $statusKeluhanLainnya3 = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId5)
            ->where(function ($query) {
                $query->where('status_keluhan', 'ditolak')
                    ->orWhere('status_keluhan', 'tidak selesai');
            })->count();

        $totalKeluhanPembayaran = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId)
            ->count();
        $totalKeluhanPengiriman = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId2)
            ->count();
        $totalKeluhanPenerimaan = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId3)
            ->count();
        $totalKeluhanAdministrasi = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId4)
            ->count();
        $totalKeluhanLainnya = DB::table('data_keluhan')
            ->where('kategori_id', $kategoriId5)
            ->count();

        // $rekapPembayaranVisit = $this->rekapKeluhanByCategoryAndVia('Pembayaran', 'Visit');
        // $rekapPembayaranWaHp = $this->rekapKeluhanByCategoryAndVia('Pembayaran', 'WA/HP');
        // $rekapPembayaranWeb = $this->rekapKeluhanByCategoryAndVia('Pembayaran', 'Web');
        // $rekapPembayaranTW = $this->rekapKeluhanByCategoryAndVia('Pembayaran', 'Walkie Talkie');

        // $rekapPengirimanVisit = $this->rekapKeluhanByCategoryAndVia('Pengiriman', 'Visit');
        // $rekapPengirimanWaHp = $this->rekapKeluhanByCategoryAndVia('Pengiriman', 'WA/HP');

        // $rekapPenerimaanVisit = $this->rekapKeluhanByCategoryAndVia('Penerimaan', 'Visit');
        // $rekapPenerimaanWaHp = $this->rekapKeluhanByCategoryAndVia('Penerimaan', 'WA/HP');

        // $rekapAdministrasiVisit = $this->rekapKeluhanByCategoryAndVia('Administrasi', 'Visit');
        // $rekapAdministrasiWaHp = $this->rekapKeluhanByCategoryAndVia('Administrasi', 'WA/HP');

        // $rekapLainnyaVisit = $this->rekapKeluhanByCategoryAndVia('Lainnya', 'Visit');
        // $rekapLainnyaWaHp = $this->rekapKeluhanByCategoryAndVia('Lainnya', 'WA/HP');

        return view('rekapitulasi', compact(
            // 'rekapPembayaranVisit',
            // 'rekapPembayaranWaHp',
            // 'rekapPembayaranWeb',
            // 'rekapPembayaranTW',
            // 'rekapPengirimanVisit',
            // 'rekapPengirimanWaHp',
            // 'rekapPenerimaanVisit',
            // 'rekapPenerimaanWaHp',
            // 'rekapAdministrasiVisit',
            // 'rekapAdministrasiWaHp',
            // 'rekapLainnyaVisit',
            // 'rekapLainnyaWaHp',
            'totalKeluhanPembayaran',
            'totalKeluhanPengiriman',
            'totalKeluhanPenerimaan',
            'totalKeluhanAdministrasi',
            'totalKeluhanLainnya',

            'statusKeluhanPembayaran1',
            'statusKeluhanPembayaran2',
            'statusKeluhanPembayaran3',

            'statusKeluhanPengiriman1',
            'statusKeluhanPengiriman2',
            'statusKeluhanPengiriman3',

            'statusKeluhanPenerimaan1',
            'statusKeluhanPenerimaan2',
            'statusKeluhanPenerimaan3',

            'statusKeluhanAdministrasi1',
            'statusKeluhanAdministrasi2',
            'statusKeluhanAdministrasi3',

            'statusKeluhanLainnya1',
            'statusKeluhanLainnya2',
            'statusKeluhanLainnya3',

            'jumlahPembayaran',
            'jumlahPengiriman',
            'jumlahPenerimaan',
            'jumlahAdministrasi',
            'jumlahLainnya',
            'jumlahPembayaran1',
            'jumlahPembayaran2',
            'jumlahPembayaran3',
            'jumlahPengiriman1',
            'jumlahPengiriman2',
            'jumlahPengiriman3',
            'jumlahPenerimaan1',
            'jumlahPenerimaan2',
            'jumlahPenerimaan3',
            'jumlahAdministrasi1',
            'jumlahAdministrasi2',
            'jumlahAdministrasi3',
            'jumlahLainnya1',
            'jumlahLainnya2',
            'jumlahLainnya3',

        ));
    }
    private function rekapKeluhanByCategoryAndVia($kategori, $via)
    {
        return DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->select('data_kategori.kategori_keluhan', 'data_keluhan.via_keluhan', DB::raw('COUNT(*) as jumlah_keluhan'))
            ->where('data_keluhan.via_keluhan', $via)
            ->where('data_kategori.kategori_keluhan', $kategori)
            ->groupBy('data_kategori.kategori_keluhan', 'data_keluhan.via_keluhan')
            ->get();
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

    function dashboard()
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
    function notifikasi() {
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
    function detailPenggunaJasa($id)
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
            ->where('id_pengguna', 'like', "CS%")
            ->orderBy('id_pengguna', 'desc')
            ->value('id_pengguna');

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
            'id_pengguna' => $newKodeCS,
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
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
            'file' => 'required|mimes:xls,xlsx'
        ]);
        
        try {
            Excel::import(new ImportKeluhan, $request->file('file')->store('files'));
            return redirect()->back()->with('success', 'Data keluhan berhasil diimport.');
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat mengimport data keluhan. Pastikan format file Excel sesuai.';
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function exportKeluhan(Request $request)
    {
        // $search = $request->get('cari');
        // $filename = 'laporan_keluhan.xlsx'; // Nama file default jika tidak ada kata kunci pencarian

        // if ($search) {
        //     // Jika terdapat kata kunci pencarian, maka kostumisasi nama file dengan kata kunci pencarian
        //     $filename = 'laporan_keluhan_' . $search . '.xlsx';
        // }

        // return Excel::download(new ExportKeluhan($search), $filename);

        return Excel::download(new ExportKeluhan(), 'laporan_keluhan.xlsx');
        return redirect()->back()->with('success', 'Data keluhan berhasil diexport.');
        // if ($request->input('export')) {
        //     return Excel::download(new ExportKeluhan($request), 'laporan_keluhan.xlsx');
        // }

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
        // $dataKeluhan = KeluhanModel::all();

        // $pdf = PDF::loadView('export_pdf', ['dataKeluhan' => $dataKeluhan]);

        // return $pdf->download('data_keluhan.pdf');
    }
}
