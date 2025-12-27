<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Badge $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="badge-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['allowEmpty' => true, 'required' => false]) ?>

    <?= $form->field($model, 'condition_type')->dropDownList([ 'streak' => 'Streak', 'habit_completions' => 'Habit completions', 'habits_completed' => 'Habits completed', 'wc_completions' => 'Wc completions', 'wc_completed' => 'Wc completed', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'condition_value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
