<?php

namespace backend\controllers;

use common\models\user;
use common\models\Utilizador;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for user model.
 */
class UserController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all user models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => user::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single user model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new User();
        $model_extra = new Utilizador();


        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->auth_key = Yii::$app->getSecurity()->generateRandomString();
            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
            $model->status = User::STATUS_ACTIVE;
            $model->verification_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
            $model->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
            $model_extra->load($this->request->post());
            if ($model->validate() && $model_extra->validate()) {
                $model->save();
                $model_extra->fk_user = $model->id;
                $model_extra->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
            $model_extra->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'model_extra' => $model_extra,
        ]);
    }

    /**
     * Updates an existing user model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_extra = Utilizador::Find()->where(['fk_user' => $id])->one();

        if ($this->request->isPost && $model->load($this->request->post()) && $model_extra->load($this->request->post()) && $model_extra->save() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_extra' => $model_extra,
        ]);
    }

    /**
     * Deletes an existing user model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //verifica a role que o utilizador está autenticado
        $current_user = Yii::$app->user->identity->id;
        $current_user_role = Yii::$app->authManager->getRolesByUser($current_user);
        
        //role que o utilizador quer eliminar
        $rolesTodelete = Yii::$app->authManager->getRolesByUser($id);

        //if que proibe o tecnico apagar o admin
        if (isset($current_user_role['technician']) && isset($rolesTodelete['administrator'])) {
            throw new NotFoundHttpException('Não podes eliminar um Administrador.');
        }


        $user_extra = Utilizador::findOne(['fk_user' => $id]);
        $user_extra->delete();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);

    }

    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = user::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
