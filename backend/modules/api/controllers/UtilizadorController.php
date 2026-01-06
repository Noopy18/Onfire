<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use backend\modules\api\components\CustomAuth;

class UtilizadorController extends ActiveController
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
    
    // adms e techs veem todos os utilizadores
    public function prepareDataProvider()
    {
        $authManager = \Yii::$app->authManager;
        
        if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()
            ]);
        } else {
            $searchModel = new \yii\data\ActiveDataProvider([
                'query' => $this->modelClass::find()->where(['utilizador_id' => $this->user->utilizador->utilizador_id])
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
        throw new \yii\web\ForbiddenHttpException('No authentication!');
    }

    // os users n podem ver, eliminar ou editar os dados de utilizadores
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
                    if ($model->utilizador_id !== $userUtilizadorId) {
                        throw new \yii\web\ForbiddenHttpException('Não pode aceder a este utilizador!');
                    }
                }
            }
        }
    }
    
    public $modelClass = 'common\models\Utilizador';

    // check geral para caso o user é "user" não poder ver badges e habitos dos outros (ou dar link)

    function actionBadges($id) {
        $authManager = \Yii::$app->authManager;
        if(!$authManager->checkAccess($this->user->id, 'administrator') && !$authManager->checkAccess($this->user->id, 'technician')) {
            if($id != $this->user->utilizador->utilizador_id) {
                throw new \yii\web\ForbiddenHttpException('Não pode aceder a este utilizador!');
            }
        }
        $utilizador = $this->modelClass::find()->where(['utilizador_id' => $id])->one();
        if (!$utilizador) throw new \yii\web\NotFoundHttpException('Utilizador não encontrado!');
        return $utilizador->getBadges()->all();
    }

    function actionHabits($id) {
        $authManager = \Yii::$app->authManager;
        if(!$authManager->checkAccess($this->user->id, 'administrator') && !$authManager->checkAccess($this->user->id, 'technician')) {
            if($id != $this->user->utilizador->utilizador_id) {
                throw new \yii\web\ForbiddenHttpException('Não pode aceder a este utilizador!');
            }
        }
        $utilizador = $this->modelClass::find()->where(['utilizador_id' => $id])->one();
        if (!$utilizador) throw new \yii\web\NotFoundHttpException('Utilizador não encontrado!');
        return $utilizador->getHabits()->all();
    }

    public function actionLinkbadge($id, $badge_id) {
        $authManager = \Yii::$app->authManager;
        if(!$authManager->checkAccess($this->user->id, 'administrator') && !$authManager->checkAccess($this->user->id, 'technician')) {
            if($id != $this->user->utilizador->utilizador_id) {
                throw new \yii\web\ForbiddenHttpException('Não pode aceder a este utilizador!');
            }
        }
        $utilizador = $this->modelClass::find()->where(['utilizador_id' => $id])->one();
        if (!$utilizador) throw new \yii\web\NotFoundHttpException('Utilizador não encontrado!');

        $badge = \common\models\Badge::find()->where(['badge_id' => $badge_id])->one();
        if (!$badge) throw new \yii\web\NotFoundHttpException('Badge não encontrado!');

        $badgeUtilizador = new \common\models\BadgeUtilizador();
        $badgeUtilizador->fk_utilizador = $utilizador->utilizador_id;
        $badgeUtilizador->fk_badge = $badge->badge_id;
        $badgeUtilizador->save();

        return $badgeUtilizador;
    }
}

