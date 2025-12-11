<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Habit $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Habits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="habit-view py-4">

    <div class="container-fluid py-4">

        <div class="row g-3">
            <div class="col-md-9">
                <div class="card shadow-sm border-0 mb-3 " style="background-color: orange">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <h1 class="h2 mb-0 mr-3 text-white"><?= $model->name ?></h1>
                                </div>
                                <p class="text-success align-items-center justify-content-center">
                                    <?= $model->description ?>
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                    <p class="text-white align-items-center justify-content-center">Data de criação: <br><?= $model->created_at ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-1 mb-3 " style="background-color: <?= $model->category->color ?>">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <h1 class="h2 mb-0 mr-3" style="color: <?= $model->category->getOppositeColor()?>">Categoria: </h1>
                                </div>
                                <p class="align-items-center justify-content-center" style="color: <?= $model->category->getOppositeColor()?>">
                                    <?= $model->category->name ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-3 mb-3">
            <div class="col-md-6">

                <?php

                if ($model->isCompleted()){
                    echo('<button class="btn w-100 py-4 text-white bg-success">Completed!</button>');
                } elseif ($model->canBeCompleted()) {
                    echo Html::beginForm(['habit/view', 'habit_id' => $model->habit_id], 'post');
                    echo Html::hiddenInput('HabitCompletion[fk_habit]', $model->habit_id);
                    echo Html::hiddenInput('HabitCompletion[completed]', true);
                    echo Html::hiddenInput('HabitCompletion[date]', date('Y-m-d'));
                    echo Html::submitButton('Completar', ['class' => 'btn w-100 py-4 text-white', 'style' => 'background-color: orange;']);
                    echo Html::endForm();
                } else {
                    echo('<button class="btn w-100 py-4 text-white" style="background-color: grey">Not the day!</button>');
                }
                ?>

            </div>
            <div class="col-md-6">
                <div class="row g-3">
                    <div class="col-md-6">
                        <?= Html::a('<i class="fas fa-edit"></i> Update',
                                ['update', 'habit_id' => $model->habit_id],
                                ['class' => 'btn-primary btn w-100 py-4 text-white'])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::a('<i class="fas fa-trash"></i> Delete',
                                ['delete', 'habit_id' => $model->habit_id],
                                [
                                        'class' => 'btn-danger btn w-100 py-4 text-white',
                                        'data' => [
                                                'confirm' => 'Are you sure you want to delete this habit?',
                                                'method' => 'post',
                                        ],
                                ])
                        ?>
                    </div>
                </div>



            </div>
        </div>

        <!-- Category and Actions-->
        <div class="row g-3 mb-3">
            <!-- Current Streak -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm" style="background-color: orange">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-fire fa-2x text-success"></i>
                        </div>
                        <h2 class="text-white display-4 fw-bold"><?= $model->getStreak()?></h2>
                        <p class="text-success mb-0">Current Streak</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> <?= $model->getStreak() > 0 ? 'Keep going!' : 'Start today!' ?>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Best Streak -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm" style="background-color: orange">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-trophy fa-2x text-success"></i>
                        </div>
                        <h2 class="display-4 fw-bold text-white"><?= $model->getBestStreak() ?></h2>
                        <p class="text-success mb-0">Best Streak</p>
                        <small class="text-success">
                            <i class="fas fa-star"></i> Personal record
                        </small>
                    </div>
                </div>
            </div>

            <!-- Completion Rate -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm" style="background-color: orange">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-calendar-check fa-2x text-success"></i>
                        </div>
                        <h2 class="display-4 fw-bold text-white"><?= count($model->habitCompletions) ?></h2>
                        <p class="text-success mb-0">Days Completed</p>
                        <small class="text-success">
                            <?= $model->getSuccessRate() ?>% success rate
                        </small>
                    </div>
                </div>
            </div>

            <!-- Next Due Date -->
            <div class="col-md-3">
                <div class="card h-100 border-0 bg-gradient shadow-sm" style="background-color: orange">
                    <div class="card-body text-center text-white">
                        <div class="mb-3">
                            <i class="fas fa-bell fa-2x text-success"></i>
                        </div>
                        <h2 class="display-4 text-white fw-bold">
                            <i class="far fa-calendar-alt"></i> <?= $model->dueDate() ?>
                        </h2>
                        <p class="text-success mb-0">Due date</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
