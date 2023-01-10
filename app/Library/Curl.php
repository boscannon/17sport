<?php
namespace App\Library;

class Curl {
    public function request($apiUrl, $headers, $body) {
        $httpRequest = curl_init();
        curl_setopt($httpRequest, CURLOPT_URL, $apiUrl);
        curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $body);

        curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($httpRequest, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($httpRequest, CURLOPT_POST, true);
        curl_setopt($httpRequest, CURLOPT_HEADER, false); // 需要 trace header 時設定為 true

        $response = curl_exec($httpRequest);

        if($response===false){
            echo "\n".curl_error($httpRequest);
        }

        $reponseHeader = curl_getinfo($httpRequest);


        curl_close($httpRequest);

        if ($reponseHeader['http_code'] == 200) { // 成功
            echo "成功！\n";
            echo "API 回覆密文︰" . $response . "\n";
            return $response;
        } else {
            echo json_encode($reponseHeader);
            echo '失敗！';
        }
    }
}