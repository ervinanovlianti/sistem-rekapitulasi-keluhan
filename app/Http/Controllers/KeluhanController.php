<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use App\Models\PenggunaJasaModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Imports\ImportKeluhan;


use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index(){
        $data_keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('data_pengguna_jasa', 'data_keluhan.id_pengguna', '=', 'data_pengguna_jasa.id_pengguna')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'data_pengguna_jasa.nama')
            ->orderBy('tgl_keluhan', 'desc')
            ->get();

        return view('data_keluhan', compact('data_keluhan'));
    }
    public function rekapitulasi() {

        // $jumlahPembayaran = DB::table('data_keluhan')
        // ->where('kategori_id', 1)
        // ->where('via_keluhan', 'Visit')
        // ->count();
        // $jumlahPengiriman = DB::table('data_keluhan')
        // ->where('kategori_id', 2)
        // ->where('via_keluhan', 'Visit')
        // ->count();
        // $jumlahPenerimaan = DB::table('data_keluhan')
        // ->where('kategori_id', 3)
        // ->where('via_keluhan', 'Visit')
        // ->count();
        // $jumlahAdministrasi = DB::table('data_keluhan')
        // ->where('kategori_id', 4)
        // ->where('via_keluhan', 'Visit')
        // ->count();
        // $jumlahLainnya = DB::table('data_keluhan')
        // ->where('kategori_id', 5)
        // ->where('via_keluhan', 'Visit')
        // ->count();

        // $jumlahPembayaran1 = DB::table('data_keluhan')
        // ->where('kategori_id', 1)
        // ->where('via_keluhan', 'Wa/HP')
        // ->count();
        // $jumlahPengiriman1 = DB::table('data_keluhan')
        // ->where('kategori_id', 2)
        // ->where('via_keluhan', 'Wa/HP')
        // ->count();
        // $jumlahPenerimaan1 = DB::table('data_keluhan')
        // ->where('kategori_id', 3)
        // ->where('via_keluhan', 'Wa/HP')
        // ->count();
        // $jumlahAdministrasi1 = DB::table('data_keluhan')
        // ->where('kategori_id', 4)
        // ->where('via_keluhan', 'Wa/HP')
        // ->count();
        // $jumlahLainnya1 = DB::table('data_keluhan')
        // ->where('kategori_id', 5)
        // ->where('via_keluhan', 'Wa/HP')
        // ->count();

        $visitKeluhan = 'Visit';
        $visitKeluhan1 = 'Wa/HP';
        $visitKeluhan2 = 'Web';
        $visitKeluhan3 = 'Talkie/Walkie';

        $jumlahKategoriKeluhan = KeluhanModel::where('via_keluhan', $visitKeluhan)
        ->select('kategori_id', DB::raw('COUNT(*) as kategori_id'))
        ->groupBy('kategori_id')
        ->get();
        $jumlahKategoriKeluhan1 = KeluhanModel::where('via_keluhan', $visitKeluhan1)
        ->select('kategori_id', DB::raw('COUNT(*) as kategori_id'))
        ->groupBy('kategori_id')
        ->get();

        // return $jumlahKategoriKeluhan;
        
        return view('rekapitulasi', compact(
            // 'jumlahPembayaran',
            // 'jumlahPengiriman',
            // 'jumlahPenerimaan',
            // 'jumlahAdministrasi',
            // 'jumlahLainnya',
            // 'jumlahPembayaran1',
            // 'jumlahPengiriman1',
            // 'jumlahPenerimaan1',
            // 'jumlahAdministrasi1',
            // 'jumlahLainnya1',
            'jumlahKategoriKeluhan',
            'jumlahKategoriKeluhan1',
        ));
    }
    public function laporan() {
        $keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('data_pengguna_jasa', 'data_keluhan.id_pengguna', '=', 'data_pengguna_jasa.id_pengguna')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'data_pengguna_jasa.nama')
            ->orderBy('tgl_keluhan', 'desc')
            ->get();
        

        return view('laporan', compact('keluhan'));
    }
    function dashboard()  {
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
        $today = date('d/m/y');

        // Mengambil data keluhan yang tercatat pada hari ini
        $keluhanHariIni = DB::table('data_keluhan')
        ->whereDate('tgl_keluhan', $today)
        ->get();

        return view('dashboard', compact('totalKeluhan', 'keluhanBaru', 'keluhanDiproses','keluhanSelesai','keluhanHariIni'));
    }
    public function dataPenggunaJasa()
    {
        $data_penggunajasa = DB::table('data_pengguna_jasa')
        ->where('hak_akses', 'pengguna_jasa')
        ->get();

        return view('data_penggunajasa', compact('data_penggunajasa'));
    }
    public function dataCS() {
        $data_cs = DB::table('data_pengguna_jasa')
        ->where('hak_akses', 'customer_service')
        ->get();

        return view('data_cs', compact('data_cs'));
    }
    public function showInputForm(){
        return view('input_keluhan');
    }
    public function formInputDataCS(){
        return view('input_datacs');
    }
    public function inputDataCS(Request $request)
    {
        // Simpan data pelanggan ke dalam database
        $lastCS = DB::table('data_pengguna_jasa')
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
        ];

        DB::table('data_pengguna_jasa')->insert($dataPelanggan);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect('cs');
    } 
    public function detailKeluhan($id) {
        $keluhan = DB::table('data_keluhan')
        ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
        ->join('data_pengguna_jasa', 'data_keluhan.id_pengguna', '=', 'data_pengguna_jasa.id_pengguna')
        ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'data_pengguna_jasa.nama')
        ->where('data_keluhan.id_keluhan', $id)
        ->first();

        return view('detail_keluhan', compact('keluhan'));
    }
    public function verifikasiKeluhan($id){
        // Cari data keluhan berdasarkan ID
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();

        // Jika data keluhan ditemukan
        if ($keluhan) {
            // Lakukan update status keluhan menjadi "Terverifikasi"
            DB::table('data_keluhan')->where('id_keluhan', $id)->update(['status_keluhan' => 'dialihkan ke cs']);

            // Redirect kembali ke halaman data keluhan dengan pesan sukses
            return redirect('keluhan')->with('success', 'Keluhan telah diverifikasi.');
        } else {
            // Jika data keluhan tidak ditemukan, redirect kembali ke halaman data keluhan dengan pesan error
            return redirect('keluhan')->with('error', 'Keluhan tidak ditemukan.');
        }
    }
    public function terimaKeluhan($id){
        // Cari data keluhan berdasarkan ID
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();

        // Jika data keluhan ditemukan
        if ($keluhan) {
            // Lakukan update status keluhan menjadi "Terverifikasi"
            DB::table('data_keluhan')
            ->where('id_keluhan', $id)
            ->update([
                'status_keluhan' => 'ditangani oleh cs',
                'penanggungjawab' => 'CS 1',
            ]);

            // Redirect kembali ke halaman data keluhan dengan pesan sukses
            return redirect('keluhan')->with('success', 'Keluhan telah ditangan CS.');
        } else {
            // Jika data keluhan tidak ditemukan, redirect kembali ke halaman data keluhan dengan pesan error
            return redirect('keluhan')->with('error', 'Keluhan tidak ditemukan.');
        }
    }
    public function keluhanSelesai($id){
        // Cari data keluhan berdasarkan ID
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();

        // Jika data keluhan ditemukan
        if ($keluhan) {
            // Lakukan update status keluhan menjadi "Terverifikasi"
            DB::table('data_keluhan')
            ->where('id_keluhan', $id)
            ->update([
                'status_keluhan' => 'selesai',
                'waktu_penyelesaian' => Carbon::now(),
            ]);

            // Redirect kembali ke halaman data keluhan dengan pesan sukses
            return redirect('keluhan')->with('success', 'Keluhan telah ditangan CS.');
        } else {
            // Jika data keluhan tidak ditemukan, redirect kembali ke halaman data keluhan dengan pesan error
            return redirect('keluhan')->with('error', 'Keluhan tidak ditemukan.');
        }
    }
    function formImportData() {
        return view('import');
    }

    // public function importData(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xls,xlsx'
    //     ]);

    //     try {
    //         $file = $request->file('file');

    //         Excel::import(new KeluhanImport, $file);

    //         return redirect('keluhan')->with('success', 'Data keluhan berhasil diimport.');
    //     } catch (\Exception $e) {
    //         $errorMessage = 'Terjadi kesalahan saat mengimport data keluhan. Pastikan format file Excel sesuai.';
    //         return redirect()->back()->with('error', $errorMessage);
    //     }
    // }
    public function importData(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new ImportKeluhan, $file);

            return redirect('keluhan')->with('success', 'Data keluhan berhasil diimport.');
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat mengimport data keluhan.';
            return redirect()->back()->with('error', $errorMessage);
        }
    }
    public function importDataUtama(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new ImportKeluhan, $file);

            return redirect('keluhan')->with('success', 'Data keluhan berhasil diimport.');
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat mengimport data keluhan.';
            return redirect()->back()->with('error', $errorMessage);
        }
    }
    public function importData2(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $file = $request->file('file');

            // Mengabaikan row pertama (heading) dari file Excel
            $data = Excel::toArray([], $file);
            $data = array_slice($data[0], 1);

            // Menentukan id_keluhan sesuai dengan format khusus
            $bulanTahun = date('my');
            $lastNumber = KeluhanModel::where('id_keluhan', 'like', "KEL-$bulanTahun%")->max('id_keluhan');
            $lastNumber = ($lastNumber) ? (int) substr($lastNumber, -5) : 0;
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            $idKeluhan = "KEL-$bulanTahun-$newNumber";

            foreach ($data as $row) {
                $keluhan = [
                    'id_keluhan'        => $idKeluhan,
                    'tgl_keluhan'       => $row[0],
                    'id_pengguna'       => $row[1],
                    'via_keluhan'       => $row[2],
                    'uraian_keluhan'    => $row[3],
                    'kategori_id'       => $row[4],
                    'penanggungjawab'   => $row[5],
                    'waktu_penyelesaian' => $row[6],
                    'aksi'              => $row[7],
                    'status_keluhan'    => $row[8],
                    // Sesuaikan dengan kolom-kolom pada model KeluhanModel
                ];

                // Simpan data ke dalam database
                KeluhanModel::create($keluhan);
            }

            return redirect('keluhan')->with('success', 'Data keluhan berhasil diimport.');
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat mengimport data keluhan. Pastikan format file Excel sesuai.';
            return redirect()->back()->with('error', $errorMessage);
        }
    }
    function importData1(Request $request) {

        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        try {
            $data = Excel::toArray([], $file);

            // Mengabaikan row pertama (heading) dari file Excel
            $data = array_slice($data[0], 1);

            // Menentukan id_keluhan sesuai dengan format khusus
            $bulanTahun = date('my');
            $lastNumber = KeluhanModel::where('id_keluhan', 'like', "KEL-$bulanTahun%")->max('id_keluhan');
            $lastNumber = ($lastNumber) ? (int) substr($lastNumber, -5) : 0;
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            $idKeluhan = "KEL-$bulanTahun-$newNumber";

            // $lastNumberPJ = KeluhanModel::where('id_pengguna', 'like', "CUST%")->max('id_pengguna');
            // $lastNumberPJ = ($lastNumberPJ) ? (int) substr($lastNumberPJ, -4) : 0;
            // $newNumberPJ = str_pad($lastNumberPJ + 1, 4, '0', STR_PAD_LEFT);
            // $idPengguna = "CUST-$newNumberPJ";

            foreach ($data as $row) {
                $keluhan = new KeluhanModel([
                    'id_keluhan'        => $row['id_keluhan'],
                    'tgl_keluhan'       => $row['tgl_keluhan'],
                    'id_pengguna'       => $row['id_pengguna'],
                    'via_keluhan'       => $row['via_keluhan'],
                    'uraian_keluhan'    => $row['uraian_keluhan'],
                    'kategori_id'       => $row['kategori_id'],
                    'penanggungjawab'   => $row['penanggungjawab'],
                    'waktu_penyelesaian'=> $row['waktu_penyelesaian'],
                    'aksi'              => $row['aksi'],
                    'status_keluhan'    => $row['status_keluhan'],
                    // Sesuaikan dengan kolom-kolom pada model Keluhan
                ]);
                // $penggunaJasa = [
                //     'id_pengguna'       => 1,
                //     'nama' => $row['nama'],
                //     'no_telepon' => $row['no_telepon'],
                //     'jenis_pengguna' => $row['jenis_pengguna'],
                //     'hak_akses' => 'pengguna_jasa',

                //     // Sesuaikan dengan kolom-kolom pada model PenggunaJasa
                // ];

                // Simpan data ke dalam database
                // DB::table('data_keluhan')->insert($keluhan);
                // DB::table('data_pengguna_jasa')->insert($penggunaJasa);
                $keluhan->save();
            }

            return redirect()->back()->with('success', 'Data keluhan berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimport data keluhan. Pastikan format file Excel sesuai.');
        }
    }
    
}