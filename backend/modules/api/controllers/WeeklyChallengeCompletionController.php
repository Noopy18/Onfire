<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use backend\modules\api\components\CustomAuth;

class WeeklyChallengeCompletionController extends ActiveController
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
        // Substitui o default data provider para o da função prepareDataProvider
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    // users podem ver apenas os seus wcc
    public function prepareDataProvider()
    {
        $authManager = \Yii::$app->authManager;
        
        if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()
            ]);
        } else {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()
                    ->joinWith('fkWeeklyChallengeUtilizador')
                    ->where(['weekly_challenge_utilizador.fk_utilizador' => $this->user->utilizador->utilizador_id])
            ]);
        }
        return $searchModel;
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

    // users não podem eliminar editar ou ver completions se não lhes pertencem
    public function checkAccess($action, $model = null, $params = [])
    {
        if($this->user) {
            $authManager = \Yii::$app->authManager;
            
            if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
                return;
            }
            
            if($authManager->checkAccess($this->user->id, 'user')) {
                $userUtilizadorId = $this->user->utilizador->utilizador_id;
                if ($model && ($action === 'update' || $action === 'delete' || $action === 'view')) {
                    if ($model->fkWeeklyChallengeUtilizador->fk_utilizador !== $userUtilizadorId) {
                        throw new \yii\web\ForbiddenHttpException('Não pode aceder a este completion.');
                    }
                }
            }
        }
    }

    public $modelClass = 'common\models\WeeklyChallengeCompletion';
}

