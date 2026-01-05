<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\user $model */

$this->title = 'Detalhes:';
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ver';
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Utilizador: <?= Html::encode($model->id) ?></h1>
                </div>
                <div class="card-body">
                    <p>
                        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php if ($model->status == 0): ?>
                            <?= Html::a('Restaurar', ['restore', 'id' => $model->id], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => 'Tens certeza que desejas restaurar este utilizador?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php else: ?>
                            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Tens certeza que desejas eliminar este item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">ID:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->id) ?></dd>

                                <dt class="col-sm-4">Username:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->username) ?></dd>

                                <dt class="col-sm-4">Email:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->email) ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <dl class="row">
                                <dt class="col-sm-4">Created At:</dt>
                                <dd class="col-sm-8"><?= Yii::$app->formatter->asDateTime($model->created_at) ?></dd>

                                <dt class="col-sm-4">Updated At:</dt>
                                <dd class="col-sm-8"><?= $model->updated_at ? Yii::$app->formatter->asDateTime($model->updated_at) : 'Never' ?></dd>

                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    <?php
                                    $statusLabels = [
                                        0 => '<span class="badge bg-danger">Deleted</span>',
                                        9 => '<span class="badge bg-warning">Inactive</span>',
                                        10 => '<span class="badge bg-success">Active</span>',
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
