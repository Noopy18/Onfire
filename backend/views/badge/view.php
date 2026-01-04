<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Badge $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Conquistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="badge-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'badge_id' => $model->badge_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'badge_id' => $model->badge_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tens certeza que desejas eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'badge_id',
            'name',
            'description',
            'image',
            'condition_type',
            'condition_value',
        ],
    ]) ?>

</div>
