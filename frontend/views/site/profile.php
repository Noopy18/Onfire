<?php  
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Perfil | OnFire';
?>

<div class="container-fluid py-5">

    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 mb-4">
            <div class="card shadow-sm border-0 rounded-4 p-3">


                <a href="<?= Url::to(['site/request-password-reset']) ?>" 
                   class="btn btn-light w-100 py-3 mb-3 fw-semibold rounded-3">
                   Change Password
                </a>

            </div>
        </div>

        <!-- CONTENT MAIN -->
        <div class="col-md-9 col-lg-10">
            <div class="card shadow-sm border-0 rounded-4 p-4">

                <!-- AVATAR + BADGES -->
                <div class="d-flex align-items-center gap-4 flex-wrap">

                    <!-- Avatar -->
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/180" 
                             class="rounded-circle border border-3 border-light shadow-sm"
                             style="width: 180px; height: 180px; object-fit: cover;">

                        <label for="profileImageUpload" 
                               class="btn btn-sm btn-success position-absolute bottom-0 end-0 rounded-circle">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                        <input type="file" id="profileImageUpload" class="d-none">
                    </div>

                    <!-- Badges -->
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="rounded-circle d-flex justify-content-center align-items-center shadow-sm"
                             style="width: 80px; height: 80px; background: #e9ecef;">
                            <span class="fw-bold small text-center">Current<br>Highest<br>Streak</span>
                        </div>

                        <div class="rounded-circle d-flex justify-content-center align-items-center shadow-sm"
                             style="width: 80px; height: 80px; background: #e9ecef;">
                            <span class="fw-bold">Badge</span>
                        </div>

                        <div class="rounded-circle d-flex justify-content-center align-items-center shadow-sm"
                             style="width: 80px; height: 80px; background: #e9ecef;">
                            <span class="fw-bold">Badge</span>
                        </div>
                    </div>

                </div>

                <!-- Change Name -->
                <div class="mt-4">
                    <input type="text" 
                           class="form-control rounded-3 p-3" 
                           placeholder="Change Name">
                </div>

                <!-- Change Description -->
                <div class="mt-3">
                    <textarea class="form-control rounded-3 p-3" 
                              rows="4" 
                              placeholder="Change Description"></textarea>
                </div>
                <br>
                <button type="submit" class="btn w-100" style="background-color: #ff7b00; color: white;">Guardar Alterações</button>

            </div>
        </div>

    </div>
</div>
