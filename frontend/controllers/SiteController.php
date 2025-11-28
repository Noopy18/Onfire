<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'contact', 'about', 'weekly', 'badges', 'friends', 'profile', 'settings', 'logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup', 'error', 'login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main';

        $categories = \common\models\Category::find()->all();

        return $this->render('index', ['categories' => $categories]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionWeekly()
    {
        $this->layout = 'main'; 

        $categories = \common\models\Category::find()->all();

        return $this->render('weekly', ['categories' => $categories]);
    }

    public function actionBadges()
    {
        $this->layout = 'main'; 

        $badges = \common\models\Badge::find()->all();

        return $this->render('badges', ['badges' => $badges]);
    }

    public function actionFriends()
    {
        $this->layout = 'main'; 
        return $this->render('friends');

    }

    //este codigo precisa de muitas alterações para funcionar corretamente
    public function actionSearchUsers($q = '')
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $q = trim($q);
        if ($q === '') {
            return [];
        }

        $currentUser = Yii::$app->user->id;

        // não mostrar o proprio utilizador(eu no caso) nem amigos já adicionados pelo utilizador
        $alreadyFriends = (new \yii\db\Query())
            ->select('friend_id')
            ->from('friends')
            ->where(['user_id' => $currentUser])
            ->column();

        $users = \common\models\User::find()
            ->where(['like', 'username', $q])
            ->andWhere(['<>', 'id', $currentUser])
            ->andWhere(['NOT IN', 'id', $alreadyFriends])
            ->limit(20)
            ->all();

        $results = [];
        foreach ($users as $user) {
            $results[] = [
                'id' => $user->id,
                'username' => $user->username,
                'avatar' => $user->getAvatarUrl(),
            ];
        }

        return $results;
    }

    //REVER ESTE CODIGO PARA TENTAR FUNCIONAR O ADICIONAR AMIGOS CORRETAMENTE
    public function actionAddFriend($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $currentUser = Yii::$app->user->id;

        // evitar duplicação
        $exists = (new \yii\db\Query())
            ->from('friends')
            ->where(['user_id' => $currentUser, 'friend_id' => $id])
            ->exists();

        if ($exists) {
            return ['success' => false, 'message' => 'Já é teu amigo.'];
        }

        Yii::$app->db->createCommand()->insert('friends', [
            'user_id' => $currentUser,
            'friend_id' => $id,
        ])->execute();

        return ['success' => true];
    }




    public function actionProfile()
    {
        $this->layout = 'main';
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {

            $user->username = Yii::$app->request->post('username');

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Nome atualizado com sucesso!');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao atualizar nome.');
                Yii::error($user->errors, 'profile');
            }
        }

        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    public function actionSettings()
    {
        $this->layout = 'main'; 
        return $this->render('settings');
    }
}
