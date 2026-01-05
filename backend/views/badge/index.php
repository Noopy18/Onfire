<?php

use common\models\Badge;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Conquistas:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <p>
                        <?= Html::a('Criar Conquista', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Imagem</th>
                                    <th>Condição: Tipo</th>
                                    <th>Condição: Valor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $models = $dataProvider->getModels();
                                foreach ($models as $badge): ?>
                                    <tr>
                                        <td><?= Html::encode($badge->badge_id) ?></td>
                                        <td><?= Html::encode($badge->name) ?></td>
                                        <td><?= Html::encode($badge->description) ?></td>
                                        <td><?= Html::encode($badge->image) ?></td>
                                        <td><?= Html::encode($badge->condition_type) ?></td>
                                        <td><?= Html::encode($badge->condition_value) ?></td>
                                        <td>
                                            <?= Html::a('Ver', ['view', 'badge_id' => $badge->badge_id], ['class' => 'btn btn-sm btn-primary']) ?>
                                            <?= Html::a('Atualizar', ['update', 'badge_id' => $badge->badge_id], ['class' => 'btn btn-sm btn-warning']) ?>
                                            <?= Html::a('Eliminar', ['delete', 'badge_id' => $badge->badge_id], [
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Têm a certeza de que quer eliminar esta conquista?',
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
