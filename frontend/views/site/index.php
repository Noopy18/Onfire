<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Hero Section -->
<section class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="display-4 fw-bold">Constrói Melhores Hábitos com o Onfire</h1>
            <p class="lead">
                Transforma a tua vida um hábito de cada vez.
                O nosso rastreador de hábitos intuitivo ajuda-te a manter a consistência
                e a atingir os teus objetivos mais rapidamente.
            </p>
            <a href="<?= Url::toRoute('site/login'); ?>" class="btn btn-lg" style="background-color: #ff7b00;">
                Começar
            </a>
        </div>
        <div class="col-md-5">
            <?= Html::img('@web/img/logo_Onfire_no_bg.png', [
                'alt' => 'Logótipo OnFire',
                'style' => 'object-fit: contain;'
            ]); ?>
        </div>
    </div>
</section>

<section class="container my-5">
    <div class="row g-4">
        <!-- progresso -->
        <div class="col-md-4">
            <div class="card h-100">
                <?= Html::img('@web/img/landing_page/progress.png', [
                    'alt' => 'Acompanhar progresso',
                    'class' => 'rounded mx-auto mb-3',
                    'style' => 'width: 75%; height: auto; border-radius: 50%; display: block; margin: 0 auto;'
                ]); ?>
                <div class="card-body">
                    <h5 class="card-title">Acompanha o Teu Progresso</h5>
                    <p class="card-text">
                        Monitoriza os teus hábitos diários e acompanha a tua evolução ao longo do tempo,
                        com estatísticas detalhadas e gráficos claros.
                    </p>
                </div>
            </div>
        </div>

        <!-- lembretes -->
        <div class="col-md-4">
            <div class="card h-100">
                <?= Html::img('@web/img/landing_page/alarm.png', [
                    'alt' => 'Lembretes inteligentes',
                    'class' => 'rounded mx-auto mb-3',
                    'style' => 'width: 75%; height: auto; border-radius: 50%; display: block; margin: 0 auto;'
                ]); ?>
                <div class="card-body">
                    <h5 class="card-title">Lembretes Inteligentes</h5>
                    <p class="card-text">
                        Nunca te esqueças de um hábito com o nosso sistema de notificações inteligentes,
                        adaptado à tua rotina.
                    </p>
                </div>
            </div>
        </div>

        <!-- comunidade -->
        <div class="col-md-4">
            <div class="card h-100">
                <?= Html::img('@web/img/landing_page/community.png', [
                    'alt' => 'Comunidade',
                    'class' => 'rounded mx-auto mb-3',
                    'style' => 'width: 75%; height: auto; border-radius: 50%; display: block; margin: 0 auto;'
                ]); ?>
                <div class="card-body">
                    <h5 class="card-title">Apoio da Comunidade</h5>
                    <p class="card-text">
                        Junta-te a uma comunidade de pessoas com objetivos semelhantes
                        e mantém-te motivado com o apoio de todos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
