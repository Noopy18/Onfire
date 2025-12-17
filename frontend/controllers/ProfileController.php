<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Utilizador;
use common\models\User;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                        'delete' => ['POST'],
                    ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $this->layout = 'main';

        /** @var User $user */
        $user = Yii::$app->user->identity;

        $utilizador = Utilizador::findOne([
            'fk_user' => $user->id
        ]);

        if (!$utilizador) {
            throw new NotFoundHttpException();
        }

        if (Yii::$app->request->isPost) {

            // 🔹 Atualizar username (tabela user)
            $user->username = Yii::$app->request->post('username');

            // 🔹 Upload da foto (tabela utilizador)
            $file = UploadedFile::getInstanceByName('profile_picture');

            if ($file) {
                $fileName = 'profile_' . $utilizador->utilizador_id . '.' . $file->extension;
                $path = Yii::getAlias('@webroot/uploads/profile/' . $fileName);

                if ($file->saveAs($path)) {
                    $utilizador->profile_picture = 'uploads/profile/' . $fileName;
                }
            }

            $user->save(false);
            $utilizador->save(false);

            Yii::$app->session->setFlash('success', 'Perfil atualizado!');
            return $this->refresh();
        }

        return $this->render('index', [
            'user' => $user,
            'utilizador' => $utilizador
        ]);
    }
}
