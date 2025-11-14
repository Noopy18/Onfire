<?php

use frontend\models\WeeklyChallenge;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\WeeklyChallengeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Weekly Challenges';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weekly-challenge-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Weekly Challenge', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'weekly_challenge_id',
            'name',
            'description',
            'start_date',
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, WeeklyChallenge $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'weekly_challenge_id' => $model->weekly_challenge_id]);
                 }
            ],
        ],
    ]); ?>


</div>
