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
                
                $product = Product::updateOrCreate([
                    'barcode' => $row[3],
                ],[                
                    'yahoo_id' => $row[0],
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
            
            } catch (Exception $e) {
                $this->ignore[] = $key + 1; //行數
            }
        }        
    }
}
