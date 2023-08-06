<?php

namespace App\Exports;

use App\Models\Keluhan;
use App\Models\KeluhanModel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class ExportKeluhan implements FromQuery, WithHeadings
{
    public function query()
    {
        return DB::table('data_keluhan')
        ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
        ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
        ->select(
            'data_keluhan.id_keluhan', 
            'data_keluhan.tgl_keluhan', 
            'users.nama',
            'data_keluhan.via_keluhan', 
            'data_keluhan.uraian_keluhan',
            'data_kategori.kategori_keluhan',
            'data_keluhan.status_keluhan',
            'data_keluhan.waktu_penyelesaian',
            'data_keluhan.aksi', 
            )
        ->orderBy('data_keluhan.tgl_keluhan', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID Keluhan',
            'Tanggal Keluhan',
            'Nama Pengguna Jasa',
            'Via Keluhan',
            'Uraian Keluhan',
            'Kategori Keluhan',
            'Status Keluhan',
            'Waktu Penyelesaian',
            'Aksi',
        ];
    }
}

// class ExportKeluhan implements FromCollection
// {
//     /**
//      * @return \Illuminate\Support\Collection
//      */
//     public function collection()
//     {
//         return KeluhanModel::all();
//     }
// }
