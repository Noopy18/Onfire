<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?= Url::to(['site/index']) ?>">Onfire</a>
        
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <?= Html::a('Sobre nós', ['site/about'], ['class' => 'nav-link active']) ?>
                </li>
            </ul>
    </div>
</nav>

 <?= $content ?> 

<!-- Footer -->
<footer class="footer mt-auto py-3 text-muted">
    <div class="container text-center">
        <p>&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?> Todos os direitos reservados.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>