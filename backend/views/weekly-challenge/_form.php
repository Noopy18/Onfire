<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\WeeklyChallenge $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="weekly-challenge-form">

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
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'start_date')->input('date') ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'status')->dropDownList([
            0 => 'Inactive',
            1 => 'Active',
        ], ['prompt' => 'Select Status']) ?>
    </div>

    <div class="col-12">
        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-lg']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
