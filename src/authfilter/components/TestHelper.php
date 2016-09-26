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
        return $tokenInfo;
    }
}
