<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StockShoplineImport implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Product::updateOrCreate([
            'barcode' => $row[5],
        ],[
            'name' => $row[0],
            'attribute' => $row[1],
            'stock' => $row[17] == '無限數量' ? 999 : $row[17], 
        ]);
    }
}
