<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Badge $model */

$this->title = 'Create Badge';
$this->params['breadcrumbs'][] = ['label' => 'Badges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="badge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
