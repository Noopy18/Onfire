<?php

namespace common\models;

use Yii;
use common\models\FkWeeklyChallengeUtilizador;

/**
 * This is the model class for table "weekly_challenge_completion".
 *
 * @property int $weekly_challenge_completion_id
 * @property string $date
 * @property int $completed
 * @property int $fk_weekly_challenge_utilizador
 *
 * @property WeeklyChallengeUtilizador $fkWeeklyChallengeUtilizador
 */
class WeeklyChallengeCompletion extends \yii\db\ActiveRecord
{

    //campo virtual para guardar o desafio semanal selecionado
    public $fk_weekly_challenge;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weekly_challenge_completion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'completed', 'fk_weekly_challenge_utilizador'], 'required'],
            [['date'], 'safe'],
            [['fk_weekly_challenge'], 'safe'], //atributo virtual para guardar o desafio semanal selecionado
            [['completed', 'fk_weekly_challenge_utilizador'], 'integer'],
            [['fk_weekly_challenge_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => WeeklyChallengeUtilizador::class, 'targetAttribute' => ['fk_weekly_challenge_utilizador' => 'weekly_challenge_utilizador_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'weekly_challenge_completion_id' => 'Weekly Challenge Completion ID',
            'date' => 'Date',
            'completed' => 'Completed',
            'fk_weekly_challenge_utilizador' => 'Fk Weekly Challenge Utilizador',
        ];
    }

    /**
     * Gets query for [[FkWeeklyChallengeUtilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkWeeklyChallengeUtilizador()
    {
        return $this->hasOne(WeeklyChallengeUtilizador::class, ['weekly_challenge_utilizador_id' => 'fk_weekly_challenge_utilizador']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if ($insert){
            $wcu = $this->fkWeeklyChallengeUtilizador;
            if ($wcu){
                $earnedBadges = Badge::checkBadges($wcu->fk_utilizador);
                if (!$earnedBadges) { return; }
                foreach ($earnedBadges as $badge){
                    $bu = new BadgeUtilizador();
                    $bu->fk_utilizador = $wcu->fk_utilizador;
                    $bu->fk_badge = $badge->badge_id;
                    $bu->save();
                }
            }
        }
    }
    
}

