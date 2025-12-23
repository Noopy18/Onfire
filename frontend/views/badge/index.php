<?php

use yii\helpers\Html;

$this->title = 'Badges';

?>
<div class="container-fluid py-4">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary"><?= Html::encode($this->title) ?></h1>
        <p class="lead text-muted">Unlock achievements and showcase your progress</p>
    </div>

    <div class="row g-4">
        <?php foreach ($dataProvider->models as $model): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <?= Html::img($model->image, [
                                'class' => 'rounded-circle', 
                                'style' => 'width: 80px; height: 80px; object-fit: cover;', 
                                'alt' => $model->name
                            ]) ?>
                        </div>
                        <h5 class="card-title fw-bold text-dark mb-2"><?= Html::encode($model->name) ?></h5>
                        <p class="card-text text-muted small"><?= Html::encode($model->description) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>