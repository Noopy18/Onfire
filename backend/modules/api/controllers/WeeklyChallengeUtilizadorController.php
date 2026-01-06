<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class WeeklyChallengeUtilizadorController extends ActiveController
{
    public $modelClass = 'common\models\WeeklyChallengeUtilizador';

    function actionCompletions($id){
        $wcu = new $this->modelClass;
        $wcu = $wcu::find()->where(['weekly_challenge_utilizador_id' => $id])->one();
        $completions = $wcu->getWeeklyChallengeCompletions()->all();
        return $completions;
    }
}

