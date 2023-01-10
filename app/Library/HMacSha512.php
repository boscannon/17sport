<?php
namespace App\Library;

class HMacSha512 {
    private $_secretKey;
    public function getConfig($secretKey) {
        $this->_secretKey = $secretKey;
    }

    public function hash($data) {
        $hashCode = hash_hmac("sha512", $data, $this->_secretKey);
        return strtoupper($hashCode);
    }
}