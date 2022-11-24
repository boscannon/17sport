<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Exception;
use Log;

class ProductExcelImport implements ToCollection
{
    public $ignore = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            try{
                if($key == 0) continue;

                if($row[3] == '') throw new Exception(__('not_barcode'));
                
                $update = collect([
                    'yahoo_id' => $row[0] ?? null,
                    'momo_id' => $row[1],
                    'momo_dt_code' => $row[2],
                    'barcode' => $row[3],
                    'name' => $row[4],
                    'specification' => $row[5],
                    'unit' => $row[6],
                    'type' => $row[7],
                    'size' => $row[8],
                    'price' => intval($row[9]),
                    'stock' => intval($row[10]),
                    'attribute' => $row[11],
                    'remark' => $row[12],
                ]);

                $product = Product::updateOrCreate([
                    'barcode' => $row[3],
                ], $update->filter(function($item){
                    return $item != '';
                })->all());
            
            } catch (Exception $e) {
                $this->ignore[] = [
                    'line' => $key + 1, //行數
                    'message' => $e->getMessage()
                ];
            }
        }        
    }
}
