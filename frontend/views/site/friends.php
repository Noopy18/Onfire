<?php
use yii\helpers\Html;

$this->title = 'Badges';
?>

<div class="container-fluid py-4">
  <div class="row g-4">
    
    <!-- Lista de amigos -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-4 h-100">
        <div class="card-body">
          <h5 class="fw-bold mb-4 ">Friends</h5>

          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center rounded-pill mb-2">
              <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="Avatar">
              <span class="fw-semibold">Friend</span>
            </a>
          </div>

        </div>
      </div>
    </div>

    <!-- Detalhes do amigo -->
    <div class="col-md-8">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

          <!-- Avatar e badges -->
          <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
            <img src="https://via.placeholder.com/100" class="rounded-circle" alt="Avatar">

            <div class="d-flex align-items-center gap-2">
              <div class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <small class="text-center lh-sm">Current<br>Streak</small>
              </div>
              <div class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <small>Badge</small>
              </div>
              <div class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <small>Badge</small>
              </div>
            </div>
          </div>

        
          <div class="bg-light p-2 rounded-3 mb-3">
            <h5 class="mb-0 fw-semibold">Username</h5>
          </div>

          
          <div class="bg-light p-3 rounded-3 mb-4">
            <p class="mb-0 text-muted">Descrição do utilizador.</p>
          </div>

          
          <div class="text-end">
            <button class="btn btn-outline-danger rounded-pill px-4" action="">Remover de amigo</button>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>