<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\WeeklyChallenge $model */

$this->title = 'Create Weekly Challenge';
$this->params['breadcrumbs'][] = ['label' => 'Weekly Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weekly-challenge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
