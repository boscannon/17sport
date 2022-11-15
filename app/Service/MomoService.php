<?php

namespace App\Service;

use App\Library\Curl;
use App\Models\Product;

class MomoService {
    protected $loginInfo = [
        'entpID' => '81069886',
        'entpCode' => '019858',
        'entpPwd' => 'tmc100201',
        'otpBackNo' => '896',
    ];
    protected $apiUrl = "https://scmapi.momoshop.com.tw/";
    private $curl;

    public function __construct(Curl $curl) {
        $this->curl = $curl;
    }

    public function getOrders($st = '', $et = '') {
        $startTime = ($st == '') ? $startTime = date('Y/m/d') : $startTime = date('Y/m/d', strtotime($st));
        $endTime = ($et == '') ? $endTime = date('Y/m/d') : $endTime = date('Y/m/d', strtotime($et));
        $requestData = json_encode([
            'loginInfo' => $this->loginInfo,
            'fromDate' => $startTime,
            'toDate' => $endTime,
            'delyGbType' => '1',
            'sendRecoverType' => '1'
        ]);
        $url = $this->apiUrl.'api/v2/accounting/order/C1105.scm';
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

    public function updateStock($productModels) {
        $url = $this->apiUrl.'GoodsServlet.do';
        //之後記得改500
        $momoIdsArray = array_chunk(array_diff($productModels->pluck('momo_id')->toArray(), [null]), 2);
        foreach ($momoIdsArray as $momoIds) {
            $request = [
                'doAction' => 'changeGoodsQty',
                'loginInfo' => $this->loginInfo,
                'sendInfoList' => []
            ];
            $stocks = $this->getStock($momoIds);
            foreach ($stocks as $product) {
                $data = $productModels->first(function ($item, $key) use ($product){
                    return $item->momo_id == $product['goods_code'] &&
                            $item->momo_dt_code == $product['goodsdt_code'];
                });
                if(!isset($data)) continue;
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
            $this->_msg($response);
        }
    }

    public function orderFormat($order) {
        $data = [];
        foreach ($order as $value) {
            $stock_detail = [];
            if($productModelDetail = $this->updateProduct($value, ['momo_id' => $value['GOODS_CODE']])) {
                $stock_detail[] = $productModelDetail;
            }
            $data[] = [
                'no' => $value['COMPLETE_ORDER_NO'],
                'source' => 'momo',
                'date' => $value['ORDER_DATE'],
                'due_date' => $value['DELY_HOPE_DATE'],
                'remark' => $value['DESCRIBE_NOTE'],
                'recipient_name' => $value['RECEIVER_MASK'],
                'json' => $value,
                'stock_detail' => $stock_detail
            ];
        }
        return $data;
    }

    public function updateProduct($parameters, $where, $replace = false) {
        $productModel = Product::where($where)->first();
        if(!$productModel) return false;
        $stock = $replace ? $parameters['SYSLAST'] : $productModel->stock - $parameters['SYSLAST'];
        $productModel->update(['stock' => $stock]);
        return [
            'product_id' => $productModel->id,
            'source' => 'momo',
            'name' => $parameters['GOODS_NAME'],
            'type' => $parameters['GOODSDT_INFO'],
            'amount' => $parameters['SYSLAST'],
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
        $response = $this->curl->request($url, $header, $requestData);
        $this->_msg('momo response: '. $response);
        return $response;
    }

    public function _msg($string) {
        dump($string);
    }
}
