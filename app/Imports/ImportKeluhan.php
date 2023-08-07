<?php

namespace App\Imports;

use App\Models\KeluhanModel;
use Maatwebsite\Excel\Concerns\ToModel;

class Importkeluhan implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $bulanTahun = date('my');
        $lastNumber = KeluhanModel::where('id_keluhan', 'like', "KEL-$bulanTahun%")->max('id_keluhan');
        $lastNumber = ($lastNumber) ? (int) substr($lastNumber, -5) : 0;
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        $idKeluhan = "KEL-$bulanTahun-$newNumber";
        return new KeluhanModel([

            'id_keluhan'        => $idKeluhan,
            'tgl_keluhan'       => $row[1],
            'id_pengguna'       => $row[2],
            'via_keluhan'       => $row[3],
            'uraian_keluhan'    => $row[4],
            'kategori_id'       => $row[5],
            'penanggungjawab'   => $row[6],
            'waktu_penyelesaian'=> $row[7],
            'aksi'              => $row[8],
            'status_keluhan'    => $row[9],
            
        ]);
    }
}
