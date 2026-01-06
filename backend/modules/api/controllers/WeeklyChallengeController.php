<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class WeeklyChallengeController extends ActiveController
{
    public $modelClass = 'common\models\WeeklyChallenge';

    function actionUtilizadores($id) {
        $weeklyChallenge = new $this->modelClass;
        $weeklyChallenge = $weeklyChallenge::find()->where(['weekly_challenge_id' => $id])->one();
        return $weeklyChallenge->getWeeklyChallengeUtilizadors()->all();
    }
}

