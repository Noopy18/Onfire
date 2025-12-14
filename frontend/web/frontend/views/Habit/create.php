<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Habit $model */

$this->title = 'Create Habit';
$this->params['breadcrumbs'][] = ['label' => 'Habits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
