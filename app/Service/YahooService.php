<?php

namespace App\Service;

use App\Library\Curl;
use App\Library\AES_OpenSSL;
use App\Library\HMacSha512;

class YahooService {
    protected $shareSecretKey = "6GIa8qR8JBiOYWxjzUxc/uch17qr+kiyTnTh7LZWcMU=";
    protected $shareSecretIV = "O/DCgc3t2g49SSVYvIsheg==";
    protected $saltKey = "bkPk9jksRr0EJc09ES1NRJtxVklOsziE";
    protected $token = "Supplier_27566";
    protected $keyVersion = 1;
    protected $supplierId = 27566;
    protected $apiUrl = "https://tw.scm.yahooapis.com/scmapi/api/";

    public function __construct() {
        $this->curl = app(Curl::class);
        $this->aes = app(AES_OpenSSL::class);
        $this->aes->getConfig($this->shareSecretKey, $this->shareSecretIV);
        $this->sha = app(HMacSha512::class);
        $this->sha->getConfig($this->shareSecretKey);
        $this->timestamps = time();
    }

    public function getOrders() {
        $transferDateStart = date('Y-m-d\TH:i:s', strtotime('-10 min'));
        $transferDateEnd = date('Y-m-d\TH:i:s');
        $requestData = json_encode([
            'TransferDateStart' => date('Y-m-d\TH:i:s', strtotime('-10 min')),
            'TransferDateEnd' => date('Y-m-d\TH:i:s'),
        ]);
        $url = $this->apiUrl.'HomeDelivery/GetShippingOrders';
        $response = $this->sendRequest($requestData, $url);
    }

    public function updateStock($productId, $qty) {
        $requestData = json_encode([
            'ProductId' => $productId,
            'Qty' => $qty,
        ]);

        $url = $this->apiUrl.'GdStock/UpdateQty';
        $response = $this->sendRequest($requestData, $url);
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
        echo $string.PHP_EOL;
    }
}
