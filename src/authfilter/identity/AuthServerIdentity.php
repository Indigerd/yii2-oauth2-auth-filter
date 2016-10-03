<?php

namespace indigerd\oauth2\authfilter\identity;

use yii\web\IdentityInterface;

class AuthServerIdentity implements IdentityInterface
{

    protected $id;

    protected $accessToken;

    protected $scopes;

    protected $ownerType;

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

    public function getOwnerType()
    {
        return $this->ownerType;
    }

    public function setOwnerType($ownerType)
    {
        $this->ownerType = $ownerType;
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
            if (!empty($tokenInfo['owner_type'])) {
                $identity->setOwnerType($tokenInfo['owner_type']);
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
