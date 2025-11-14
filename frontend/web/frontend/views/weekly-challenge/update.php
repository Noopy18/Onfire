<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\WeeklyChallenge $model */

$this->title = 'Update Weekly Challenge: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Weekly Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'weekly_challenge_id' => $model->weekly_challenge_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weekly-challenge-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
