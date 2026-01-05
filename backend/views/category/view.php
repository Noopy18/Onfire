<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = 'Detalhes:';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header" style="background-color: <?= Html::encode($model->color) ?>; color: <?= Html::encode($model->getOppositeColor()) ?>;">
                    <h1 class="h4 mb-0">Categoria: <?= Html::encode($model->category_id) ?></h1>
                </div>
                <div class="card-body">
                    <p>
                        <?= Html::a('Atualizar', ['update', 'category_id' => $model->category_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Eliminar', ['delete', 'category_id' => $model->category_id], [
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
                                <dd class="col-sm-8"><?= Html::encode($model->category_id) ?></dd>

                                <dt class="col-sm-4">Nome:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->name) ?></dd>    
                            </dl>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <dl class="row">
                                <dt class="col-sm-4">Cor:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->color) ?><div style="width: 12px; height: 12px; display: inline-block; background-color: <?= Html::encode($model->color) ?>; margin-left: 5px; border: 1px solid #ccc;"></div></dd> 
                                
                                <dt class="col-sm-4">Descrição:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->description) ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
