<?php

namespace indigerd\oauth2\authfilter\identity;

use yii\web\IdentityInterface;

class AuthServerIdentity implements IdentityInterface
{

    protected $id;

    protected $accessToken;

    protected $scopes;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }

    public static function findIdentityByAccessToken($accessToken, $tokenInfo = null)
    {
        if (!empty($tokenInfo['owner_id'])) {
            $identity = new AuthServerIdentity();
            $identity
                ->setId($tokenInfo['owner_id'])
                ->setAccessToken($accessToken)
            ;
            if (!empty($tokenInfo['scopes'])) {
                $identity->setScopes($tokenInfo['scopes']);
            }
            return $identity;
        }
        return null;
    }

    public static function findIdentity($id)
    {
        return null;
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }
}
