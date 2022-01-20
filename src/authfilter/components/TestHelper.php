<?php

namespace indigerd\oauth2\authfilter\components;

class TestHelper
{
    public static function getTokenInfo()
    {
        $tokenInfo = [
            'owner_id'     => '1',
            'owner_type'   => 'user',
            'access_token' => 'token',
            'client_id'    => '1',
            'scopes'       => ''
        ];
        if (\Yii::$app->getRequest()->getHeaders()->get('X-Token-info') !== null) {
            $tokenInfo = array_merge($tokenInfo, json_decode(\Yii::$app->getRequest()->getHeaders()->get('X-Token-info'), true));
        }
        $response = new \yii\web\Response;
        $response->setStatusCode(200);
        $response->content = json_encode($tokenInfo);
        return $response;
    }

    public static function getToken()
    {
        $tokenInfo = [
            'access_token' => 'token',
            'token_type' => 'Bearer',
            'expires_in' => '3600',
            'refresh_token' => 'token',
            'owner_id' => '1'
        ];
        if (\Yii::$app->getRequest()->getHeaders()->get('X-Token-info') !== null) {
            $tokenInfo = array_merge($tokenInfo, json_decode(\Yii::$app->getRequest()->getHeaders()->get('X-Token'), true));
        }
        $response = new \yii\web\Response;
        $response->setStatusCode(200);
        $response->content = json_encode($tokenInfo);
        return $response;
    }
}
