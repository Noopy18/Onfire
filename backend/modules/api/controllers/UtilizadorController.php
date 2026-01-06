<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class UtilizadorController extends ActiveController
{
    public $modelClass = 'common\models\Utilizador';

    function actionBadges($id) {
        $utilizador = new $this->modelClass;
        $utilizador = $utilizador::find()->where(['utilizador_id' => $id])->one();
        return $utilizador->getBadges()->all();
    }

    function actionHabits($id) {
        $utilizador = new $this->modelClass;
        $utilizador = $utilizador::find()->where(['utilizador_id' => $id])->one();
        return $utilizador->getHabits()->all();
    }

    public function actionLinkbadge($id, $badge_id) {
        $utilizador = new $this->modelClass;
        $utilizador = $utilizador::find()->where(['utilizador_id' => $id])->one();

        $badge = \common\models\Badge::find()->where(['badge_id' => $badge_id])->one();

        $badgeUtilizador = new \common\models\BadgeUtilizador();
        $badgeUtilizador->fk_utilizador = $utilizador->utilizador_id;
        $badgeUtilizador->fk_badge = $badge->badge_id;
        $badgeUtilizador->save();

        return $badgeUtilizador;
    }
}

