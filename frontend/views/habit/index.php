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
                <button class="btn w-100 rounded-pill" style="background-color: #ff7b00;" data-bs-toggle="modal" data-bs-target="#createHabitModal">
                    <i class="bi bi-plus-circle"></i> Criar Novo Hábito
                </button>

                <?php

                echo Html::a("Todas as Categorias", ['habit/index', 'selectedCategory' => null], [
                        'class' => 'btn w-100 rounded-pill btn-success',
                ]);

                foreach ($categories as $category) {
                    echo Html::a($category->name, ['habit/index', 'selectedCategory' => $category->category_id], [
                            'class' => 'btn w-100 rounded-pill',
                            'style' => 'background-color: '.$category->color.'; color: '.$category->getOppositeColor().'; border-color: black;',
                    ]);
                }

                ?>
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
                                <th>Settings</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php

                            //Find by category.
                            $models = $dataProvider->getModels();
                            $searchedArray = [];
                            if ($selectedCategory != null) {
                                foreach ($models as $model) {
                                    if ($selectedCategory == $model->fk_category) {
                                        $searchedArray[] = $model;
                                    }
                                }
                            } else {
                                $searchedArray = $models;
                            }

                            foreach ($searchedArray as $habit){
                                echo '<tr>';
                                echo('<td>'.$habit->name.'</td>');
                                echo('<td>'.$habit->description.'</td>');
                                echo('<td>'.$habit->category->name.'</td>');
                                echo('<td>'.$habit->getStreak().'</td>');
                                echo('<td>'.$habit->dueDate().'</td>');
                                echo('<td>'.count($habit->habitCompletions).'</td>');
                                echo('<td>');

                                if ($habit->isCompleted()){
                                    echo('<button class="btn btn-sm rounded-pill px-3 bg-success text-white">Completed!</button>');
                                } elseif ($habit->canBeCompleted()) {
                                    echo Html::beginForm(['habit/index'], 'post');
                                    echo Html::hiddenInput('HabitCompletion[fk_habit]', $habit->habit_id);
                                    echo Html::hiddenInput('HabitCompletion[completed]', true);
                                    echo Html::hiddenInput('HabitCompletion[date]', date('Y-m-d'));
                                    echo Html::submitButton('Completar', ['class' => 'btn btn-sm rounded-pill px-3 text-white', 'style' => 'background-color: orange']);
                                    echo Html::endForm();
                                } else {
                                    echo('<button class="btn btn-sm rounded-pill px-3 text-white" style="background-color: grey">Not the day!</button>');
                                }

                                echo('</td>');

                                echo('<td>');
                                echo Html::beginForm(['habit/view', 'habit_id' => $habit->habit_id], 'post');
                                echo Html::submitButton('<i class="bi bi-gear-fill"></i>', ['class' => 'btn btn-sm rounded-pill px-3', 'style' => 'background-color: orange']);
                                echo Html::endForm();
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