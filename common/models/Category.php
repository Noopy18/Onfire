<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string $color
 *
 * @property Habit[] $habits
 */
class Category extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['color'], 'default', 'value' => '#000000'],
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'name' => 'Name',
            'description' => 'Description',
            'color' => 'Color',
        ];
    }

    /**
     * Gets query for [[Habits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabits()
    {
        return $this->hasMany(Habit::class, ['fk_category' => 'category_id']);
    }

    public function getOppositeColor(){
        $color = list($r, $g, $b) = sscanf($this->color, "#%02x%02x%02x");

        $check_light = $color[1] + $color[1] +$color[1] / 1000;
        //#000000 = White | #FFFFFF = Black | se o RGB a dividir por 1000 é menor de 250, cor é escura.
        return $check_light > 250 ? '#000000' : '#FFFFFF';
    }

}
