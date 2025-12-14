<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Habit $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Habits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="habit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'habit_id' => $model->habit_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'habit_id' => $model->habit_id], [
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
            'habit_id',
            'name',
            'description',
            'frequency',
            'final_date',
            'type',
            'created_at',
            'fk_utilizador',
            'fk_category',
        ],
    ]) ?>

</div>
