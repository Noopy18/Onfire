<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Badge $model */

$this->title = 'Detalhes:';
$this->params['breadcrumbs'][] = ['label' => 'Conquistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Conquista: <?= Html::encode($model->badge_id) ?></h1>
                </div>
                <div class="card-body">
                    <p>
                        <?= Html::a('Atualizar', ['update', 'badge_id' => $model->badge_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Eliminar', ['delete', 'badge_id' => $model->badge_id], [
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
                                <dd class="col-sm-8"><?= Html::encode($model->badge_id) ?></dd>

                                <dt class="col-sm-4">Nome:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->name) ?></dd>

                                <dt class="col-sm-4">Descrição:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->description) ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <dl class="row">
                                <dt class="col-sm-4">Imagem:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->image) ?></dd> 

                                <dt class="col-sm-4">Condição-Tipo:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->condition_type) ?></dd> 

                                <dt class="col-sm-4">Condição-Valor:</dt>
                                <dd class="col-sm-8"><?= Html::encode($model->condition_value) ?></dd> 
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
