<?php

namespace App\Service;

use App\Service\YahooService;
use App\Service\MomoService;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock_detail;
use DB;

class UpdateOrdersStock {
    private $platform;

    public function __construct(YahooService $yahoo, MomoService $momo) {
        $this->platform = [
            $yahoo,
            $momo,
        ];
    }

    public function index($st, $et) {
        foreach ($this->platform as $key => $platform) {
            $this->getOrders($platform, $st, $et);
        }
        $this->updateStock();
    }

    public function getOrders($platform, $st, $et) {
        $orders = (count($platform->getOrders($st, $et)) > 0) ? $orders = $platform->getOrders($st, $et) : $orders = [];
        try{
            DB::beginTransaction();

            $createData = $platform->orderFormat($orders);
            foreach ($createData as $key => $value) {
                $data = Order::firstOrCreate(['no' => $value['no'], 'source' => $value['source']], $value);
                if($data->wasRecentlyCreated) {
                    $data->stockDetail()->createMany($value['stock_detail'] ?? []);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dump($e);
        }
    }

    public function updateStock() {
        $productModels = Product::all();
        foreach ($this->platform as $key => $platform) {
            $platform->updateStock($productModels);
        }
    }
}
