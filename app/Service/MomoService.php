<?php

namespace App\Service;

use App\Library\Curl;
use App\Models\Product;
use App\Models\System_setting;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class MomoService {
    protected $loginInfo = [
        'entpID' => '81069886',
        'entpCode' => '019858',
        'entpPwd' => '',
        'otpBackNo' => '896',
    ];
    protected $apiUrl = "https://scmapi.momoshop.com.tw/";
    private $curl;

    public function __construct(Curl $curl) {
        $this->curl = $curl;
    }

    public function getOrders($st = '', $et = '') {
        $this->loginInfo['entpPwd'] = System_setting::where('key', 'momo_password')->first()->value;
        $startTime = ($st == '') ? $startTime = date('Y/m/d') : $startTime = date('Y/m/d', strtotime($st));
        $endTime = ($et == '') ? $endTime = date('Y/m/d') : $endTime = date('Y/m/d', strtotime($et));
        $url = $this->apiUrl.'OrderServlet.do';
        $requestData = json_encode([
            'doAction' => 'unsendThirdQuery',
            'loginInfo' => $this->loginInfo,
            'sendInfo' => [
                'third_fr_dd' => $startTime,
                'third_fr_hh' => '00',
                'third_fr_mm' => '00',
                'third_to_dd' => $endTime,
                'third_to_hh' => '23',
                'third_to_mm' => '59',
                'third_orderGb' => '',
                'third_delyGb' => '62',
                'third_delyTemp' => '01',
                'third_receiver' => '',
                'third_goodsCode' => '',
                'third_orderNo' => '',
                'third_entpGoodsNo' => '',
            ],
        ]);
        $response = json_decode($this->sendRequest($requestData, $url), true);
        return $response;
    }

    public function getStock($momoIds) {
        $url = $this->apiUrl.'api/v1/goodsStockQty/query.scm';
        $request = json_encode([
            'loginInfo' => $this->loginInfo,
            'goodsCodeList' => $momoIds,
        ]);
        return json_decode($this->sendRequest($request, $url), true)['dataList'];
    }

    public function updateStock($all) {
        $this->loginInfo['entpPwd'] = System_setting::where('key', 'momo_password')->first()->value;
        $url = $this->apiUrl.'GoodsServlet.do';
        $productModels = $all ? Product::select('momo_id', 'momo_dt_code', 'stock')->get() : Product::select('momo_id', 'momo_dt_code', 'stock')->where('updated_at', '>=', date('Y-m-d H:i:s', strtotime('-1 day')))->get();
        $momoIdsArray = array_chunk(array_diff(array_unique($productModels->pluck('momo_id')->toArray()), [null, '']), 100);
        foreach ($momoIdsArray as $momoIds) {
            $request = [
                'doAction' => 'changeGoodsQty',
                'loginInfo' => $this->loginInfo,
                'sendInfoList' => []
            ];
            // $this->_msg('momoIds : '.json_encode($momoIds));
            $stocks = $this->getStock($momoIds);
            foreach ($stocks as $product) {
                $data = $productModels->first(function ($item, $key) use ($product){
                    return $item->momo_id == $product['goods_code'] &&
                            $item->momo_dt_code == $product['goodsdt_code'];
                });
                if(!isset($data) || $data->stock == $product['order_counsel_qty']) continue;
                $qty = ($data->stock >= 0) ? $qty = $data->stock - $product['order_counsel_qty'] : 0 - $product['order_counsel_qty'];
                $request['sendInfoList'][] = [
                    'goodsCode' => $product['goods_code'],
                    'goodsName' => $product['goods_name'],
                    'goodsdtCode' => $product['goodsdt_code'],
                    'goodsdtInfo' => $product['goodsdt_info'],
                    'orderCounselQty' => $product['order_counsel_qty'],
                    'addReduceQty' => $qty
                ];
            }
            $response = $this->sendRequest(json_encode($request), $url);
            // $this->_msg($response);
        }
    }

    public function orderFormat($order) {
        $data = [];
        foreach ($order['dataList'] as $value) {
            if(Order::where('no', $value['completeOrderNo'])->first()) continue;
            $stock_detail = [];
            if($productModelDetail = $this->updateProduct($value, ['momo_id' => $value['goodsCode'], 'momo_dt_code' => $value['goodsDtCode']])) {
                $stock_detail[] = $productModelDetail;
            }
            $data[] = [
                'no' => $value['completeOrderNo'],
                'source' => 'momo',
                'date' => $value['lastPricDate'],
                'due_date' => $value['delyHopeDate'],
                'remark' => $value['scm_msg'],
                'recipient_name' => $value['receiverMask'],
                'purchaser_name' => $value['custNameMask'],
                'json' => $value,
                'stock_detail' => $stock_detail
            ];
        }
        return $data;
    }

    public function updateProduct($parameters, $where, $replace = false) {
        $productModel = Product::where($where)->first();
        if(!$productModel) return false;
        $stock = $replace ? $parameters['syslast'] : $productModel->stock - $parameters['syslast'];
        $productModel->update(['stock' => $stock]);
        return [
            'product_id' => $productModel->id,
            'source' => 'momo',
            'name' => $parameters['goodsName'],
            'type' => $parameters['goodsDtInfo'],
            'amount' => $parameters['syslast'],
            'stock' => $productModel->stock,
        ];
    }

    public function getHeader() {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
        ];
        return $headers;
    }

    public function sendRequest($requestData, $url) {
        $header = $this->getHeader();
        $this->_msg('momo request: '. $requestData);
        $response = $this->curl->request($url, $header, $requestData);
        $this->_msg('momo response: '. $response);
        return $response;
    }

    public function _msg($string) {
        Log::info($string);
    }
}
