<?php

use common\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categorias:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <p>
                        <?= Html::a('Criar Categoria', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Cor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $models = $dataProvider->getModels();
                                foreach ($models as $index => $category): ?>
                                    <tr>
                                        <td><?= Html::encode($category->category_id) ?></td>
                                        <td><?= Html::encode($category->name) ?></td>
                                        <td><?= Html::encode($category->description) ?></td>
                                        <td><?= Html::encode($category->color) ?></td>
                                        <td>
                                            <?= Html::a('Ver', ['view', 'category_id' => $category->category_id], ['class' => 'btn btn-sm btn-primary']) ?>
                                            <?= Html::a('Atualizar', ['update', 'category_id' => $category->category_id], ['class' => 'btn btn-sm btn-warning']) ?>
                                            <?= Html::a('Eliminar', ['delete', 'category_id' => $category->category_id], [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Têm a certeza de que quer eliminar esta categoria?',
                                                        'method' => 'post',
                                                    ],
                                                ]) 
                                            ?>
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
