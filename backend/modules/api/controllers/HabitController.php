<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use backend\modules\api\components\CustomAuth;

class HabitController extends ActiveController
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

    function actionPutnome($nome) {
        $novonome = \Yii::$app->request->post('nome');

        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['name' => $nome])->one();

        $habit->name = $novonome;
        $habit->save();

        return $habit;
    }

    function actionMakecompletion($id) {
        $habit = new $this->modelClass;
        $habit = $habit::find()->where(['habit_id' => $id])->one();

        if (!$habit->canBeCompleted()) {
            return ['error' => 'Habit cannot be completed today.'];
        }
        if ($habit->isCompleted()) {
            return ['error' => 'Habit already completed today.'];
        }

        $habitCompletion = new \frontend\models\HabitCompletion();
        $habitCompletion->fk_habit = $habit->habit_id;
        $habitCompletion->date = date('Y-m-d');
        $habitCompletion->completed = 1;
        $habitCompletion->save();

        return $habitCompletion;
    }
}

