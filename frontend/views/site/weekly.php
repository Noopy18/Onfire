<?php
use yii\helpers\Html;

$this->title = 'Desafios Semanais | OnFire';
?>

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Desafios Semanais</h1>
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
                <button class="btn btn-success w-100 rounded-pill">Categoria</button>
                <button class="btn btn-success w-100 rounded-pill">Categoria</button>
                <button class="btn btn-success w-100 rounded-pill">Categoria</button>
                <button class="btn btn-success w-100 rounded-pill">Categoria</button>
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