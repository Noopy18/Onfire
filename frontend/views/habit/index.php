<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Inicio | OnFire';
?>

<div class="container-fluid py-4">

    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hábitos</h1>
    </div>

    <div class="row g-4">

        <!-- Sidebar de Categorias -->
        <div class="col-md-3">
            <div class="d-flex flex-column gap-2">
                <button class="btn w-100 rounded-pill" style="background-color: #ff7b00;"
                        data-bs-toggle="modal" data-bs-target="#createHabitModal">
                    <i class="bi bi-plus-circle"></i> Criar Novo Hábito
                </button>

                <button class="btn btn-success w-100 rounded-pill">Todas as categorias</button>
                <!--codigo que puxa as categorias da bd -->
                <?php foreach ($categories as $cat): ?>
                    <button class="btn w-100 rounded-pill"
                            style="background-color: <?= htmlspecialchars($cat->color) ?>; color: white;">
                        <?= htmlspecialchars($cat->name) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tabela dos hábitos -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">

                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="text-start">Título</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Streak</th>
                                <th>Próxima</th>
                                <th>Total Completions</th>
                                <th>Completion</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php

                            foreach ($dataProvider->getModels() as $habit){

                                $todayDate = date("Y-m-d");
                                $todayWeekday = date("w")-1;
                                $weekdayToComplete = json_decode($habit->frequency, true);
                                $proxima = "Não sei :(";

                                $weekIndex = $todayWeekday;
                                $totalDayTillNext = 0;
                                while ($weekdayToComplete[$weekIndex] == 0){

                                    $weekIndex++;
                                    $totalDayTillNext++;
                                    if ($weekIndex > 6){
                                        $weekIndex = 0;
                                    }
                                    if ($weekdayToComplete[$weekIndex] == 1){
                                        break;
                                    }
                                }

                                if ($weekdayToComplete[$todayWeekday] == 1){
                                    $proxima = "Hoje.";
                                } else if ($weekdayToComplete[$todayWeekday+1] == 1){
                                    $proxima = "Amanhã.";
                                } else if ($weekdayToComplete[$todayWeekday+2] == 1){
                                    $proxima = "Depois de amanhã.";
                                } else {
                                    $proxima = date('d/m/Y', strtotime('+'.$totalDayTillNext.' days'));
                                }


                                echo '<tr>';
                                echo('<td>'.$habit->name.'</td>');
                                echo('<td>'.$habit->description.'</td>');
                                echo('<td>'.$habit->category->name.'</td>');
                                echo('<td>Streak</td>');
                                echo('<td>'.$proxima.'</td>');
                                echo('<td>'.count($habit->habitCompletions).'</td>');
                                echo('<td>');

                                if ($habit->habitCompletions != null){
                                    foreach ($habit->habitCompletions as $completion){
                                        if ($completion->date == $todayDate){
                                            echo('<button class="btn btn-sm rounded-pill px-3" style="background-color: lime">Completed!</button>');
                                            break;
                                        } else {
                                            if ($weekdayToComplete[$todayWeekday] == 1){
                                                echo Html::beginForm(['habit/index'], 'post');
                                                echo Html::hiddenInput('HabitCompletion[fk_habit]', $habit->id);
                                                echo Html::hiddenInput('HabitCompletion[completed]', true);
                                                echo Html::hiddenInput('HabitCompletion[date]', date('Y-m-d'));
                                                echo Html::submitButton('Completar', ['class' => 'btn btn-sm rounded-pill px-3', 'style' => 'background-color: orange']);
                                                echo Html::endForm();
                                                break;
                                            } else {
                                                echo('<button class="btn btn-sm rounded-pill px-3" style="background-color: grey">Not the day!</button>');
                                                break;
                                            }
                                        }
                                    }
                                } else {
                                    if ($weekdayToComplete[$todayWeekday] == 1){
                                        echo Html::beginForm(['habit/index'], 'post');
                                        echo Html::hiddenInput('HabitCompletion[fk_habit]', $habit->habit_id);
                                        echo Html::hiddenInput('HabitCompletion[completed]', true);
                                        echo Html::hiddenInput('HabitCompletion[date]', date('Y-m-d'));
                                        echo Html::submitButton('Completar', ['class' => 'btn btn-sm rounded-pill px-3', 'style' => 'background-color: orange']);
                                        echo Html::endForm();
                                    } else {
                                        echo('<button class="btn btn-sm rounded-pill px-3" style="background-color: grey">Not the day!</button>');
                                    }
                                }
                                echo('</td>');
                                echo('</tr>');
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar Hábito -->
<div class="modal fade" id="createHabitModal" tabindex="-1" aria-labelledby="createHabitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createHabitModalLabel">Criar novo hábito semanal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-lg">
                    <?php
                    echo Html::beginForm(['habit/create'], 'post');
                    echo Html::activeTextInput($model, 'name', ['id' => 'createHabitName', 'class' => 'form-control', 'placeholder' => 'Título']);
                    echo Html::activeTextArea($model, 'description', ['id' => 'createHabitName', 'class' => 'form-control', 'placeholder' => 'Descrição']);
                    echo Html::activeDropDownList($model, 'fk_category', yii\helpers\ArrayHelper::map($categories, 'category_id', 'name'), ['class' => 'form-select', 'prompt' => 'Selecione uma categoria']);
                    echo Html::activeHiddenInput($model, 'frequency', ['id' => 'frequency_array']);
                    ?>
                    <div class="mb-3">
                        <label class="form-label">Frequência:</label>
                        <div class="row p-2">
                            <?php $days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo']; ?>
                            <?php foreach ($days as $index => $day): ?>
                                <div class="col">
                                    <div class="row">
                                        <p style="text-align: center;"><?= $day ?></p>
                                    </div>
                                    <div class="row align-items-center justify-content-center">
                                        <input type="checkbox" class="form-check-input week-checkbox" data-day="<?= $index ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    echo Html::activeDropDownList($model, 'type', [
                            'boolean' => 'Boolean',
                            'int' => 'Integer',
                    ], ['class' => 'form-select']);
                    echo Html::input('date', 'Habit[final_date]', '', ['id' => 'createHabitDate', 'class' => 'form-control', 'placeholder' => 'Data']);
                    echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
                    echo Html::endForm();
                    ?>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const checkboxes = document.querySelectorAll('.week-checkbox');
                            checkboxes.forEach(checkbox => {
                                checkbox.addEventListener('change', updateFrequency);
                            });

                            function updateFrequency() {
                                const dayArray = [0,0,0,0,0,0,0];
                                checkboxes.forEach((checkbox, index) => {
                                    dayArray[index] = checkbox.checked ? 1 : 0;
                                });
                                document.getElementById('frequency_array').value = JSON.stringify(dayArray);
                            }
                        });
                    </script>

            </div>
        </div>
    </div>
</div>