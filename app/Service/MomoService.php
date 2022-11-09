<?php

namespace App\Service;

use App\Library\Curl;
// use App\Library\AES_OpenSSL;
// use App\Library\HMacSha512;
use App\Models\Product;

class MomoService {
    // protected $shareSecretKey = "6GIa8qR8JBiOYWxjzUxc/uch17qr+kiyTnTh7LZWcMU=";
    // protected $shareSecretIV = "O/DCgc3t2g49SSVYvIsheg==";
    // protected $saltKey = "bkPk9jksRr0EJc09ES1NRJtxVklOsziE";
    // protected $token = "Supplier_27566";
    // protected $keyVersion = 1;
    // protected $supplierId = 27566;
    protected $loginInfo = [
        'entpID' => 'xxx',
        'entpCode' => 'xxx',
        'entpPwd' => 'xxx',
        'otpBackNo' => 'xxx',
    ];
    protected $apiUrl = "https://scmapi.momoshop.com.tw/api/";
    private $curl;
    // private $aes;
    // private $sha;

    public function __construct(Curl $curl) {
        $this->curl = $curl;
        // $this->aes = $aes;
        // $this->sha = $sha;
        // $this->aes->getConfig($this->shareSecretKey, $this->shareSecretIV);
        // $this->sha->getConfig($this->shareSecretKey);
        // $this->timestamps = time();
    }

    public function getOrders() {
        $requestData = json_encode([
            'loginInfo' => $this->loginInfo,
            'fromDate' => date('Y-m-d'),
            'toDate' => date('Y-m-d'),
            'delyGbType' => 1
        ]);
        $url = $this->apiUrl.'v2/accounting/order/C1105.scm';
        $response = json_decode($this->sendRequest($requestData, $url), true);
        return $response['Orders'];
    }

    public function updateStock($productModels) {
        //我們減他們 chunk 陣列切兩千筆 pluck抓品號
        $stockQtyUrl = $this->apiUrl.'v1/goodsStockQty/query.scm';
        $updateStockUrl = $this->apiUrl.'GoodsServlet.do';
        $stockQtyRequest = [];
        $updateStockRequest = [];
        //chunk先給2方便測試 之後記得改2000
        $products = array_chunk(array_diff($productModels->pluck('momo_dt_code')->toArray(), [null]), 2);
        foreach ($products as $key => $product) {
            $stockQtyRequest[] = json_encode([
                'loginInfo' => $this->loginInfo,
                'goodsCodeList' => $product,
            ]);
        }
        foreach ($stockQtyRequest as $key => $request) {
            $response = json_decode($this->sendRequest($request, $stockQtyUrl), true);
            foreach ($response['dataList'] as $k => $product) {
                $updateStockRequest[] = json_encode([
                    'doAction' => 'changeGoodsQty',
                    'loginInfo' => $this->loginInfo,
                    'sendInfoList' => [
                        'goodsCode' => $product['goods_code'],
                        'goodsName' => $product['goods_name'],
                        'goodsdtCode' => $product['goodsdt_code'],
                        'goodsdtInfo' => $product['goodsdt_info'],
                        'orderCounselQty' => $product['order_counsel_qty'],
                        //撈product stock - $product['order_counsel_qty']
                        // 'addReduceQty' => ,
                    ]
                ]);
            }
        }
    }

    public function orderFormat($order) {
        $data = [];
        foreach ($order as $key => $value) {
            $stock_detail = [];
            foreach ($value as $k => $product) {
                if($productModelDetail = $this->updateProduct($product, ['momo_id' => $product['GOODS_CODE']])) {
                    $stock_detail[] = $productModelDetail;
                }
            }
            $data[] = [
                'no' => $value['COMPLETE_ORDER_NO'],
                'source' => 'momo',
                'date' => $value['ORDER_DATE'],
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

    // public function encrypt($requestData) {
    //     $this->_msg('明文: '.$requestData);
    //     $this->aes->getConfig($this->shareSecretKey, $this->shareSecretIV);
    //     $cipherText = $this->aes->encryptString($requestData);
    //     $this->_msg('密文: '.$cipherText);
    //     return $cipherText;
    // }

    // public function getHeader($signature) {
    //     $headers = [
    //         'Accept: application/json',
    //         'Content-Type: application/json',
    //         'api-token: '.$this->token,
    //         'api-signature: '.$signature,
    //         'api-timestamp: '.$this->timestamps,
    //         'api-keyversion: '.$this->keyVersion,
    //         'api-supplierid: '.$this->supplierId,
    //     ];
    //     return $headers;
    // }

    public function sendRequest($requestData, $url) {
        // $encrypt = $this->encrypt($requestData);
        // $signatureString = sprintf("%s%s%s%s", $this->timestamps, $this->token, $this->saltKey, $encrypt);
        // $signature = $this->sha->hash($signatureString);
        // $this->_msg('簽名字串: '.$signatureString);
        // $this->_msg('簽名: '.$signature);

        // $header = $this->getHeader($signature);
        // $responseEncode = $this->curl->request($url, $header, $encrypt);
        // $response = $this->aes->decryptString($responseEncode);
        // $this->_msg('API 密文解密: '. $response);
        // return $response;
    }

    public function _msg($string) {
        dump($string);
    }
}
