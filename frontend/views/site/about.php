<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Sobre nós';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">
    
    <div class="text-center mb-5">
        <h1 class="fw-bold"  style="color: #ff7b00;"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted fs-5">Conhece a nossa missão, valores e o que nos move todos os dias na <strong>OnFire</strong>.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-lightning-charge-fill display-5 mb-3" style="color: #ff7b00;"></i>
                    <h5 class="card-title fw-bold mb-3" style="color: #ff7b00;">Missão</h5>
                    <p class="card-text text-muted">Motivar pessoas a manterem-se focadas nos seus objetivos, criando hábitos saudáveis e produtivos através de desafios semanais e recompensas.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-eye-fill display-5 mb-3" style="color: #ff7b00;"></i>
                    <h5 class="card-title fw-bold mb-3" style="color: #ff7b00;">Visão</h5>
                    <p class="card-text text-muted">Ser a principal plataforma de gamificação pessoal, ajudando utilizadores a atingirem o seu melhor desempenho todos os dias.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-heart-fill display-5 mb-3" style="color: #ff7b00;"></i>
                    <h5 class="card-title fw-bold mb-3" style="color: #ff7b00;">Valores</h5>
                    <p class="card-text text-muted">Comprometimento, superação, inovação e paixão pelo progresso pessoal e coletivo.</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-3" style="color: #ff7b00;">A Nossa Equipa</h2>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center p-3">
                <img src="" class="rounded-circle mx-auto mb-3">
                <h5 class="fw-bold mb-1">Diogo Faria</h5>
                <p class="text-muted small mb-2">CEO & Fundador</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center p-3">
                <img src="" class="rounded-circle mx-auto mb-3">
                <h5 class="fw-bold mb-1">Miguel Costa</h5>
                <p class="text-muted small mb-2">CEO & Fundador</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center p-3">
                <img src="" class="rounded-circle mx-auto mb-3">
                <h5 class="fw-bold mb-1">Max Butescu</h5>
                <p class="text-muted small mb-2">CEO & Fundador</p>
                
            </div>
        </div>
    </div>
</div>