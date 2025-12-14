<?php
use yii\helpers\Html;

$this->title = 'Conquistas | OnFire';
?>


<?php foreach ($badges as $badge): ?>
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card text-center shadow-sm border-0 rounded-4">
            <div class="card-body p-3">

                <!-- Imagem da badge -->
                <div class="badge-image mb-3">
                    <img src="/onfire/frontend/web/uploads/badges/ <?= Html::encode($badge->image) ?>"
                         alt="Badge Image"
                         class="img-fluid rounded-3">
                </div>

                <!-- Título -->
                <h5 class="card-title fw-bold mb-2">
                    <?= Html::encode($badge->name) ?>
                </h5>

                <!-- Descrição -->
                <p class="card-text text-muted mb-0">
                    <?= Html::encode($badge->description) ?>
                </p>

            </div>
        </div>
    </div>
<?php endforeach; ?>