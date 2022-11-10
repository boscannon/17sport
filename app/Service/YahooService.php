<?php

namespace App\Service;

use App\Library\Curl;
use App\Library\AES_OpenSSL;
use App\Library\HMacSha512;
use App\Models\Product;

class YahooService {
    protected $shareSecretKey = "6GIa8qR8JBiOYWxjzUxc/uch17qr+kiyTnTh7LZWcMU=";
    protected $shareSecretIV = "O/DCgc3t2g49SSVYvIsheg==";
    protected $saltKey = "bkPk9jksRr0EJc09ES1NRJtxVklOsziE";
    protected $token = "Supplier_27566";
    protected $keyVersion = 1;
    protected $supplierId = 27566;
    protected $apiUrl = "https://tw.scm.yahooapis.com/scmapi/api/";
    private $curl;
    private $aes;
    private $sha;

    public function __construct(Curl $curl, AES_OpenSSL $aes, HMacSha512 $sha) {
        $this->curl = $curl;
        $this->aes = $aes;
        $this->sha = $sha;
        $this->aes->getConfig($this->shareSecretKey, $this->shareSecretIV);
        $this->sha->getConfig($this->shareSecretKey);
        $this->timestamps = time();
    }

    public function getOrders() {
        $transferDateStart = date('Y-m-d\TH:i:s', strtotime('-10 min'));
        $transferDateEnd = date('Y-m-d\TH:i:s');
        $requestData = json_encode([
            // 'TransferDateStart' => date('Y-m-d\TH:i:s', strtotime('-10 min')),
            // 'TransferDateEnd' => date('Y-m-d\TH:i:s'),
            'TransferDateStart' => '2022-10-25T00:00:00',
            'TransferDateEnd' => '2022-10-30T00:00:00',
        ]);
        $url = $this->apiUrl.'HomeDelivery/GetShippingOrders';
        $response = json_decode($this->sendRequest($requestData, $url), true);
        return $response['Orders'];
    }

    public function updateStock($productModels) {
        $url = $this->apiUrl.'GdStock/UpdateQty';
        foreach ($productModels as $key => $productModel) {
        $requestData = json_encode([
            'ProductId' => $productModel->yahoo_id,
            'Qty' => $productModel->stock,
        ]);

        $response = $this->sendRequest($requestData, $url);
        }
    }

    public function orderFormat($order) {
        $data = [];
        foreach ($order as $key => $value) {
            $stock_detail = [];
            foreach ($value['Products'] as $k => $product) {
                if($productModelDetail = $this->updateProduct($product, ['yahoo_id' => $product['Id']])
                ) {
                    $stock_detail[] = $productModelDetail;
                }
            }
            $data[] = [
                'no' => $value['OrderInfo']['OrderCode'],
                'source' => 'yahoo',
                'date' => $value['OrderInfo']['TransferDate'],
                'json' => $value,
                'stock_detail' => $stock_detail
            ];
        }
        return $data;
    }

    public function updateProduct($parameters, $where, $replace = false) {
        $productModel = Product::where($where)->first();
        if(!$productModel) return false;
        $stock = $replace ? $parameters['Qty'] : $productModel->stock - $parameters['Qty'];
        $productModel->update(['stock' => $stock]);
        return [
            'product_id' => $productModel->id,
            'source' => 'yahoo',
            'name' => $parameters['Name'],
            'type' => $parameters['Attribute'],
            'amount' => $parameters['Qty'],
            'stock' => $productModel->stock,
        ];
    }

    public function encrypt($requestData) {
        $this->_msg('明文: '.$requestData);
        $this->aes->getConfig($this->shareSecretKey, $this->shareSecretIV);
        $cipherText = $this->aes->encryptString($requestData);
        $this->_msg('密文: '.$cipherText);
        return $cipherText;
    }

    public function getHeader($signature) {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'api-token: '.$this->token,
            'api-signature: '.$signature,
            'api-timestamp: '.$this->timestamps,
            'api-keyversion: '.$this->keyVersion,
            'api-supplierid: '.$this->supplierId,
        ];
        return $headers;
    }

    public function sendRequest($requestData, $url) {
        $encrypt = $this->encrypt($requestData);
        $signatureString = sprintf("%s%s%s%s", $this->timestamps, $this->token, $this->saltKey, $encrypt);
        $signature = $this->sha->hash($signatureString);
        $this->_msg('簽名字串: '.$signatureString);
        $this->_msg('簽名: '.$signature);

        $header = $this->getHeader($signature);
        $responseEncode = $this->curl->request($url, $header, $encrypt);
        $response = $this->aes->decryptString($responseEncode);
        $this->_msg('API 密文解密: '. $response);
        return $response;
    }

    public function _msg($string) {
        dump($string);
    }
}
