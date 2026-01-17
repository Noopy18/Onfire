<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use backend\modules\api\components\CustomAuth;

class UserController extends ActiveController
{

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
        'class' => CustomAuth::className(),
        'auth' => [$this, 'authCustom'],
        'except' => ['login']
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
    
    // adms e techs tem acesso aos users mas os users apenas a si proprios
    public function prepareDataProvider()
    {
        $authManager = \Yii::$app->authManager;
        
        if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()
            ]);
        } else {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()->where(['id' => $this->user->id])
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

    // utilizadores n podem modificar eliminar nem ver outros users
    public function checkAccess($action, $model = null, $params = [])
    {
        if($this->user) {
            $authManager = \Yii::$app->authManager;
            
            if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
                return;
            }
            
            if($authManager->checkAccess($this->user->id, 'user')) {
                if ($model && ($action === 'update' || $action === 'delete' || $action === 'view')) {
                    if ($model->id !== $this->user->id) {
                        throw new \yii\web\ForbiddenHttpException('Não pode aceder a este utilizador.');
                    }
                }
            }
        }
    }

    function actionLogin() {
        $request = \Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');
        
        $user = \common\models\User::findByUsername($username);
        
        if ($user && $user->validatePassword($password)) {
            return ['auth_key' => $user->auth_key, 'id' => $user->id];
        }
        
        \Yii::$app->response->statusCode = 401;
        return ['error' => 'Invalid credentials'];
    }

    function actionRole($id) {
        $authManager = \Yii::$app->authManager;
        $roles = $authManager->getRolesByUser($id);
        $roleNames = array_keys($roles);
        return ['role' => $roleNames];
    }

    public $modelClass = 'common\models\User';
}

