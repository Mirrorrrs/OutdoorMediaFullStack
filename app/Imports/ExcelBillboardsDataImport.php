<?php

namespace App\Imports;


use App\Models\Billboard;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelBillboardsDataImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        return [];
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
}
