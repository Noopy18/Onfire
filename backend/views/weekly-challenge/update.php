<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WeeklyChallenge $model */

$this->title = 'Atualizar Desafio Semanal: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Desafios Semanais', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'weekly_challenge_id' => $model->weekly_challenge_id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="weekly-challenge-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
