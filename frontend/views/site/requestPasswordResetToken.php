<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\PasswordResetRequestForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Request Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3>Reset Password</h3>
                </div>

                <p class="text-muted mb-4">
                    Inser o teu email para fazer o pedido da tua password.
                </p>

                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                    <?= $form->field($model, 'email', [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form-floating mb-3'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    ])->textInput([
                        'autofocus' => true,
                        'id' => 'floatingEmail',
                        'placeholder' => 'name@example.com',
                        'class' => 'form-control',
                    ])->label('Email ') ?>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <a href="<?= \yii\helpers\Url::to(['site/login']) ?>">Voltar para entrar</a>
                    </div>

                    <?= Html::submitButton('Enviar o link de reset', [
                        'class' => 'btn btn-primary py-3 w-100 mb-4',
                        'name' => 'request-password-reset-button'
                    ]) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>