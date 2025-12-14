<?php
use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\bootstrap5\ActiveForm;
?>
<div class="login-box container-fluid">
    <div class="login-logo">
        <a href=""><b>On</b>Fire</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Entrar</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

            <?= $form->field($model,'username', [
                'options' => ['class' => 'form-group'],
                'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                'template' => '{beginWrapper}{input}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3']
            ])
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form->field($model, 'password', [
                'options' => ['class' => 'form-group'],
                'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                'template' => '{beginWrapper}{input}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3']
            ])
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

            <div class="row">
                <div class="col-4">
                    <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
        <!-- /.login-card-body -->
    </div>
</div>