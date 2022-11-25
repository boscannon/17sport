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
        if($rows[0]->all() != [
            0 => "商品名稱",
            1 => "選項",
            2 => "供應商",
            3 => "分類",
            4 => "商品貨號",
            5 => "商品條碼",
            6 => "商品原價",
            7 => "商品特價",
            8 => "實體店價格",
            9 => "會員價",
            10 => "500VIP價",
            11 => "美津濃專賣店會員價",
            12 => "商品成本",
            13 => "預設倉庫",
            14 => "一起大昌",
            15 => "總倉",
            16 => "一起明華",
            17 => "庫存總量",
            18 => "總成本",
        ]){
            throw new Exception(__('data_format_error'));
        }        

        foreach ($rows as $key => $row) 
        {
            try{
                if($key == 0) continue;

                if($row[5] == '') throw new Exception(__('not_barcode'));

                $update = collect([
                    'barcode' => trim($row[5]),

                    'name' => trim($row[0]),
                    'attribute' => trim($row[1]),
                    'price' => trim($row[6]),
                    'stock' => trim($row[17] == '無限數量' ? 99999 : $row[17]) ,
                ]);

                $product = Product::updateOrCreate([
                    'barcode' => $update->get('barcode'),
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
