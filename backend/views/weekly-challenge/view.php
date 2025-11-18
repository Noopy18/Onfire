<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\WeeklyChallenge $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Weekly Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="weekly-challenge-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'weekly_challenge_id' => $model->weekly_challenge_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'weekly_challenge_id' => $model->weekly_challenge_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'weekly_challenge_id',
            'name',
            'description',
            'start_date',
            'status',
        ],
    ]) ?>

</div>
