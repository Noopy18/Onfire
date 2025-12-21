<?php

namespace frontend\models;

use common\models\BadgeUtilizador;
use common\models\Badge;
use Yii;

/**
 * This is the model class for table "habit_completion".
 *
 * @property int $habit_completion_id
 * @property string $date
 * @property int $completed
 * @property int $fk_habit
 *
 * @property Habit $fkHabit
 */
class HabitCompletion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'habit_completion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'completed', 'fk_habit'], 'required'],
            [['date'], 'safe'],
            [['completed', 'fk_habit'], 'integer'],
            [['fk_habit'], 'exist', 'skipOnError' => true, 'targetClass' => Habit::class, 'targetAttribute' => ['fk_habit' => 'habit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'habit_completion_id' => 'Habit Completion ID',
            'date' => 'Date',
            'completed' => 'Completed',
            'fk_habit' => 'Fk Habit',
        ];
    }

    /**
     * Gets query for [[FkHabit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkHabit()
    {
        return $this->hasOne(Habit::class, ['habit_id' => 'fk_habit']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if ($insert){
            $habit = $this->fkHabit;
            if ($habit){
                $earnedBadges = Badge::checkBadges($habit->fk_utilizador);
                if (!$earnedBadges) { return; }
                foreach ($earnedBadges as $badge){
                    $bu = new BadgeUtilizador();
                    $bu->fk_utilizador = $habit->fk_utilizador;
                    $bu->fk_badge = $badge->badge_id;
                    $bu->save();
                }
            }
        }
    }

}
