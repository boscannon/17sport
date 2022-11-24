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
                    'yahoo_id' => trim($row[0] ?? null),
                    'momo_id' => trim($row[1]),
                    'momo_dt_code' => trim($row[2]),
                    'barcode' => trim($row[3]),
                    'name' => trim($row[4]),
                    'specification' => trim($row[5]),
                    'unit' => trim($row[6]),
                    'type' => trim($row[7]),
                    'size' => trim($row[8]),
                    'price' => intval($row[9]),
                    'stock' => intval($row[10]),
                    'attribute' => trim($row[11]),
                    'remark' => trim($row[12]),
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
