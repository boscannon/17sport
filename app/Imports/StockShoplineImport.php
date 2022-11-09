<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StockShoplineImport implements ToCollection
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if($key == 0) continue;

            $product = Product::updateOrCreate([
                'barcode' => $row[5],
            ],[
                'name' => $row[0],
                'attribute' => $row[1],
                'price' => $row[6] ?? 0,
                'stock' => $row[17] == '無限數量' ? 99999 : $row[17], 
            ]);

            $product->stockDetail()->create([
                'source' => 'excel',
                'name' => $product->name,
                'type' => $product->type,
                'size' => $product->size,
                'amount' => $product->stock,
                'stock' => $product->stock,
            ]);
        }
    }
}
