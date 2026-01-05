<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\user $model */
/** @var common\models\utilizador $model_extra */

$this->title = 'Criar Utilizador:';
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h4 mb-0">Utilizador: <?= Html::encode($model->id) ?></h1>
                    </div>
                    <div class="card-body">
                        <?= $this->render('_form', [
                            'model' => $model,
                            'model_extra' => $model_extra,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
