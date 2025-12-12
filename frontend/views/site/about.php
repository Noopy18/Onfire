<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Sobre nós';

?>
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #ff7b00;">
            <?= Html::encode($this->title) ?>
        </h1>
        <p class="text-muted fs-5">
            Conhece a nossa missão, valores e o que nos move todos os dias na <strong>OnFire</strong>.
        </p>
    </div>

    <!-- Secção Missão / Visão / Valores -->
    <div class="row g-4 mb-5 justify-content-center">

        <?php
        $info = [
            [
                'icon' => 'lightning-charge-fill',
                'title' => 'Missão',
                'text'  => 'Motivar pessoas a manterem-se focadas nos seus objetivos, criando hábitos saudáveis e produtivos através de desafios semanais e recompensas.'
            ],
            [
                'icon' => 'eye-fill',
                'title' => 'Visão',
                'text'  => 'Ser a principal plataforma de gamificação pessoal, ajudando utilizadores a atingirem o seu melhor desempenho todos os dias.'
            ],
            [
                'icon' => 'heart-fill',
                'title' => 'Valores',
                'text'  => 'Comprometimento, superação, inovação e paixão pelo progresso pessoal e coletivo.'
            ],
        ];

        foreach ($info as $item): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-<?= $item['icon'] ?> display-5 mb-3" style="color:#ff7b00;"></i>
                        <h5 class="card-title fw-bold mb-3" style="color:#ff7b00;"><?= $item['title'] ?></h5>
                        <p class="card-text text-muted"><?= $item['text'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- Secção Equipa -->
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-3" style="color: #ff7b00;">A Nossa Equipa</h2>
    </div>

    <div class="row g-4 justify-content-center">

        <?php
        $team = [
            ['name' => 'Diogo Faria',  'role' => 'CEO', 'img' => null],
            ['name' => 'Miguel Costa', 'role' => 'CEO', 'img' => null],
            ['name' => 'Max Butescu',  'role' => 'CEO', 'img' => null],
        ];

        $defaultImg = '/images/default-profile.png'; // ← substitua por um caminho válido
        ?>

        <?php foreach ($team as $member): ?>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm text-center p-3">
                    <img 
                        src="<?= $member['img'] ?: $defaultImg ?>" 
                        alt="<?= $member['name'] ?>" 
                        class="rounded-circle mx-auto mb-3" 
                        style="width:120px; height:120px; object-fit:cover;"
                    >
                    <h5 class="fw-bold mb-1"><?= $member['name'] ?></h5>
                    <p class="text-muted small mb-2"><?= $member['role'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

</div>
