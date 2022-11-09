<?php

namespace App\Service;

use App\Service\YahooService;
// use App\Service\MomoService;
use App\Models\Order;
use App\Models\Stock_detail;
use DB;

class UpdateOrdersStock {
    private $platform;

    public function __construct(YahooService $yahoo) {
        $this->platform = [
            $yahoo
        ];
    }

    public function index() {
        foreach ($this->platform as $key => $platform) {
            $this->getOrders($platform);
        }
        $this->updateStock();
    }

    public function getOrders($platform) {
        $orders = $platform->getOrders();
        try{
            DB::beginTransaction();

            $createData = $platform->orderFormat($orders);
            foreach ($createData as $key => $value) {
                $data = Order::create($value);
                $data->stockDetail()->createMany($value['stock_detail'] ?? []);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function updateStock() {
        $productModels = Product::where('updated_at', '>=', date('Y-m-d H:i:s', '-30 min'))->get();
        foreach ($this->platform as $key => $platform) {
            $platform->updateStock($productModels);
        }
    }
}
