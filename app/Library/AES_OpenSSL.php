<?php
namespace App\Library;

class AES_OpenSSL {
    private $_secretKey;
    private $_iv;
	private $_method ="AES-256-CBC";

    public function getConfig($secretKey, $iv) {
        $this->_secretKey = base64_decode($secretKey);
        $this->_iv = base64_decode($iv);
    }

    public function encryptString($plainText) {

		$enc = openssl_encrypt($plainText,$this->_method,$this->_secretKey,OPENSSL_RAW_DATA ,$this->_iv);
        return base64_encode($enc);
    }

    public function decryptString($encryptedText) {

		$base64DecodedText = base64_decode($encryptedText);
		return openssl_decrypt($base64DecodedText,$this->_method,$this->_secretKey,OPENSSL_RAW_DATA ,$this->_iv);
    }
}