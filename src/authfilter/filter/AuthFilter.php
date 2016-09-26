<?php

namespace indigerd\oauth2\authfilter\filter;

use Yii;
use indigerd\oauth2\authfilter\Module;
use yii\base\ActionFilter;
use yii\base\Action;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;

class AuthFilter extends ActionFilter
{
    public $scopesCallBack;

    /**
     * @param array $tokenInfo
     * @return indigerd\oauth2\authfilter\identity\AuthServerIdentity
     */
    public function authenticate(array $tokenInfo)
    {
        $user = Yii::$app->getUser();
        $user->identityClass = 'indigerd\oauth2\authfilter\identity\AuthServerIdentity';
        $identity = $user->loginByAccessToken($tokenInfo['access_token'], $tokenInfo);
        return $identity;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        /** @var Action $action*/
        /** @var Module $server */
        $server = \Yii::$app->getModule(
            isset(\Yii::$app->params['authFileterModuleName'])
                ? \Yii::$app->params['authFilterModuleName']
                : 'authfilter'
        );

        $tokenInfo = $server->validateRequest(\Yii::$app->request);
        $this->authenticate($tokenInfo);
        if (!is_callable($this->scopesCallBack)) {
            $this->scopesCallBack = [$this, 'validateScopes'];
        }
        if (call_user_func($this->scopesCallBack, $action, $tokenInfo)) {
            return true;
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * @param Action $action
     * @param array $tokenInfo
     * @return bool
     */
    public function validateScopes(Action $action, array $tokenInfo)
    {
        if (empty($tokenInfo['scopes'])) {
            return false;
        }
        $controllerId = Inflector::pluralize($action->controller->id);
        foreach ($tokenInfo['scopes'] as $scope=>$scopeDetails) {
            if ($scope == $controllerId) {
                return true;
            }
            if ($scope == $controllerId .'.' . $action->id) {
                return true;
            }
        }
        return false;
    }
}