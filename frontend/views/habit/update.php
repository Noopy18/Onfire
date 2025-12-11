<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Habit $model */

$this->title = 'Update Habit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Habits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'habit_id' => $model->habit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="habit-update">
    <div class="container-fluid">
        <div class="card-body p-4">
            <?php echo Html::beginForm(['habit/update', 'habit_id' => $model->habit_id], 'post'); ?>

            <div class="mb-4">
                <label for="createHabitName" class="form-label fw-bold">Título do Hábito</label>
                <?= Html::activeTextInput($model, 'name', [
                    'id' => 'createHabitName',
                    'class' => 'form-control form-control-lg',
                    'placeholder' => 'Digite o título do seu hábito'
                ]) ?>
            </div>

            <div class="mb-4">
                <label for="createHabitDescription" class="form-label fw-bold">Descrição</label>
                <?= Html::activeTextArea($model, 'description', [
                    'id' => 'createHabitDescription',
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Descreva seu hábito em detalhes'
                ]) ?>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Categoria</label>
                <?= Html::activeDropDownList($model, 'fk_category',
                    yii\helpers\ArrayHelper::map($categories, 'category_id', 'name'), [
                    'class' => 'form-select form-select-lg',
                    'prompt' => 'Selecione uma categoria'
                ]) ?>
            </div>

            <?= Html::activeHiddenInput($model, 'frequency', ['id' => 'frequency_array']) ?>

            <div class="mb-4">
                <label class="form-label fw-bold">Frequência Semanal</label>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row g-2">
                            <?php $days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo']; ?>
                            <?php foreach ($days as $index => $day): ?>
                                <div class="col">
                                    <div class="text-center">
                                        <div class="form-check d-flex flex-column align-items-center">
                                            <label class="form-check-label small fw-semibold mb-2" for="day-<?= $index ?>">
                                                <?= $day ?>
                                            </label>
                                            <input type="checkbox"
                                                   class="form-check-input week-checkbox"
                                                   id="day-<?= $index ?>"
                                                   data-day="<?= $index ?>"
                                                   style="transform: scale(1.2);"
                                                   <?php
                                                       $frequency = json_decode($model->frequency);
                                                       if ($frequency[$index] == 1){ echo 'checked'; }
                                                   ?>
                                            >
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Tipo de Medição</label>
                <?= Html::activeDropDownList($model, 'type', [
                    'boolean' => 'Sim/Não (Boolean)',
                    'int' => 'Numérico (Integer)',
                ], ['class' => 'form-select form-select-lg']) ?>
            </div>

            <div class="mb-4">
                <label for="createHabitDate" class="form-label fw-bold">Data Final</label>
                <?= Html::input('date', 'Habit[final_date]', $model->final_date, [
                    'id' => 'createHabitDate',
                    'class' => 'form-control form-control-lg'
                ]) ?>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <?= Html::a('Cancelar', ['view', 'habit_id' => $model->habit_id], [
                    'class' => 'btn btn-outline-secondary btn-lg me-md-2'
                ]) ?>
                <?= Html::submitButton('<i class="fas fa-save me-2"></i>Atualizar Hábito', [
                    'class' => 'btn btn-primary btn-lg'
                ]) ?>
            </div>

            <?php echo Html::endForm(); ?>
        </div>
    </div>
</div>

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
