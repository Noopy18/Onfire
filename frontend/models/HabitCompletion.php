<?php

namespace frontend\models;

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

}
