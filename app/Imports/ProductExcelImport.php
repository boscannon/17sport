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
        if($rows[0]->all() != [
            0 => "yahoo 商品序號*",
            1 => "momo 商品編號*",
            2 => "momo 單品編號*",
            3 => "國際條碼*",
            4 => "名稱*",
            5 => "規格",
            6 => "單位",
            7 => "型號",
            8 => "選項",
            9 => "售價",
            10 => "庫存",
            11 => "屬性",
            12 => "備註",
        ]){
            throw new Exception(__('data_format_error'));
        }

        foreach ($rows as $key => $row) 
        {
            try{
                if($key == 0) continue;

                if($row[3] == '') throw new Exception(__('not_barcode'));
                
                $update = collect([
                    'barcode' => trim($row[3]),

                    'yahoo_id' => trim($row[0] ?? null),
                    'momo_id' => trim($row[1]),
                    'momo_dt_code' => trim($row[2]),
                    'name' => trim($row[4]),
                    'specification' => trim($row[5]),
                    'unit' => trim($row[6]),
                    'type' => trim($row[7]),
                    'size' => trim($row[8]),
                    'price' => trim($row[9]),
                    'stock' => trim($row[10]),
                    'attribute' => trim($row[11]),
                    'remark' => trim($row[12]),
                ]);

                $product = Product::updateOrCreate([
                    'barcode' => $update->get('barcode'),
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
