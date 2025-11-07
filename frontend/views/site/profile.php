<?php  
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Perfil | OnFire';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Card do perfil -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 text-center p-4">
                <div class="card-body">

                    <!-- Foto de perfil -->
                    <div class="position-relative d-inline-block mb-3">
                        <img src="https://via.placeholder.com/150" alt="Foto de Perfil" class="rounded-circle border border-3 border-light shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                        <label for="profileImageUpload" class="btn btn-sm btn-success position-absolute bottom-0 end-0 rounded-circle">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                        <input type="file" id="profileImageUpload" class="d-none" accept="image/*">
                    </div>

                    <!-- Nome do utilizador -->
                    <h5 class="fw-semibold mb-3 text-muted">Nome do utilizador</h5>

                    <!-- Descrição -->
                    <form>
                        <div class="mb-3">
                            <label for="userDescription" class="form-label fw-semibold">Descrição</label>
                            <textarea id="userDescription" class="form-control rounded-4" rows="3" placeholder="Escreve algo sobre ti..."></textarea>
                        </div>
                        <button type="submit" class="btn w-100" style="background-color: #ff7b00; color: white;">Guardar Alterações</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card de definições -->
        <div class="col-md-4 mt-4 mt-md-0">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4" style="color: #ff7b00;">Definições</h5>

                    <div class="list-group">
                        <a href="<?= Url::to(['site/request-password-reset']) ?>" class="list-group-item list-group-item-action rounded-3 mb-2 text-center">
                            <i class="bi bi-lock-fill me-2"></i> Mudar Password
                        </a>
                        <a href="#" class="list-group-item list-group-item-action rounded-3 mb-2 text-center text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Terminar Sessão
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
