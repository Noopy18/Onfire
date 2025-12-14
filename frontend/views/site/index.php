<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Hero Section -->
<section class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="display-4 fw-bold">Build Better Habits with TrackLife</h1>
            <p class="lead">Transform your life one habit at a time. Our intuitive habit tracker helps you stay consistent and achieve your goals faster.</p>
            <a href="<?= Url::toRoute('site/login'); ?>" class="btn btn-primary btn-lg">Get Started</a>
        </div>
        <div class="col-md-5">
            <?= Html::img('@web/img/logo_Onfire_no_bg.png', [
                    'alt' => 'OnFire Logo',
                    'style' => 'object-fit: contain;'
            ]); ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="container my-5">
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card h-100">
                <?= Html::img('@web/img/logo_Onfire_no_bg.png', [
                        'alt' => 'OnFire Logo',
                        'style' => 'object-fit: contain;'
                ]); ?>
                <div class="card-body">
                    <h5 class="card-title">Track Progress</h5>
                    <p class="card-text">Monitor your daily habits and see your improvement over time with detailed statistics and visual charts.</p>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card h-100">
                <?= Html::img('@web/img/logo_Onfire_no_bg.png', [
                        'alt' => 'OnFire Logo',
                        'style' => 'object-fit: contain;'
                ]); ?>
                <div class="card-body">
                    <h5 class="card-title">Smart Reminders</h5>
                    <p class="card-text">Never forget a habit with our intelligent notification system that adapts to your schedule.</p>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card h-100">
                <?= Html::img('@web/img/logo_Onfire_no_bg.png', [
                        'alt' => 'OnFire Logo',
                        'style' => 'object-fit: contain;'
                ]); ?>
                <div class="card-body">
                    <h5 class="card-title">Community Support</h5>
                    <p class="card-text">Join a community of like-minded people and stay motivated together.</p>
                </div>
            </div>
        </div>
    </div>
</section>