<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use backend\modules\api\components\CustomAuth;

class FriendsController extends ActiveController
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
    
    // o user pode ver apenas as suas ammizades enquanto que o adm e tech podem ver todas  
    public function prepareDataProvider()
    {
        $authManager = \Yii::$app->authManager;
        
        if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()
            ]);
        } else {
                $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()->where([
                    'or',
                    ['sender' => $this->user->utilizador->utilizador_id],
                    ['receiver' => $this->user->utilizador->utilizador_id]
                ])
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

    // os adms e tech podem manipular qualquer amizade, o user apenas a sua
    public function checkAccess($action, $model = null, $params = [])
    {
        if($this->user) {
            $authManager = \Yii::$app->authManager;
            
            if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
                return;
            }
            
            if($authManager->checkAccess($this->user->id, 'user')) {
                $utilizador_id = $this->user->utilizador->utilizador_id;
                
                if ($model && ($action === 'update' || $action === 'delete' || $action === 'view')) {
                    if ($model->sender !== $utilizador_id && $model->receiver !== $utilizador_id) {
                        throw new \yii\web\ForbiddenHttpException('Não pode aceder a esta amizade.');
                    }
                }
            }
        }
    }

    public $modelClass = 'frontend\models\Friends';
    
    // antes da criação é verificado se o user é o sender da amizade
    public function beforeAction($action)
    {
        if ($action->id === 'create' && \Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            $utilizador_id = $this->user->utilizador->utilizador_id;
            
            if (!isset($data['sender']) || $data['sender'] != $utilizador_id) {
                throw new \yii\web\ForbiddenHttpException('Só pode criar amizades como sender.');
            }
        }
        return parent::beforeAction($action);
    }
}

