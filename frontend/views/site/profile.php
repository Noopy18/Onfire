<?php  
use yii\helpers\Html;

$this->title = 'Profile';
?>

<div class="col-md-4">
    <div class="card shadow-sm border-0 rounded-4 h-100">
        <div class="card-body">
            <h5 class="fw-bold mb-4">Definições</h5>

            <div class="list-group">
                <a href="<?= \yii\helpers\Url::to(['site/request-password-reset'])?>" class="llist-group-item list-group-item-action d-flex justify-content-center align-items-center rounded-pill mb-2 text-center text-decoration-none">
                <span class="fw-semibold">Mudar Password</span>
                </a>
            </div>
        </div>
    </div>
</div>


