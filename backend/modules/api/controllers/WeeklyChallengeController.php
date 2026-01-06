<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use backend\modules\api\components\CustomAuth;

class WeeklyChallengeController extends ActiveController
{
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
        'class' => CustomAuth::className(),
        'auth' => [$this, 'authCustom']
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    public function authCustom($token)
    {
        $user_ = \common\models\User::findIdentityByAccessToken($token);
        if($user_) {
            $this->user=$user_;
            return $user_;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication');
    }

    // users não podem modificar criar ou eliminar desafios semanaus
    public function checkAccess($action, $model = null, $params = [])
    {
        if($this->user) {
            $authManager = \Yii::$app->authManager;
            
            if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
                return;
            }
            
            if($authManager->checkAccess($this->user->id, 'user')) {
                if ($action === 'create' || $action === 'update' || $action === 'delete') {
                    throw new \yii\web\ForbiddenHttpException('Não pode modificar desafios semanais');
                }
            }
        }
    }

    public $modelClass = 'common\models\WeeklyChallenge';

    // users não podem ver outros users do desafio
    function actionUtilizadores($id) {
        $authManager = \Yii::$app->authManager;
        if(!$authManager->checkAccess($this->user->id, 'administrator') && !$authManager->checkAccess($this->user->id, 'technician')) {
            throw new \yii\web\ForbiddenHttpException('Não pode aceder aos utilizadores do desafio!');
        }
        $weeklyChallenge = $this->modelClass::find()->where(['weekly_challenge_id' => $id])->one();
        if (!$weeklyChallenge) throw new \yii\web\NotFoundHttpException('Desafio semanal não encontrado!');
        return $weeklyChallenge->getWeeklyChallengeUtilizadors()->all();
    }
}

