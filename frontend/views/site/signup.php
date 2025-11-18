<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Criar conta';

?>
<div class="site-signup">


    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">

        <div class="card shadow-lg rounded-4 p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Criar conta</h3>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'options' => ['novalidate' => true],
                'enableClientValidation' => true,
            ]); ?>

                <!-- Nome de utilizador -->
                <div class="form-floating mb-3">
                    <?= $form->field($model, 'username', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->textInput([
                        'placeholder' => 'Nome do utilizador',
                        'class' => 'form-control'
                    ])->label('Nome do utilizador') ?>
                </div>

                <!-- Email -->
                <div class="form-floating mb-3">
                    <?= $form->field($model, 'email', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->textInput([
                        'placeholder' => 'Email',
                        'class' => 'form-control'
                    ])->label('Email') ?>
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <?= $form->field($model, 'password', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->passwordInput([
                        'placeholder' => 'Password',
                        'class' => 'form-control'
                    ])->label('Password') ?>
                </div>

                <!-- Confirmar Password -->
                <div class="form-floating mb-4">
                    <?= $form->field($model, 'confirmPassword', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-4'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->passwordInput([
                        'placeholder' => 'Confirmar Password',
                        'class' => 'form-control'
                    ])->label('Confirmar Password') ?>
                </div>

                <!-- Botão -->
                <?= Html::submitButton('Criar conta', ['class' => 'btn btn-primary w-100 py-2 mb-3', 'name' => 'signup-button']) ?>

                <!-- Link Login -->
                <p class="text-center mb-1">
                    Já tem conta? <?= Html::a('Entrar', ['site/login']) ?>
                </p>

                <!-- Sobre nós -->
                <p class="text-center">
                    <?= Html::a('Sobre nós', ['site/about']) ?>
                </p>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
    </div>
</div>