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
    protected $apiUrl = "https://scmapi.momoshop.com.tw/api/";
    private $curl;

    public function __construct(Curl $curl) {
        $this->curl = $curl;
    }

    public function getOrders() {
        $requestData = json_encode([
            'loginInfo' => $this->loginInfo,
            'fromDate' => date('Y/m/d'),
            'toDate' => date('Y/m/d'),
            'delyGbType' => '1',
            'sendRecoverType' => '1'
        ]);
        $url = $this->apiUrl.'v2/accounting/order/C1105.scm';
        $response = json_decode($this->sendRequest($requestData, $url), true);
        return $response;
    }

    public function updateStock($productModels) {
        $stockQtyUrl = $this->apiUrl.'v1/goodsStockQty/query.scm';
        $updateStockUrl = $this->apiUrl.'GoodsServlet.do';
        $stockQtyRequest = [];
        //chunk先給2方便測試 之後記得改2000
        $products = array_chunk(array_diff($productModels->pluck('momo_id')->toArray(), [null]), 2);
        foreach ($products as $key => $product) {
            $stockQtyRequest[] = json_encode([
                'loginInfo' => $this->loginInfo,
                'goodsCodeList' => $product,
            ]);
        }
        $updateStockRequest = [
            'doAction' => 'changeGoodsQty',
            'loginInfo' => $this->loginInfo,
        ];
        dump($stockQtyRequest);
        foreach ($stockQtyRequest as $key => $request) {
            $response = json_decode($this->sendRequest($request, $stockQtyUrl), true);
            dump($response);
            foreach ($response['dataList'] as $k => $product) {
                $data = Product::where('momo_dt_code', $product['goodsdt_code'])->first();
                $updateStockRequest['sendInfoList'][] = [
                    'goodsCode' => $product['goods_code'],
                    'goodsName' => $product['goods_name'],
                    'goodsdtCode' => $product['goodsdt_code'],
                    'goodsdtInfo' => $product['goodsdt_info'],
                    'orderCounselQty' => $product['order_counsel_qty'],
                    'addReduceQty' => $data->stock - $product['order_counsel_qty']
                ];
            }
        }
        dump($updateStockRequest);
        // $result = $this->sendRequest(json_encode($updateStockRequest), $updateStockUrl);
        // $this->_msg($result);
    }

    public function orderFormat($order) {
        $data = [];
        foreach ($order as $key => $product) {
            $stock_detail = [];
            if($productModelDetail = $this->updateProduct($product, ['momo_id' => $product['GOODS_CODE']])) {
                $stock_detail[] = $productModelDetail;
            }
            $data[] = [
                'no' => $product['COMPLETE_ORDER_NO'],
                'source' => 'momo',
                'date' => $product['ORDER_DATE'],
                'json' => $product,
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
