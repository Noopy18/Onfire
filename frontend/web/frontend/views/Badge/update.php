<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Badge $model */

$this->title = 'Update Badge: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Badges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'badge_id' => $model->badge_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="badge-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
