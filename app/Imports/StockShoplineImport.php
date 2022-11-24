<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Exception;
use DB;

class StockShoplineImport implements ToCollection
{
    public $ignore = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            try{
                if($key == 0) continue;

                if($row[5] == '') throw new Exception(__('not_barcode'));

                $update = collect([
                    'name' => $row[0],
                    'attribute' => $row[1],
                    'price' => $row[6] ?? 0,
                    'stock' => $row[17] == '無限數量' ? 99999 : $row[17], 
                ]);

                $product = Product::updateOrCreate([
                    'barcode' => $row[5],
                ], $update->filter(function($item){
                    return $item != '';
                })->all());
                
                $product->stockDetail()->create([
                    'source' => 'excel',
                    'name' => $product->name,
                    'type' => $product->type,
                    'size' => $product->size,
                    'amount' => $product->stock,
                    'stock' => $product->stock,
                ]);

            } catch (Exception $e) {
                $this->ignore[] = [
                    'line' => $key + 1, //行數
                    'message' => $e->getMessage()
                ];
            }                
        }
    }
}
