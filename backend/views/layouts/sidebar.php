<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::to(['site/index']); ?>" class="brand-link">
        <?= Html::img('@web/img/logo_Onfire_no_bg_centered.png', [
                            'alt' => 'OnFire Logo',
                            'style' => 'width: 20%; height: 20%; object-fit: contain;',
                            'class' => 'img-fluid',
                    ]); ?>
        <span class="brand-text font-weight-light">OnFire</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= Yii::$app->user->identity->utilizador->profile_picture
                                ? 'http://localhost/Onfire/frontend/web/' . Yii::$app->user->identity->utilizador->profile_picture
                                : 'https://via.placeholder.com/150' ?>"
                                class="img-circle elevation-2" alt="Image">
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
                    ['label' => 'Modelos', 'header' => true],
                    ['label' => 'Utilizadores', 'icon' => 'users', 'url' => ['user/index']],
                    ['label' => 'Categorias', 'icon' => 'fa fa-list-alt', 'url' => ['category/index']],
                    ['label' => 'Desafios Semanais', 'icon' => 'fa fa-calendar', 'url' => ['weekly-challenge/index']],
                    ['label' => 'Conquistas', 'icon' => 'fa fa-trophy', 'url' => ['badge/index']],

                    ['label' => 'Other', 'header' => true],
                ],
            ]);
            ?>
            
            <!-- Logout Form -->
            <div class="nav-item">
                <?= Html::beginForm(['site/logout'], 'post', ['style' => 'margin: 0;']) ?>
                    <button type="submit" class="nav-link btn btn-link text-left" style="width: 100%; border: none; background: none; color: #c2c7d0; padding: 0.5rem 1rem;">
                        <p><i class="nav-icon fas fa-sign-out-alt"></i> Sair</p>
                    </button>
                <?= Html::endForm() ?>
            </div>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>