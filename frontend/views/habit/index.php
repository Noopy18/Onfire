<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
                                <th>Due Time</th>
                                <th>Streak</th>
                                <th>Feito</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td class="text-start fw-semibold">Titulo</td>
                                <td class="text-muted">Descrição do streak</td>
                                <td>Categoria do streak</td>
                                <td>tempo que falta</td>
                                <td class="fw-semibold">3</td>
                                <td>
                                    <input type="checkbox" class="form-check-input">
                                </td>
                                <td>
                                    <button class="btn btn-sm rounded-pill px-3" style="background-color: orange">
                                        Guardar
                                    </button>
                                </td>
                            </tr>
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
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name')->textInput(['class' => 'form-control', 'placeholder' => 'Título do hábito']) ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 2, 'class' => 'form-control', 'placeholder' => 'Descrição do hábito']) ?>
                <?= $form->field($model, 'fk_category')->dropDownList(
                    yii\helpers\ArrayHelper::map($categories, 'category_id', 'name'),
                    ['class' => 'form-select', 'prompt' => 'Selecione uma categoria']
                ) ?>
                
                <?= $form->field($model, 'frequency')->hiddenInput(['id' => 'frequency_array'])->label(false) ?>
                
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
                
                <?= $form->field($model, 'type')->dropDownList([
                    'boolean' => 'Boolean (Sim/Não)',
                    'int' => 'Integer (Número)'
                ], ['class' => 'form-select']) ?>
                <?= $form->field($model, 'final_date')->input('date', ['class' => 'form-control']) ?>
                
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

                <div class="form-group">
                    <?= Html::submitButton('Criar Hábito', ['class' => 'btn w-100 rounded-pill', 'style' => 'background-color: #ff7b00; color: white;']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>