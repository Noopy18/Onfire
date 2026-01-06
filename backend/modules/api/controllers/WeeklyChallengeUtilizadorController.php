<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use backend\modules\api\components\CustomAuth;

class WeeklyChallengeUtilizadorController extends ActiveController
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
    
    // users apenas podem ver desafios/users com sigo proprios
    public function prepareDataProvider()
    {
        $authManager = \Yii::$app->authManager;
        
        if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()
            ]);
        } else {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()->where(['fk_utilizador' => $this->user->utilizador->utilizador_id])
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

    // user não pode modificar eliminar ou ver uma participação que n seja sua
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
                    if ($model->fk_utilizador !== $userUtilizadorId) {
                        throw new \yii\web\ForbiddenHttpException('Não pode aceder a esta participação');
                    }
                }
            }
        }
    }

    public $modelClass = 'common\models\WeeklyChallengeUtilizador';
    
    // na criação o user (geral) so pode criar participações para si proprio 
    // (n é necessario check de adm porque n há moderação quanto a esse respeito, muito menos no movel)
    public function beforeAction($action)
    {
        if ($action->id === 'create' && \Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            $userUtilizadorId = $this->user->utilizador->utilizador_id;
            
            if (!isset($data['fk_utilizador']) || $data['fk_utilizador'] != $userUtilizadorId) {
                throw new \yii\web\ForbiddenHttpException('Só pode participar em desafios para si próprio');
            }
        }
        return parent::beforeAction($action);
    }

    // o user ve apenas as suas compleções.
    function actionCompletions($id){
        $authManager = \Yii::$app->authManager;
        if(!$authManager->checkAccess($this->user->id, 'administrator') && !$authManager->checkAccess($this->user->id, 'technician')) {
            $wcu = $this->modelClass::find()->where(['weekly_challenge_utilizador_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        } else {
            $wcu = $this->modelClass::find()->where(['weekly_challenge_utilizador_id' => $id])->one();
        }
        if (!$wcu) throw new \yii\web\NotFoundHttpException('Participação não encontrada');
        return $wcu->getWeeklyChallengeCompletions()->all();
    }
}

