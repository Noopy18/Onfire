<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Utilizadores:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <p>
                        <?= Html::a('Criar Utilizador', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Criado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $models = $dataProvider->getModels();
                                foreach ($models as $index => $user): ?>
                                    <tr>
                                        <td><?= Html::encode($user->id) ?></td>
                                        <td><?= Html::encode($user->username) ?></td>
                                        <td><?= Html::encode($user->email) ?></td>
                                        <td><?= Html::encode($user->status) ?></td>
                                        <td><?= Yii::$app->formatter->asDateTime($user->created_at) ?></td>
                                        <td>
                                            <?= Html::a('Ver', ['view', 'id' => $user->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                            <?= Html::a('Atualizar', ['update', 'id' => $user->id], ['class' => 'btn btn-sm btn-warning']) ?>
                                            <?php if ($user->status == 0): ?>
                                                <?= Html::a('Restaurar', ['restore', 'id' => $user->id], [
                                                    'class' => 'btn btn-sm btn-success',
                                                    'data' => [
                                                        'confirm' => 'Têm a certeza de que quer restaurar este utilizador?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                            <?php else: ?>
                                                <?= Html::a('Eliminar', ['delete', 'id' => $user->id], [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Têm a certeza de que quer eliminar este utilizador?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                            <?php endif; ?>
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
