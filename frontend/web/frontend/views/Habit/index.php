<?php

use frontend\models\Habit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\HabitSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Habits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Habit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'habit_id',
            'name',
            'description',
            'frequency',
            'final_date',
            //'type',
            //'created_at',
            //'fk_utilizador',
            //'fk_category',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Habit $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'habit_id' => $model->habit_id]);
                 }
            ],
        ],
    ]); ?>


</div>
