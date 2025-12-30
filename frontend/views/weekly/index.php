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

    <div class="col-md-12">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th class="text-start">Título</th>
                        <th>Descrição</th>
                        <th>Data-final</th>
                        <th>Conclusão</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $models = $dataProvider->getModels();

                    if (empty($models)) {
                        echo '<tr>';
                        echo '<td colspan="4" class="text-center text-muted py-4">';
                        echo 'Não existem desafios semanais ativos.';
                        echo '</td>';
                        echo '</tr>';
                    }

                    foreach ($models as $weekly) {
                        echo '<tr>';

                        // Título
                        echo '<td class="fw-semibold">';
                        echo Html::encode($weekly->name);
                        echo '</td>';

                        // Descrição
                        echo '<td class="text-muted">';
                        echo Html::encode($weekly->description);
                        echo '</td>';

                        // Datas
                        echo '<td>';
                        if (!empty($weekly->start_date)) {
                            echo Yii::$app->formatter->asDate(
                                $weekly->getEndDate()->format('Y-m-d'));
                        }
                        echo '</td>';

                        // Completion
                        echo '<td>';

                        if ($weekly->isCompletedByUser()) {

                            echo '<button class="btn btn-sm rounded-pill px-3 bg-success text-white">';
                            echo 'Completado!';
                            echo '</button>';

                        } else {

                            echo Html::beginForm(['weekly/index'], 'post');

                            echo Html::hiddenInput(
                                'WeeklyChallengeCompletion[fk_weekly_challenge]',
                                $weekly->weekly_challenge_id
                            );

                            echo Html::submitButton(
                                'Completar',
                                [
                                    'class' => 'btn btn-sm rounded-pill px-3 text-white',
                                    'style' => 'background-color: orange'
                                ]
                            );

                            echo Html::endForm();
                        }

                        echo '</td>';

                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
