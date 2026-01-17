<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class MatematicaController extends ActiveController{
    
    public $modelClass = 'common\models\Badge';

    function actionRaizdois(){ return ['raizdois' => 1.41]; }
}

