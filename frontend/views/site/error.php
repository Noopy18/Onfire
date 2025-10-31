<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<!-- Error Page Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
        <div class="col-md-6 text-center p-4">
            <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
            <h1 class="display-1 fw-bold"><?= Html::encode($name) ?></h1>
            <h4 class="mb-4 text-danger"><?= nl2br(Html::encode($message)) ?></h4>
            <p class="mb-4">
                The above error occurred while the Web server was processing your request.
            </p>
            <p class="mb-4">
                Please contact us if you think this is a server error. Thank you.
            </p>
            <a class="btn btn-primary rounded-pill py-3 px-5" href="<?= Yii::$app->homeUrl ?>">Go Back To Home</a>
        </div>
    </div>
</div>
<!-- Error Page End -->


