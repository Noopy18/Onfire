<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\user $model */
/** @var common\models\utilizador $model_extra */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_extra' => $model_extra,
    ]) ?>

</div>
