<?php

namespace frontend\controllers;

use common\models\Badge;
use common\models\BadgeUtilizador;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * BadgeController implements the CRUD actions for Badge model.
 */
class BadgeController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $earnedBadges = BadgeUtilizador::find()->where(['fk_utilizador' => Yii::$app->user->id])->select('fk_badge')->column();
        
        $dataProvider = new ActiveDataProvider([
            'query' => Badge::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'earnedBadges' => $earnedBadges
        ]);
    }

    public function actionView($badge_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($badge_id),
        ]);
    }

    protected function findModel($badge_id)
    {
        if (($model = Badge::findOne(['badge_id' => $badge_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
