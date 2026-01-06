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
        // substitui o dataprovider pelo da função prepareDataProvider
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }
    
    // adms e tech podem ver todos os habitos, os users so os seus
    public function prepareDataProvider()
    {
        $authManager = \Yii::$app->authManager;
        
        if($authManager->checkAccess($this->user->id, 'administrator') || $authManager->checkAccess($this->user->id, 'technician')) {
            $query = $this->modelClass::find();
        } else {
            $query = $this->modelClass::find()->where(['fk_utilizador' => $this->user->utilizador->utilizador_id]);
        }
        
        $searchModel = new \yii\data\ActiveDataProvider([
            'query' => $query
        ]);
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
                        throw new \yii\web\ForbiddenHttpException('Não pode aceder a este hábito');
                    }
                }
            }
        }
    }

    public $modelClass = 'frontend\models\Habit';
    
    // Habito so pode ser criado para si proprio
    public function beforeAction($action)
    {
        if ($action->id === 'create' && \Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            $userUtilizadorId = $this->user->utilizador->utilizador_id;
            
            if (!isset($data['fk_utilizador']) || $data['fk_utilizador'] != $userUtilizadorId) {
                throw new \yii\web\ForbiddenHttpException('Só pode criar hábitos para si próprio');
            }
        }
        return parent::beforeAction($action);
    }

    //check geral para as funções so funcionarem se os habitos pertencem ao utilizador

    function actionCompletions($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->getHabitCompletions()->all();
    }

    function actionSuccessrate($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->getSuccessRate();
    }

    function actionCanbecompleted($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->canBeCompleted();
    }

    function actionIscompleted($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->isCompleted();
    }

    function actionDuedate($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->dueDate();
    }

    function actionIsfinished($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->isFinished();
    }

    function actionGetbeststreak($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->getBestStreak();
    }

    function actionGetstreak($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->getStreak();
    }

    function actionGetstreaks($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        return $habit->getStreaks();
    }

    function actionPutnome($nome) {
        $novonome = \Yii::$app->request->post('nome');
        $habit = $this->modelClass::find()->where(['name' => $nome, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');
        $habit->name = $novonome;
        $habit->save();
        return $habit;
    }

    function actionMakecompletion($id) {
        $habit = $this->modelClass::find()->where(['habit_id' => $id, 'fk_utilizador' => $this->user->utilizador->utilizador_id])->one();
        if (!$habit) throw new \yii\web\NotFoundHttpException('Hábito não encontrado');

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

