<?php

namespace frontend\controllers;

use Yii;
use common\models\Utilizador;
use common\models\User;
use frontend\models\Friends;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FriendsController implements the CRUD actions for Friends model.
 */
class FriendsController extends Controller
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
     * Lists all Friends models.
     *
     * @return string
     */
    public function actionIndex($friend_id = -1)
    {
        $currentUserId = Yii::$app->user->id;

        $users = new User();
        $utilizadores = new Utilizador();
        $friends = new Friends();

        $dataProvider = new ActiveDataProvider([
            'query' => Friends::find()
            ->where(['sender' => Yii::$app->user->id])
            ->orWhere(['receiver' => Yii::$app->user->id])
        ]);

        $friendModels = [];
        foreach($dataProvider->getModels() as $friendship) {
            if ($friendship->status !== "aceite"){ continue; }
            if ($friendship->sender == $currentUserId){
                $friendModels[] = User::findOne($friendship->receiver);
            } else {
                $friendModels[] = User::findOne($friendship->sender);
            }
        }



        return $this->render('index', [
            'friend_id' => $friend_id,
            'dataProvider' => $dataProvider,
            'users' => $users,
            'friends' => $friends,
            'utilizadores' => $utilizadores,
            'friends' => $friendModels, 
        ]);
    }

    /**
     * Displays a single Friends model.
     * @param int $sender Sender
     * @param int $receiver Receiver
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($sender, $receiver)
    {
        return $this->render('view', [
            'model' => $this->findModel($sender, $receiver),
        ]);
    }

    /**
     * Creates a new Friends model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Friends();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'sender' => $model->sender, 'receiver' => $model->receiver]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Friends model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $sender Sender
     * @param int $receiver Receiver
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($sender, $receiver)
    {
        $model = $this->findModel($sender, $receiver);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'sender' => $model->sender, 'receiver' => $model->receiver]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Friends model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $sender Sender
     * @param int $receiver Receiver
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($sender, $receiver)
    {
        $this->findModel($sender, $receiver)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Friends model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $sender Sender
     * @param int $receiver Receiver
     * @return Friends the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($sender, $receiver)
    {
        if (($model = Friends::findOne(['sender' => $sender, 'receiver' => $receiver])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //este codigo precisa de muitas alterações para funcionar corretamente
    //UPDATE: Este código foi alterado para funcionar corretamente.
    public function actionSearchUsers($q)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        //Recorta o resultado mandado da view index.
        $q = trim($q);
        if ($q === '') {
            return [];
        }

        $currentUser = Yii::$app->user->id;

        //Encontra todos os modelos onde o utilizador atual existe (tem amizade).
        $friendModels = Friends::find()
            ->where(['sender' => $currentUser])
            ->orWhere(['receiver' => $currentUser])
            ->all();

        //Encontra os utilizadores cujos não tem o mesmo ID do utilizador atual nem estão no array 'friendModels'.
        $users = \common\models\User::find()
            ->where(['like', 'username', $q])
            //Filtro da pesquisa do próprio utilizador.
            ->andWhere(['!=', 'id', $currentUser])
            //Filtro de amizade com o utilizador atual.
            ->andWhere(['not in', 'id', array_merge(
                array_map(fn($f) => $f->sender, $friendModels),
                array_map(fn($f) => $f->receiver, $friendModels)
            )])
            ->limit(20)
            ->all();

        $results = [];
        foreach ($users as $user) {
            $results[] = [
                'id' => $user->id,
                'username' => $user->username,
                'avatar' => null,
            ];
        }

        return $results;
    }

    //REVER ESTE CODIGO PARA TENTAR FUNCIONAR O ADICIONAR AMIGOS CORRETAMENTE
    //Revisto e corrigido.
    public function actionFriendshipInvitation($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $senderUtilizador = \common\models\Utilizador::findOne(Yii::$app->user->id);
        $receiverUtilizador = \common\models\Utilizador::findOne($id);

        $friendship = new Friends();
        $friendship->sender = $senderUtilizador->utilizador_id;
        $friendship->receiver = $receiverUtilizador->utilizador_id;
        $friendship->status = Friends::STATUS_PENDENTE;
        if (!$friendship->save()) {
            return $this->redirect(['index']);
        }
        return $this->redirect(['index']);
    }

    public function actionEndFriendship($id)
    {
        $currentUser = Yii::$app->user->id;

        $model = Friends::findFriendship($id, $currentUser)->delete();

        return $this->redirect(['index']);
    }

    public function actionRespondToInvitation($senderId, $action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $receiverId = Yii::$app->user->id;

        $friendship = Friends::findFriendship($$senderId, $receiverId);
        if ($friendship) {
            return $this->redirect(['index']);
        }

        if ($action === 'accepted') {
            $friendship->status = Friends::STATUS_ACEITE;
        } elseif ($action === 'declined') {
            $friendship->status = Friends::STATUS_RECUSADO;
        } else {
            return $this->redirect(['index']);
        }

        if (!$friendship->save()) {
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }
}
