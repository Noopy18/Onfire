<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$action = Yii::$app->controller->action->id;
$controller = Yii::$app->controller->id;
//paginas sem sidebar e navbar
$hideSidebar = in_array($action, ['login', 'signup', 'request-password-reset', 'error', 'about']); 
//função para mostar a pagina ativa na sidebar
$currentRoute = Yii::$app->controller->route;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>


    <link href="<?= Yii::getAlias('@web') ?>/css/style.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web') ?>/css/site.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web') ?>/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= Yii::getAlias('@web') ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web') ?>/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php if (!$hideSidebar): ?>

    <!-- Sidebar Start -->
    <div class="sidebar bg-light pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <?= Html::img('@web/img/logo_Onfire_no_bg_centered.png', [
                            'alt' => 'OnFire Logo',
                            'style' => 'width: 35%; height: 35%; object-fit: contain;',
                            'class' => 'img-fluid',
                    ]); ?>
                    <h4 class="mb-0" style="font-family: Gadugi,serif">OnFire</h4>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="<?= \yii\helpers\Url::to(['habit/index']) ?>"
                   class="nav-item nav-link" style="margin-top: 100px" <?= $currentRoute == 'habit/index' ? 'active' : '' ?>">
                    <i class="fa fa-home"></i> Início
                </a>
                <a href="<?= \yii\helpers\Url::to(['site/weekly']) ?>"
                   class="nav-item nav-link <?= $currentRoute == 'site/weekly' ? 'active' : '' ?>">
                    <i class="bi bi-calendar"></i> Desafios Semanais
                </a>
                <a href="<?= \yii\helpers\Url::to(['site/badges']) ?>"
                   class="nav-item nav-link <?= $currentRoute == 'site/badges' ? 'active' : '' ?>">
                    <i class="bi bi-trophy"></i> Conquistas
                </a>
                <a href="<?= \yii\helpers\Url::to(['friends/index']) ?>"
                   class="nav-item nav-link <?= $currentRoute == 'friends/index' ? 'active' : '' ?>">
                    <i class="bi bi-people"></i> Amigos
                </a>
                <a href="<?= \yii\helpers\Url::to(['site/profile']) ?>"
                   class="nav-item nav-link <?= $currentRoute == 'site/profile' ? 'active' : '' ?>">
                    <i class="fa fa-user me-2"></i> Perfil
                </a>
                <?= Html::beginForm(['site/logout'], 'post') ?>
                    <button class="nav-item nav-link btn btn-link" style="text-align:left;">
                    <i class="fa fa-sign-in-alt me-2"></i> Logout
                    </button>
                <?= Html::endForm() ?>

                 <hr class="my-3">

                <!-- Tema: Sol / Lua -->
                <div class="nav-item nav-link d-flex justify-content-between align-items-center">
                    <span>Tema</span>
                    <div class="d-flex gap-2">

                        <!-- Light Mode -->
                        <i class="bi bi-sun-fill"
                        onclick="setLightMode()"
                        style="cursor: pointer; font-size: 20px; color: #ff7b00;"></i>

                        <!-- Dark Mode -->
                        <i class="bi bi-moon-fill"
                        onclick="setDarkMode()"
                        style="cursor: pointer; font-size: 20px; color: #6c757d;"></i>
                    </div>
                </div>

                <!-- Formato Horário -->
                <div class="nav-item nav-link d-flex justify-content-between align-items-center">
                    <span>Formato</span>
                    <i class="bi bi-clock-history"
                    onclick="toggleHourFormat()"
                    style="cursor: pointer; font-size: 20px;"></i>
                </div>
            </div>
        </nav>
    </div>
<!-- Sidebar End -->
    <!-- Navbar Start -->        
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-2 shadow-sm">
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>

    <!-- Notificações à direita -->
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notificações</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Perfil atualizado</h6>
                    <small>há 15 minutos</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item text-center">Ver todas as notificações</a>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->


<?php endif; ?>

<!-- Content of the site -->
<div class="content">
    <main role="main" class="flex-shrink-0">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>
        <?= $content ?>
    </main>
</div>

<?php
//if (!Yii::$app->user->isGuest){
//    echo('<div class="content">');
//    echo('<main role="main" class="flex-shrink-0">');
//    echo('<div class="container">');
//    echo(Breadcrumbs::widget([
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//    ]));
//    echo(Alert::widget());
//    echo($content);
//    echo('</div>');
//    echo('</div>');
//    echo('</div>');
//} else {
//    echo('<div class="container">');
//    echo(Breadcrumbs::widget([
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//    ]));
//    echo(Alert::widget());
//    echo($content);
//    echo('</div>');
//}
//
//?>


<?php if (!$hideSidebar): ?>
<!-- Footer -->
<footer class="footer mt-auto py-3 text-muted">
    <div class="container text-center">
        <p>&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?> Todos os direitos reservados.</p>
    </div>
</footer>
<?php endif; ?>

<?php $this->endBody() ?>

<!-- JavaScript Libraries -->
<script src="<?= Yii::getAlias('@web') ?>/lib/chart/chart.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/lib/easing/easing.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/lib/waypoints/waypoints.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/lib/tempusdominus/js/moment.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
<?php $this->endPage() ?>
