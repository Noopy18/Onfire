<?php

namespace frontend\models;

use common\models\Utilizador;
use Yii;

/**
 * This is the model class for table "habit".
 *
 * @property int $habit_id
 * @property string $name
 * @property string|null $description
 * @property string $frequency
 * @property string|null $final_date
 * @property string $type
 * @property string $created_at
 * @property int $fk_utilizador
 * @property int $fk_category
 *
 * @property Category $fkCategory
 * @property Utilizador $fkUtilizador
 * @property HabitCompletion[] $habitCompletions
 */
class Habit extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_INT = 'int';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'habit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'final_date'], 'default', 'value' => null],
            [['name', 'frequency', 'type', 'created_at', 'fk_utilizador', 'fk_category'], 'required'],
            [['final_date', 'created_at'], 'safe'],
            [['type'], 'string'],
            [['fk_utilizador', 'fk_category'], 'integer'],
            [['name', 'description', 'frequency'], 'string', 'max' => 255],
            ['type', 'in', 'range' => array_keys(self::optsType())],
            [['fk_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::class, 'targetAttribute' => ['fk_utilizador' => 'utilizador_id']],
            [['fk_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['fk_category' => 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'habit_id' => 'Habit ID',
            'name' => 'Name',
            'description' => 'Description',
            'frequency' => 'Frequency',
            'final_date' => 'Final Date',
            'type' => 'Type',
            'created_at' => 'Created At',
            'fk_utilizador' => 'Fk Utilizador',
            'fk_category' => 'Fk Category',
        ];
    }

    /**
     * Gets query for [[FkCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['category_id' => 'fk_category']);
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
     * Gets query for [[HabitCompletions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitCompletions()
    {
        return $this->hasMany(HabitCompletion::class, ['fk_habit' => 'habit_id']);
    }


    /**
     * column type ENUM value labels
     * @return string[]
     */
    public static function optsType()
    {
        return [
            self::TYPE_BOOLEAN => 'boolean',
            self::TYPE_INT => 'int',
        ];
    }

    /**
     * @return string
     */
    public function displayType()
    {
        return self::optsType()[$this->type];
    }

    /**
     * @return bool
     */
    public function isTypeBoolean()
    {
        return $this->type === self::TYPE_BOOLEAN;
    }

    public function setTypeToBoolean()
    {
        $this->type = self::TYPE_BOOLEAN;
    }

    /**
     * @return bool
     */
    public function isTypeInt()
    {
        return $this->type === self::TYPE_INT;
    }

    public function setTypeToInt()
    {
        $this->type = self::TYPE_INT;
    }

    public function getStreak(){
        $creation_date = $this->created_at;
        $today_date = date("Y-m-d");
        $frequency = json_decode($this->frequency, true);
        $hc_array = $this->habitCompletions;

        $streak = 0;
        $break = false;
        while ($creation_date != $today_date and !$break){
            $indexWeekday = date("w", strtotime($today_date))-1;
            if ($indexWeekday < 0){
                $indexWeekday = 6;
            }
            $add = false;
            if ($frequency[$indexWeekday] == 1){
                foreach ($hc_array as $hc){
                    if ($hc->date == $today_date){
                        $add = true;
                    }
                }
                if ($add){
                    $add = false;
                    $streak++;
                } else {
                    break;
                }
            }
            $today_date = date("Y-m-d", strtotime("-1 day", strtotime($today_date)));
        }
        return $streak;
    }
}
