<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::to(['site/index']); ?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">OnFire</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= "[" . key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id)) . "] - " . Yii::$app->user->identity->username ?> </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Yii2 Related', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],

                    ['label' => 'Models', 'header' => true],
                    ['label' => 'Users', 'icon' => 'users', 'url' => ['user/index']],
                    ['label' => 'Category', 'icon' => 'fa fa-list-alt', 'url' => ['category/index']],

                    ['label' => 'Other', 'header' => true],
                ],
            ]);
            ?>
            
            <!-- Logout Form -->
            <div class="nav-item">
                <?= Html::beginForm(['site/logout'], 'post', ['style' => 'margin: 0;']) ?>
                    <button type="submit" class="nav-link btn btn-link text-left" style="width: 100%; border: none; background: none; color: #c2c7d0; padding: 0.5rem 1rem;">
                        <p><i class="nav-icon fas fa-sign-out-alt"></i> Logout</p>
                    </button>
                <?= Html::endForm() ?>
            </div>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>