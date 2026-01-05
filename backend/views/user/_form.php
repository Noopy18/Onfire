<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\user $model */
/** @var common\models\utilizador $model_extra */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'row g-3'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-12">
        <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>
    </div>

    <div class="col-12">
        <?= $form->field($model_extra, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-12">
        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-lg']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
