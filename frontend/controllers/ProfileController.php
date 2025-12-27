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

            //  Atualizar username (tabela user)
            $user->username = Yii::$app->request->post('username');

            //  Atualizar perfil privado (tabela utilizador)
            $utilizador->private_profile = Yii::$app->request->post('private_profile');

            //  Upload da foto (tabela utilizador)
            $file = UploadedFile::getInstanceByName('profile_picture');

            if ($file) {
                // Validação do tipo da imagem.
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array(strtolower($file->extension), $allowedTypes)) {
                    Yii::$app->session->setFlash('error', 'Tipo de arquivo não permitido. Use JPG, PNG ou GIF.');
                    return $this->refresh();
                }

                // Validação do tamanho da imagem. (5MB max)
                if ($file->size > 10 * 1024 * 1024) {
                    Yii::$app->session->setFlash('error', 'Arquivo muito grande. Máximo 5MB.');
                    return $this->refresh();
                }

                $fileName = 'profile_' . $utilizador->utilizador_id . '.' . $file->extension;
                $uploadDir = Yii::getAlias('@webroot/uploads/profile/');
                $path = $uploadDir . $fileName;

                // Criação da diretoria para os pfps caso n exista.
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                //Tentativa de guardar.
                if ($file->saveAs($path)) {
                    $utilizador->profile_picture = 'uploads/profile/' . $fileName;
                    Yii::$app->session->setFlash('success', 'Foto de perfil atualizada!');
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao fazer upload da imagem.');
                }
            }

            if ($user->save() && $utilizador->save()) {
                if (!$file) {
                    Yii::$app->session->setFlash('success', 'Perfil atualizado!');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao salvar as alterações.');
            }

            return $this->refresh();
        }

        return $this->render('index', [
            'user' => $user,
            'utilizador' => $utilizador
        ]);
    }
}
