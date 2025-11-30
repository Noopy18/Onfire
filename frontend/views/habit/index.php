<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
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
                <form id="habitForm" action="/submit" method="POST">
                    <div class="mb-3">
                        <label for="habitTitle" class="form-label">Título:</label>
                        <input type="text" class="form-control" id="habitTitle" name="habit[name]" required>
                    </div>

                    <div class="mb-3">
                        <label for="habitDescription" class="form-label">Descrição:</label>
                        <textarea id="habitDescription" class="form-control" rows="2" name="habit[description]" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="habitCategory" class="form-label">Categoria:</label>
                        <select id="habitCategory" class="form-select" name="habit[fk_category]" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?=htmlspecialchars($cat->category_id)?>"><?=htmlspecialchars($cat->name)?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- FREQUENCIA REAL -->
                    <input type="hidden" value="" id="frequency_array" name="habit[frequency]">


                    <div class="mb-3">
                        <label for="habitDescription" class="form-label">Frequência:</label>
                        <div class="row p-2">
                            <div class="col">
                                <div class="row">
                                    <p style="text-align: center;">Segunda</p>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="week_checkbox">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <p style="text-align: center;">Terça</p>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="week_checkbox">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <p style="text-align: center;">Quarta</p>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="week_checkbox">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <p style="text-align: center;">Quinta</p>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="week_checkbox">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <p style="text-align: center;">Sexta</p>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="week_checkbox">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <p style="text-align: center;">Sabádo</p>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="week_checkbox">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <p style="text-align: center;">Domingo</p>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="week_checkbox">
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {

                            const checkboxes = document.querySelectorAll('#week_checkbox');
                            checkboxes.forEach(checkbox => {
                                checkbox.addEventListener('change', getCheckedDays);
                            })

                            function getCheckedDays() {

                                const dayWeeksArray = [0,0,0,0,0,0,0];
                                const checkboxes = document.querySelectorAll('#week_checkbox');

                                for (let i = 0; i < checkboxes.length; i++) {
                                    dayWeeksArray[i] = checkboxes[i].checked ? 1 : 0;
                                }

                                const frequencyElement = document.getElementById("frequency_array");
                                frequencyElement.value = JSON.stringify(dayWeeksArray);
                                alert(frequencyElement.value)

                            }

                        })
                    </script>

                    <div class="mb-3" hidden>
                        User ID
                        <input value="<?= $user->id ?>" name="habit[fk_utilizador]">
                    </div>
                    <div class="mb-3" hidden>
                        Type
                        <input value="int" name="habit[type]">
                    </div>
                    <div class="mb-3" hidden>
                        Created at
                        <input value="<?= date("m/d/Y") ?>" name="habit[created_at]">
                    </div>

                    <div class="mb-3">
                        <label for="habitTime" class="form-label">Data final do Hábito. (Opcional)</label>
                        <input type="date" class="form-control" id="habitTime" min="1" name="habit[final_date]">
                    </div>

                    <button type="submit" class="btn w-100 rounded-pill" style="background-color: #ff7b00;">Guardar</button>
                </form>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'description')->textInput() ?>
                <?= $form->field($model, 'frequency')->hiddenInput()->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>