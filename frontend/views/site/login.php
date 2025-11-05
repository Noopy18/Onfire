<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Entrar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    

    <div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3>Entrar</h3>
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => ''],
                ]); ?>

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'username', [
                            'template' => '{input}{label}{error}',
                            'options' => ['class' => 'form-floating mb-3']
                        ])->textInput([
                            'id' => 'floatingInput',
                            'placeholder' => 'name@example.com',
                            'class' => 'form-control'
                        ])->label('Email') ?>
                    </div>

                    <div class="form-floating mb-4">
                        <?= $form->field($model, 'password', [
                            'template' => '{input}{label}{error}',
                            'options' => ['class' => 'form-floating mb-4']
                        ])->passwordInput([
                            'id' => 'floatingPassword',
                            'placeholder' => 'Password',
                            'class' => 'form-control'
                        ])->label('Password') ?>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'form-check-input', 'id' => 'exampleCheck1'])->label('Lembrar-me') ?>
                        <?= Html::a('Esqueci-me da password', ['site/request-password-reset'], ['class' => 'small']) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary py-3 w-100 mb-4', 'name' => 'login-button']) ?>
                    </div>

                    <p class="text-center mb-0">
                        Não tem conta? <?= Html::a('Criar conta', ['site/signup']) ?>
                    </p>

                    <p class="text-center mb-0">
                        Sobre nós <?= Html::a('Sobre nós', ['site/about']) ?>
                    </p>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
