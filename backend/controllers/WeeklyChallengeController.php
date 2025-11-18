<?php

namespace backend\controllers;

use common\models\WeeklyChallenge;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeeklyChallengeController implements the CRUD actions for WeeklyChallenge model.
 */
class WeeklyChallengeController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'logout'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['administrator', 'technician'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all WeeklyChallenge models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => WeeklyChallenge::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'weekly_challenge_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeeklyChallenge model.
     * @param int $weekly_challenge_id Weekly Challenge ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($weekly_challenge_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($weekly_challenge_id),
        ]);
    }

    /**
     * Creates a new WeeklyChallenge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WeeklyChallenge();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'weekly_challenge_id' => $model->weekly_challenge_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WeeklyChallenge model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $weekly_challenge_id Weekly Challenge ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($weekly_challenge_id)
    {
        $model = $this->findModel($weekly_challenge_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'weekly_challenge_id' => $model->weekly_challenge_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WeeklyChallenge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $weekly_challenge_id Weekly Challenge ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($weekly_challenge_id)
    {
        $this->findModel($weekly_challenge_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WeeklyChallenge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $weekly_challenge_id Weekly Challenge ID
     * @return WeeklyChallenge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($weekly_challenge_id)
    {
        if (($model = WeeklyChallenge::findOne(['weekly_challenge_id' => $weekly_challenge_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
