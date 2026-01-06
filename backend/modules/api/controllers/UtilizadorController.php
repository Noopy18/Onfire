<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class UtilizadorController extends ActiveController
{
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
}

