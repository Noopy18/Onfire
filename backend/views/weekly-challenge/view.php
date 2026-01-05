<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WeeklyChallenge $model */

$this->title = 'Detalhes:';
$this->params['breadcrumbs'][] = ['label' => 'Desafios Semanais', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'weekly_challenge_id' => $model->weekly_challenge_id]];
$this->params['breadcrumbs'][] = 'Ver';
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Desafio Semanal:</h1>
                </div>
                <div class="card-body">
                    <p>
                        <?= Html::a('Atualizar', ['update', 'weekly_challenge_id' => $model->weekly_challenge_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Eliminar', ['delete', 'weekly_challenge_id' => $model->weekly_challenge_id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Tens certeza que desejas eliminar este item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">ID:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->weekly_challenge_id) ?></dd>

                                <dt class="col-sm-4">Name:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->name) ?></dd>

                                <dt class="col-sm-4">Description:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->description) ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Start Date:</dt>
                                <dd class="col-sm-8"><?= Yii::$app->formatter->asDate($model->start_date) ?></dd>

                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    <?php
                                    $statusLabels = [
                                        0 => '<span class="badge bg-secondary">Inactive</span>',
                                        1 => '<span class="badge bg-success">Active</span>',
                                    ];
                                    echo $statusLabels[$model->status] ?? Html::encode($model->status);
                                    ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
