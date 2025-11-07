<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Criar conta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">


    <div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3>Criar conta</h3>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
                    'options' => ['novalidate' => true],
                    'enableClientValidation' => true,
                ]); ?>

                    <?= $form->field($model, 'username', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->textInput([
                        'id' => 'floatingText',
                        'placeholder' => 'jhondoe',
                        'class' => 'form-control',
                    ])->label('Nome do utilizador') ?>

                    <?= $form->field($model, 'email', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->textInput([
                        'id' => 'floatingInput',
                        'placeholder' => 'name@example.com',
                        'class' => 'form-control',
                    ])->label('Email') ?>

                    <?= $form->field($model, 'password', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->passwordInput([
                        'id' => 'floatingPassword',
                        'placeholder' => 'Password',
                        'class' => 'form-control',
                    ])->label('Password') ?>

                    <?= $form->field($model, 'confirmPassword', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-4'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->passwordInput([
                        'id' => 'floatingConfirmPassword',
                        'placeholder' => 'Confirm Password',
                        'class' => 'form-control',
                    ])->label('Confirmar a Password') ?>


                    <div class="form-group">
                        <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary py-3 w-100 mb-4', 'name' => 'signup-button']) ?>
                    </div>

                    <p class="text-center mb-0">
                        Já tem conta? <?= Html::a('Entrar', ['site/login']) ?>
                    </p>
                    
                    <p class="text-center mb-0">
                        Sobre nós <?= Html::a('Sobre nós', ['site/about']) ?>
                    </p>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>