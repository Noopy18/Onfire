<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class HabitController extends ActiveController
{
    public $modelClass = 'frontend\models\Habit';

    function actionCompletions($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->getHabitCompletions()->all();
    }

    function actionSuccessrate($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->getSuccessRate();
    }

    function actionCanbecompleted($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->canBeCompleted();
    }

    function actionIscompleted($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->isCompleted();
    }

    function actionDuedate($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->dueDate();
    }

    function actionIsfinished($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->isFinished();
    }

    function actionGetbeststreak($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->getBestStreak();
    }

    function actionGetstreak($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->getStreak();
    }

    function actionGetstreaks($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();
        return $habit->getStreaks();
    }
}

