<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Entrar';
?>
<div class="site-login">
    

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">

        <div class="card shadow-lg rounded-4 p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Entrar</h3>
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
                        'placeholder' => 'Email',
                        'class' => 'form-control'
                    ])->label('Email') ?>
                </div>

                <div class="form-floating mb-3">
                    <?= $form->field($model, 'password', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3']
                    ])->passwordInput([
                        'placeholder' => 'Password',
                        'class' => 'form-control'
                    ])->label('Password') ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'form-check-input'])->label('Lembrar-me') ?>
                    <?= Html::a('Esqueci-me da password', ['site/request-password-reset'], ['class' => 'small']) ?>
                </div>

                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary w-100 py-2 mb-3']) ?>

                <p class="text-center mb-1">
                    Não tem conta? <?= Html::a('Criar conta', ['site/signup']) ?>
                </p>

                <p class="text-center">
                    <?= Html::a('Sobre nós', ['site/about']) ?>
                </p>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
    </div>
</div>
