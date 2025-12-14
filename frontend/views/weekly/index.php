<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;

$this->title = 'Desafios Semanais | OnFire';
?>

<div class="container-fluid py-4">

    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Desafios Semanais</h1>
    </div>

    <div class="row g-4">

        <?php foreach ($dataProvider->getModels() as $weekly): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body d-flex flex-column">

                        <!-- Título -->
                        <h5 class="card-title fw-bold">
                            <?= Html::encode($weekly->name) ?>
                        </h5>

                        <!-- Descrição -->
                        <p class="card-text text-muted">
                            <?= Html::encode($weekly->description) ?>
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">

                            <!-- COMPLETION -->
                            <?php if ($weekly->isCompletedByUser()): ?>
                                <button class="btn btn-sm rounded-pill bg-success text-white">
                                    Completado!
                                </button>
                            <?php else: ?>
                                <?= Html::beginForm(['weekly-challenge/index'], 'post') ?>

                                    <?= Html::hiddenInput(
                                        'WeeklyChallengeCompletion[fk_weekly_challenge]',
                                        $weekly->weekly_challenge_id
                                    ) ?>

                                    <?= Html::submitButton(
                                        'Completar',
                                        [
                                            'class' => 'btn btn-sm rounded-pill text-white',
                                            'style' => 'background-color: orange'
                                        ]
                                    ) ?>

                                <?= Html::endForm() ?>
                            <?php endif; ?>

                            <!-- Data -->
                            <small class="text-muted">
                                Até <?= Yii::$app->formatter->asDate($weekly->end_date) ?>
                            </small>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($dataProvider->getModels())): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Não existem desafios semanais ativos.
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
