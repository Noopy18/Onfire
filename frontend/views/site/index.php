<?php

/** @var yii\web\View $this */

$this->title = 'Inicio | OnFire';
?>

<div class="row g-4">
        <div class="col-md-3">
            <div class="d-flex flex-column gap-2">
                <button class="btn btn-outline-secondary w-100 rounded-pill">Todas as categorias</button>
                <button class="btn btn-outline-secondary w-100 rounded-pill">Saude</button>
                <button class="btn btn-outline-secondary w-100 rounded-pill">Desporto</button>
                <button class="btn btn-outline-secondary w-100 rounded-pill">Categoria</button>
                <button class="btn btn-outline-secondary w-100 rounded-pill">Categoria</button>
            </div>
        </div>

        <!-- Tabela do(s) desafio(s) semanais-->
        <div class="col-md-9">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Titulo</th>
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
                                    <td>Titulo</td>
                                    <td class="text-muted">Descrição do streak</td>
                                    <td>Categoria do streak</td>
                                    <td>tempo que falta</td>
                                    <td>3</td>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <button class="btn btn-sm" style="color: black; background-color:  #ff7b00;"><b>Guardar<b></button>
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>