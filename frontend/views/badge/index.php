<?php

use yii\helpers\Html;

$this->title = 'Badges';

?>
<div class="container-fluid py-4">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary"><?= Html::encode($this->title) ?></h1>
        <p class="lead text-muted">Unlock achievements and showcase your progress</p>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="badgeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Badges</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="unlocked-tab" data-bs-toggle="tab" data-bs-target="#unlocked" type="button" role="tab">Unlocked</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="locked-tab" data-bs-toggle="tab" data-bs-target="#locked" type="button" role="tab">Locked</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="badgeTabContent">
        <!-- All Badges -->
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            <div class="row g-4">
                <?php foreach ($dataProvider->models as $model): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden <?= !in_array($model->badge_id, $earnedBadges) ? 'opacity-50' : '' ?>">
                            <div class="card-body text-center p-4">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                    <?= Html::img('http://localhost/Onfire/backend/web/' . $model->image, [
                                        'class' => 'rounded-circle', 
                                        'style' => 'width: 80px; height: 80px; object-fit: cover;' . (!in_array($model->badge_id, $earnedBadges) ? ' filter: grayscale(100%);' : ''), 
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

        <!-- Unlocked Badges -->
        <div class="tab-pane fade" id="unlocked" role="tabpanel">
            <div class="row g-4">
                <?php foreach ($dataProvider->models as $model): ?>
                    <?php if (in_array($model->badge_id, $earnedBadges)): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                                <div class="card-body text-center p-4">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                        <?= Html::img('http://localhost/Onfire/backend/web/' . $model->image, [
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
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Locked Badges -->
        <div class="tab-pane fade" id="locked" role="tabpanel">
            <div class="row g-4">
                <?php foreach ($dataProvider->models as $model): ?>
                    <?php if (!in_array($model->badge_id, $earnedBadges)): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden opacity-50">
                                <div class="card-body text-center p-4">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                        <?= Html::img('http://localhost/Onfire/backend/web/' . $model->image, [
                                            'class' => 'rounded-circle', 
                                            'style' => 'width: 80px; height: 80px; object-fit: cover; filter: grayscale(100%);', 
                                            'alt' => $model->name
                                        ]) ?>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark mb-2"><?= Html::encode($model->name) ?></h5>
                                    <p class="card-text text-muted small"><?= Html::encode($model->description) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>