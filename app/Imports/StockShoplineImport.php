<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class StockShoplineImport implements ToCollection
{
    public $ignore = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            try{
                DB::beginTransaction();

                if($key == 0) continue;

                if($row[5] == '') throw new Exception(__('not_barcode'));

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

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $this->ignore[] = [
                    'line' => $key + 1, //行數
                    'message' => $e->getMessage()
                ];
            }                
        }
    }
}
