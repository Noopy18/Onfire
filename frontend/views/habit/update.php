<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Habit $model */

$this->title = 'Update Habit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Habits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'habit_id' => $model->habit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="habit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
