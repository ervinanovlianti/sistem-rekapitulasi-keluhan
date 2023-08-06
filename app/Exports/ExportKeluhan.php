<?php

namespace App\Exports;

use App\Models\Keluhan;
use App\Models\KeluhanModel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportKeluhan implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return KeluhanModel::all();
    }
}
