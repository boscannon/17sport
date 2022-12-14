<?php

namespace App\Service;

use App\Library\Curl;
use App\Library\AES_OpenSSL;
use App\Library\HMacSha512;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

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

    public function getOrders($st = '', $et = '') {
        $startTime = ($st == '') ? $startTime = date('Y-m-d\TH:i:s', strtotime('-12 min')) : $startTime = $st.'T00:00:00';
        $endTime = ($et == '') ? $endTime = date('Y-m-d\TH:i:s') : $endTime = $et.'T23:59:59';
        $requestData = json_encode([
            'TransferDateStart' => $startTime,
            'TransferDateEnd' => $endTime,
        ]);
        $url = $this->apiUrl.'HomeDelivery/GetPreparingOrders';
        $response = json_decode($this->sendRequest($requestData, $url), true);
        return $response['Orders'];
    }

    public function getStock($yahooIds) {
        $url = $this->apiUrl.'GdStock/GetMultipleQuantities';
        $request = json_encode([
            'ProductIds' => $yahooIds
        ]);
        return json_decode($this->sendRequest($request, $url), true)['GdStocks'];
    }

    public function updateStock($all) {
        $url = $this->apiUrl.'GdStock/UpdateMultipleQuantities';
        $productModels = $all ? Product::select('yahoo_id', 'stock')->groupBy('yahoo_id')->get() : Product::select('yahoo_id', 'stock')->where('updated_at', '>=', date('Y-m-d H:i:s', strtotime('-1 day')))->groupBy('yahoo_id')->get();
        $yahooIdsArray = array_chunk(array_diff($productModels->pluck('yahoo_id')->toArray(), [null, '']), 100);
        foreach ($yahooIdsArray as $yahooIds) {
            $request = [];
            $stocks = $this->getStock($yahooIds);
            foreach ($stocks as $product) {
                $data = $productModels->first(function ($item, $key) use ($product){
                    return $item->yahoo_id == $product['ProductId'];
                });
                if(!isset($data) || $data->stock == $product['LeftQty']) continue;
                $qty = ($data->stock >= 0) ? $qty = $data->stock - $product['LeftQty'] : 0 - $product['LeftQty'];
                $request[] = [
                    'ProductId' => $product['ProductId'],
                    'Quantity' => $qty,
                ];
            }
            $response = $this->sendRequest(json_encode($request), $url);
            // $this->_msg($response);
        }
    }

    public function orderFormat($order) {
        $data = [];
        foreach ($order as $value) {
            if(Order::where('no', $value['OrderInfo']['OrderCode'])->first()) continue;
            $stock_detail = [];
            foreach ($value['Products'] as $product) {
                if($productModelDetail = $this->updateProduct($product, ['yahoo_id' => $product['Id']])
                ) {
                    $stock_detail[] = $productModelDetail;
                }
            }
            $data[] = [
                'no' => $value['OrderInfo']['OrderCode'],
                'source' => 'yahoo',
                'date' => $value['OrderInfo']['TransferDate'],
                'due_date' => $value['OrderInfo']['ExpectedShippingDate'],
                'remark' => $value['OrderInfo']['Note'],
                'recipient_name' => $value['ReceiverInfo']['Name'],
                'recipient_phone' => $value['ReceiverInfo']['Phone'],
                'recipient_cellphone' => $value['ReceiverInfo']['Mobile'],
                'purchaser_name' => $value['BuyerInfo']['Name'],
                'purchaser_cellphone' => $value['BuyerInfo']['Mobile'],
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
        // $this->_msg('??????: '.$requestData);
        $this->aes->getConfig($this->shareSecretKey, $this->shareSecretIV);
        $cipherText = $this->aes->encryptString($requestData);
        // $this->_msg('??????: '.$cipherText);
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
        $this->_msg('yahoo request: '. $requestData);
        $encrypt = $this->encrypt($requestData);
        $signatureString = sprintf("%s%s%s%s", $this->timestamps, $this->token, $this->saltKey, $encrypt);
        $signature = $this->sha->hash($signatureString);
        // $this->_msg('????????????: '.$signatureString);
        // $this->_msg('??????: '.$signature);

        $header = $this->getHeader($signature);
        $responseEncode = $this->curl->request($url, $header, $encrypt);
        $response = $this->aes->decryptString($responseEncode);
        $this->_msg('yahoo response: '. $response);
        return $response;
    }

    public function _msg($string) {
        Log::info($string);
    }
}
