<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "badge_utilizador".
 *
 * @property int $fk_utilizador
 * @property int $fk_badge
 */
class BadgeUtilizador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'badge_utilizador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_utilizador', 'fk_badge'], 'required'],
            [['fk_utilizador', 'fk_badge'], 'integer'],
            [['fk_utilizador', 'fk_badge'], 'unique', 'targetAttribute' => ['fk_utilizador', 'fk_badge']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fk_utilizador' => 'Fk Utilizador',
            'fk_badge' => 'Fk Badge',
        ];
    }

}
