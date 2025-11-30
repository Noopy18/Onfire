<?php

namespace frontend\controllers;

use frontend\models\Habit;
use frontend\models\HabitSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HabitController implements the CRUD actions for Habit model.
 */
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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Habit models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new HabitSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $user = Yii::$app->user->identity;
        $categories = \common\models\Category::find()->all();
        $model = new Habit();
        
        // Handle habit creation
        if ($model->load(Yii::$app->request->post())) {
            $model->fk_utilizador = Yii::$app->user->id;
            $model->created_at = date('Y-m-d');
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Habit created successfully!');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'user' => $user,
            'model' => $model
        ]);
    }

    /**
     * Displays a single Habit model.
     * @param int $habit_id Habit ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($habit_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($habit_id),
        ]);
    }

    /**
     * Creates a new Habit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Habit();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'habit_id' => $model->habit_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Habit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $habit_id Habit ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($habit_id)
    {
        $model = $this->findModel($habit_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'habit_id' => $model->habit_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Habit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $habit_id Habit ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($habit_id)
    {
        $this->findModel($habit_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Habit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $habit_id Habit ID
     * @return Habit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($habit_id)
    {
        if (($model = Habit::findOne(['habit_id' => $habit_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
