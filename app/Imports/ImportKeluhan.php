<?php

namespace App\Imports;

use App\Models\Example;
use App\Models\KeluhanModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportKeluhan implements ToModel {

    use Importable;

    public function model(array $row)
    {
        return new Example([
            'username' => $row[0],
            "nama"    =>  $row[1],
        ]);
        // return new KeluhanModel([
        //     'id_keluhan' => $row['id_keluhan'],
        //     'tgl_keluhan' => $row['tgl_keluhan'],
        //     'id_pengguna' => $row['id_pengguna'],
        //     'via_keluhan' => $row['via_keluhan'],
        //     'uraian_keluhan' => $row['uraian_keluhan'],
        //     'kategori_id' => $row['kategori_id'],
        //     'penanggungjawab' => $row['penanggungjawab'],
        //     'waktu_penyelesaian' => $row['waktu_penyelesaian'],
        //     'aksi' => $row['aksi'],
        //     'status_keluhan' => $row['status_keluhan'],
        //     // Sesuaikan dengan kolom-kolom pada model KeluhanModel
        // ]);
    }
}

