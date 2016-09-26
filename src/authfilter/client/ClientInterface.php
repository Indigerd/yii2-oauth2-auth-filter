<?php

namespace indigerd\oauth2\authfilter\client;

interface ClientInterface
{
    /**
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return \yii\web\Response
     */
    public function sendRequest($method, $url, $params = [], array $headers = []);
}
