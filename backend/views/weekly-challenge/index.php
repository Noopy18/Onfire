<?php

use common\models\WeeklyChallenge;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Desafios Semanais:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <p>
                        <?= Html::a('Criar Desafio Semanal', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $models = $dataProvider->getModels();
                                foreach ($models as $index => $challenge): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= Html::encode($challenge->weekly_challenge_id) ?></td>
                                        <td><?= Html::encode($challenge->name) ?></td>
                                        <td><?= Html::encode($challenge->description) ?></td>
                                        <td><?= Yii::$app->formatter->asDate($challenge->start_date) ?></td>
                                        <td>
                                            <?php
                                            $statusLabels = [
                                                0 => '<span class="badge bg-secondary">Inactive</span>',
                                                1 => '<span class="badge bg-success">Active</span>',
                                            ];
                                            echo $statusLabels[$challenge->status] ?? Html::encode($challenge->status);
                                            ?>
                                        </td>
                                        <td>
                                            <?= Html::a('Ver', ['view', 'weekly_challenge_id' => $challenge->weekly_challenge_id], ['class' => 'btn btn-sm btn-primary']) ?>
                                            <?= Html::a('Atualizar', ['update', 'weekly_challenge_id' => $challenge->weekly_challenge_id], ['class' => 'btn btn-sm btn-warning']) ?>
                                            <?= Html::a('Eliminar', ['delete', 'weekly_challenge_id' => $challenge->weekly_challenge_id], [
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Têm a certeza de que quer eliminar este item?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
