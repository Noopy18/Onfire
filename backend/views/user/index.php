<?php

use common\models\user;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="container">

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <?= Html::a('Criar Utilizador', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="row">

            <table class="table table-bordered table-hover table-striped dataTable dtr-inline">
                <thead>
                    <tr>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="descending">#</th>
                        <th class="sorting" tabindex="0">Primeiro</th>
                        <th class="sorting" tabindex="0">Último</th>
                        <th class="sorting" tabindex="0">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>

    <p>
        <?= Html::a('Criar Utilizador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'status',
            'created_at',
            //'updated_at',
            //'verification_token',
            [
                'class' => ActionColumn::className(),
                'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fas fa-sign-out-alt" hidden></i>', ['/site/logout'], ['data-method' => 'post']);
                        }
                ],
            ],
        ],
    ]); ?>


</div>
