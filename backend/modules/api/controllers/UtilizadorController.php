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

    public function checkAccess($action, $model = null, $params = [])
    {
        return;
        if($this->user) {
            $authManager = \Yii::$app->authManager;
            
            if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
                return;
            }
            
            if($authManager->checkAccess($this->user->id, 'user')) {
                if ($action === "create" || $action === "update" || $action === "delete" || $action === "view" || $action === "index") {
                    throw new \yii\web\ForbiddenHttpException('Proibido');
                }
            }
        }
    }
    
    public $modelClass = 'common\models\Utilizador';

    function actionBadges($id) {
        $utilizador = new $this->modelClass;
        $utilizador = $utilizador::find()->where(['utilizador_id' => $id])->one();
        return $utilizador->getBadges()->all();
    }

    function actionHabits($id) {
        $utilizador = new $this->modelClass;
        $utilizador = $utilizador::find()->where(['utilizador_id' => $id])->one();
        return $utilizador->getHabits()->all();
    }

    public function actionLinkbadge($id, $badge_id) {
        $utilizador = new $this->modelClass;
        $utilizador = $utilizador::find()->where(['utilizador_id' => $id])->one();

        $badge = \common\models\Badge::find()->where(['badge_id' => $badge_id])->one();

        $badgeUtilizador = new \common\models\BadgeUtilizador();
        $badgeUtilizador->fk_utilizador = $utilizador->utilizador_id;
        $badgeUtilizador->fk_badge = $badge->badge_id;
        $badgeUtilizador->save();

        return $badgeUtilizador;
    }
}

