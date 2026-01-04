<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\user $model */
/** @var common\models\utilizador $model_extra */

$this->title = 'Atualizar Utilizador: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_extra' => $model_extra,
    ]) ?>

</div>
