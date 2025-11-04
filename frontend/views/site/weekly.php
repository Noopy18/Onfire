<?php
use yii\helpers\Html;

$this->title = 'Weekly Challenges';
?>

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= Html::encode($this->title) ?></h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createHabitModal">
            <i class="bi bi-plus-circle"></i> Criar Novo Hábito
        </button>
    </div>

    <div class="row">
        <!-- Desafios já existentes -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Desafio da Semana #1</h5>
                    <p class="card-text">Completa 10 treinos esta semana e ganha 50 pontos!</p>
                    <a href="#" class="btn btn-primary btn-sm">Participar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar Hábito -->
<div class="modal fade" id="createHabitModal" tabindex="-1" aria-labelledby="createHabitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createHabitModalLabel">Criar novo hábito semanal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="habitForm">
            <div class="mb-3">
                <label for="habitTitle" class="form-label">Título do Hábito</label>
                <input type="text" class="form-control" id="habitTitle" required>
            </div>

            <div class="mb-3">
                <label for="habitCategory" class="form-label">Categoria</label>
                <select id="habitCategory" class="form-select" required>
                <option value="">Selecione uma categoria</option>
                <option value="">Categoria</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="habitDescription" class="form-label">Descrição</label>
                <textarea id="habitDescription" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="habitTime" class="form-label">Data inicial do streak</label>
                <input type="week" class="form-control" id="habitTime" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Fim do Modal Criar Hábito -->