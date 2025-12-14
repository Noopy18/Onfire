<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "weekly_challenge_utilizador".
 *
 * @property int $weekly_challenge_utilizador_id
 * @property int $fk_utilizador
 * @property int $fk_weekly_challenge
 *
 * @property Utilizador $fkUtilizador
 * @property WeeklyChallenge $fkWeeklyChallenge
 * @property WeeklyChallengeCompletion[] $weeklyChallengeCompletions
 */
class WeeklyChallengeUtilizador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weekly_challenge_utilizador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_utilizador', 'fk_weekly_challenge'], 'required'],
            [['fk_utilizador', 'fk_weekly_challenge'], 'integer'],
            [['fk_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::class, 'targetAttribute' => ['fk_utilizador' => 'utilizador_id']],
            [['fk_weekly_challenge'], 'exist', 'skipOnError' => true, 'targetClass' => WeeklyChallenge::class, 'targetAttribute' => ['fk_weekly_challenge' => 'weekly_challenge_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'weekly_challenge_utilizador_id' => 'Weekly Challenge Utilizador ID',
            'fk_utilizador' => 'Fk Utilizador',
            'fk_weekly_challenge' => 'Fk Weekly Challenge',
        ];
    }

    /**
     * Gets query for [[FkUtilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkUtilizador()
    {
        return $this->hasOne(Utilizador::class, ['utilizador_id' => 'fk_utilizador']);
    }

    /**
     * Gets query for [[FkWeeklyChallenge]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkWeeklyChallenge()
    {
        return $this->hasOne(WeeklyChallenge::class, ['weekly_challenge_id' => 'fk_weekly_challenge']);
    }

    /**
     * Gets query for [[WeeklyChallengeCompletions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWeeklyChallengeCompletions()
    {
        return $this->hasMany(WeeklyChallengeCompletion::class, ['fk_weekly_challenge_utilizador' => 'weekly_challenge_utilizador_id']);
    }

    public function isCompleted()
    {
        return WeeklyChallengeCompletion::find()
            ->where([
                'fk_weekly_challenge_utilizador' => $this->weekly_challenge_utilizador_id,
                'completed' => 1,
            ])
            ->exists();
    }

}
