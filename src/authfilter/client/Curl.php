<?php

namespace indigerd\oauth2\authfilter\client;

class Curl implements ClientInterface
{
    public function sendRequest($method, $url, $params = [], array $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $h = [];
        foreach ($headers as $k=>$v) {
            $h[] = $k . ':' . $v;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $h);

        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch , CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch , CURLOPT_SSL_VERIFYHOST, 0);

        $result = curl_exec($ch);
        $error  = curl_error($ch);

        if ($error != "") {
            throw new \Exception($error);
        }

        $headerSize = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
        $header     = substr($result, 0, $headerSize);
        $body       = substr($result, $headerSize);

        $response = new \yii\web\Response;
        $response->setStatusCode(curl_getinfo($ch,CURLINFO_HTTP_CODE));
        $response->content = $body;
        return $response;
    }
}
