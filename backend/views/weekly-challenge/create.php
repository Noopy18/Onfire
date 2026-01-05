<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WeeklyChallenge $model */

$this->title = 'Criar Desafio Semanal:';
$this->params['breadcrumbs'][] = ['label' => 'Desafios Semanais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Desafio Semanal: <?= Html::encode($model->weekly_challenge_id) ?></h1>
                </div>
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
