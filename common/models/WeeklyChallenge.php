<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "weekly_challenge".
 *
 * @property int $weekly_challenge_id
 * @property string $name
 * @property string|null $description
 * @property string $start_date
 * @property int $status
 *
 * @property WeeklyChallengeUtilizador[] $weeklyChallengeUtilizadors
 */
class WeeklyChallenge extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weekly_challenge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['name', 'start_date', 'status'], 'required'],
            [['start_date'], 'safe'],
            [['status'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'weekly_challenge_id' => 'Weekly Challenge ID',
            'name' => 'Name',
            'description' => 'Description',
            'start_date' => 'Start Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[WeeklyChallengeUtilizadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWeeklyChallengeUtilizadors()
    {
        return $this->hasMany(WeeklyChallengeUtilizador::class, ['fk_weekly_challenge' => 'weekly_challenge_id']);
    }

}
