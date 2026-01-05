<?php
use frontend\models\Habit;
use frontend\models\HabitCompletion;
use common\models\BadgeUtilizador;

$this->title = 'Dashboard OnFire';
$this->params['breadcrumbs'] = [['label' => $this->title]];

$totalHabits = Habit::find()->count();
$totalCompletions = HabitCompletion::find()->count();
$totalBadgesEarned = BadgeUtilizador::find()->count();
$activeHabits = Habit::find()->where(['<=', 'created_at', date('Y-m-d')])->andWhere(['OR', ['final_date' => null], ['>=', 'final_date', date('Y-m-d')]])->count();
?>
<div class="container-fluid">
    <!-- Statistics Row -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Total Users',
                'number' => \common\models\User::find()->count(),
                'icon' => 'fa fa-users'
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Categories',
                'number' => \common\models\Category::find()->count(),
                'icon' => 'fa fa-list-alt'
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Total Habits',
                'number' => $totalHabits,
                'icon' => 'fa fa-check-circle'
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Active Habits',
                'number' => $activeHabits,
                'icon' => 'fa fa-play-circle'
            ]) ?>
        </div>
    </div>

    <!-- Second Statistics Row -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Total Completions',
                'number' => $totalCompletions,
                'icon' => 'fa fa-star'
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Badges Available',
                'number' => \common\models\Badge::find()->count(),
                'icon' => 'fa fa-trophy'
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Badges Earned',
                'number' => $totalBadgesEarned,
                'icon' => 'fa fa-medal'
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Weekly Challenges',
                'number' => \common\models\WeeklyChallenge::find()->count(),
                'icon' => 'fa fa-calendar'
            ]) ?>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Habit Completions</h3>
                </div>
                <div class="card-body">
                    <?php $recentCompletions = HabitCompletion::find()->orderBy(['date' => SORT_DESC])->limit(5)->all(); ?>
                    <?php if (!empty($recentCompletions)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($recentCompletions as $completion): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <strong><?= $completion->fkHabit->name ?? 'Unknown Habit' ?></strong><br>
                                        <small class="text-muted"><?= date('d/m/Y', strtotime($completion->date)) ?></small>
                                    </span>
                                    <span class="badge bg-success text-white px-3 py-2 rounded">Done</span>                                
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">No recent completions found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories Overview</h3>
                </div>
                <div class="card-body">
                    <?php $categories = \common\models\Category::find()->limit(5)->all(); ?>
                    <?php if (!empty($categories)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($categories as $category): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="col-8">
                                        <span class="badge px-3 py-2 rounded w-100 text-center" style="background-color: <?= $category->color ?>; color: <?= $category->getOppositeColor() ?>">
                                            <?= $category->name ?>
                                        </span>
                                    </span>
                                    <span class="badge bg-primary text-white px-3 py-2 rounded col-4 text-center"><?= count($category->habits) ?> habits</span>  
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">No categories found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>