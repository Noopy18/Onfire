<?php

namespace frontend\controllers;

use frontend\models\Habit;
use frontend\models\HabitCompletion;
use frontend\models\HabitSearch;
use common\models\BadgeUtilizador;
use common\models\Badge;
use yii\filters\AccessControl;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class HabitController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $categories = \common\models\Category::find()->all();
        $model = new Habit();
        $dataProvider = new ActiveDataProvider([
            'query' => Habit::find()
            ->where(['fk_utilizador' => Yii::$app->user->id])
            ->andWhere(['or', ['>=', 'final_date', date('Y-m-d')], ['final_date' => null]]),
        ]);

        $expiredHabitsProvider = new ActiveDataProvider([
            'query' => Habit::find()
            ->where(['fk_utilizador' => Yii::$app->user->id])
            ->andWhere(['<', 'final_date', date('Y-m-d')]),
        ]);

        $selectedCategory = Yii::$app->request->get('selectedCategory');

        if ( !Yii::$app->user->isGuest ) {
            $earnedBadges = Badge::checkBadges(Yii::$app->user->id);
            if ($earnedBadges){
                foreach ($earnedBadges as $badge){
                    $bu = new BadgeUtilizador();
                    $bu->fk_utilizador = Yii::$app->user->id;
                    $bu->fk_badge = $badge->badge_id;
                    $bu->save();
                }
            }
        }
        
        // Handle habit completion
        $habitCompletion = new HabitCompletion();
        if ($habitCompletion->load(Yii::$app->request->post())) {
            
            if ($habitCompletion->save()) {
                return $this->refresh();
            }
            Yii::$app->session->setFlash('error', 'Erro ao completar hábito.');
            return $this->refresh();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'expiredHabitsProvider' => $expiredHabitsProvider,
            'model' => $model
        ]);
    }

    public function actionView($habit_id)
    {

        if ( $habit_id == null ) {
            return $this->redirect(['index']);
        } 
        
        if ( !Yii::$app->user->isGuest ) {
            $currentUserId = Yii::$app->user->id;
            $habit = $this->findModel($habit_id);
            if ( $habit->fk_utilizador != $currentUserId ) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->redirect(['index']);
        }

        // Handle habit completion
        $habitCompletion = new HabitCompletion();
        if ($habitCompletion->load(Yii::$app->request->post())) {

            if ($habitCompletion->save()) {
                return $this->refresh();
            }
            Yii::$app->session->setFlash('error', 'Erro ao completar hábito.');
            return $this->refresh();
        }

        return $this->render('view', [
            'model' => $this->findModel($habit_id),
        ]);
    }

    public function actionCreate()
    {
        $searchModel = new HabitSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

        $user = Yii::$app->user->identity;
        $categories = \common\models\Category::find()->all();
        $model = new Habit();
        $dataProvider = new ActiveDataProvider([
            'query' => Habit::find(),
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->fk_utilizador = Yii::$app->user->id;
            $model->created_at = date('Y-m-d');

            if (!$model->frequency || !str_contains($model->frequency, '1')) {
                Yii::$app->session->setFlash('error', 'Deve selecionar pelo menos um dia da semana para a frequência.');
                return $this->redirect(['index']);
            }

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        $this->layout = "pre-entry";

        return $this->render('create', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'user' => $user,
            'model' => $model
        ]);
    }

    public function actionUpdate($habit_id)
    {
        $categories = \common\models\Category::find()->all();
        $model = $this->findModel($habit_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'habit_id' => $model->habit_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories
        ]);
    }

    public function actionDelete($habit_id)
    {
        $habit = $this->findModel($habit_id);

        foreach ($habit->habitCompletions as $habitCompletion) {
            $habitCompletion->delete();
        }

        $habit->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($habit_id)
    {
        if (($model = Habit::findOne(['habit_id' => $habit_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
