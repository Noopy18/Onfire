<?php

use frontend\models\Badge;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\BadgesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Badges';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="badge-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Badge', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'badge_id',
            'name',
            'description',
            'image',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Badge $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'badge_id' => $model->badge_id]);
                 }
            ],
        ],
    ]); ?>


</div>
