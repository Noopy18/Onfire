<?php

namespace backend\controllers;

use common\models\Badge;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

/**
 * BadgeController implements the CRUD actions for Badge model.
 */
class BadgeController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Badge models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Badge::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'badge_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Badge model.
     * @param int $badge_id Badge ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($badge_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($badge_id),
        ]);
    }

    /**
     * Creates a new Badge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Badge();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $file = UploadedFile::getInstance($model, 'image');

                if ($file) {
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                    if (!in_array(strtolower($file->extension), $allowedTypes)) {
                        Yii::$app->session->setFlash('error', 'Tipo de arquivo não permitido. Use JPG, PNG ou GIF.');
                        return $this->render('create', ['model' => $model]);
                    }

                    if ($file->size > 10 * 1024 * 1024) {
                        Yii::$app->session->setFlash('error', 'Arquivo muito grande. Máximo 5MB.');
                        return $this->render('create', ['model' => $model]);
                    }

                    $fileName = 'badge_' . time() . '.' . $file->extension;
                    $uploadDir = Yii::getAlias('@webroot/uploads/badge/');
                    
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    if ($file->saveAs($uploadDir . $fileName)) {
                        $model->image = 'uploads/badge/' . $fileName;
                    } else {
                        Yii::$app->session->setFlash('error', 'Erro ao fazer upload da imagem.');
                        return $this->render('create', ['model' => $model]);
                    }
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'badge_id' => $model->badge_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Badge model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $badge_id Badge ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($badge_id)
    {
        $model = $this->findModel($badge_id);
        $oldImage = $model->image;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $file = UploadedFile::getInstance($model, 'image');

            if ($file) {
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array(strtolower($file->extension), $allowedTypes)) {
                    Yii::$app->session->setFlash('error', 'Tipo de arquivo não permitido. Use JPG, PNG ou GIF.');
                    return $this->render('update', ['model' => $model]);
                }

                if ($file->size > 10 * 1024 * 1024) {
                    Yii::$app->session->setFlash('error', 'Arquivo muito grande. Máximo 10MB.');
                    return $this->render('update', ['model' => $model]);
                }

                $fileName = 'badge' . '_' . time() . '.' . $file->extension;
                $uploadDir = Yii::getAlias('@webroot/uploads/badge/');
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if ($file->saveAs($uploadDir . $fileName)) {
                    $model->image = 'uploads/badge/' . $fileName;
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao fazer upload da imagem.');
                    return $this->render('update', ['model' => $model]);
                }
            } else {
                $model->image = $oldImage;
            }

            if ($model->save(false)) {
                return $this->redirect(['view', 'badge_id' => $model->badge_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Badge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $badge_id Badge ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($badge_id)
    {
        $this->findModel($badge_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Badge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $badge_id Badge ID
     * @return Badge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($badge_id)
    {
        if (($model = Badge::findOne(['badge_id' => $badge_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
