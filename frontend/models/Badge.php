<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "badge".
 *
 * @property int $badge_id
 * @property string $name
 * @property string $description
 * @property string $image
 *
 * @property BadgeUtilizador[] $badgeUtilizadors
 * @property Utilizador[] $fkUtilizadors
 */
class Badge extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'badge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'image'], 'required'],
            [['name', 'description', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'badge_id' => 'Badge ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[BadgeUtilizadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBadgeUtilizadors()
    {
        return $this->hasMany(BadgeUtilizador::class, ['fk_badge' => 'badge_id']);
    }

    /**
     * Gets query for [[FkUtilizadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkUtilizadors()
    {
        return $this->hasMany(Utilizador::class, ['utilizador_id' => 'fk_utilizador'])->viaTable('badge_utilizador', ['fk_badge' => 'badge_id']);
    }

}
