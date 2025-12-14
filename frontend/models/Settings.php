<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $settings_id
 * @property string $time_format
 * @property int $dark_theme
 * @property int $private_perfil
 * @property int $fk_utilizador_id
 *
 * @property Utilizador $fkUtilizador
 */
class Settings extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TIME_FORMAT_12H = '12h';
    const TIME_FORMAT_24H = '24h';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_format'], 'default', 'value' => '24h'],
            [['private_perfil'], 'default', 'value' => 0],
            [['time_format'], 'string'],
            [['dark_theme', 'fk_utilizador_id'], 'required'],
            [['dark_theme', 'private_perfil', 'fk_utilizador_id'], 'integer'],
            ['time_format', 'in', 'range' => array_keys(self::optsTimeFormat())],
            [['fk_utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::class, 'targetAttribute' => ['fk_utilizador_id' => 'utilizador_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'settings_id' => 'Settings ID',
            'time_format' => 'Time Format',
            'dark_theme' => 'Dark Theme',
            'private_perfil' => 'Private Perfil',
            'fk_utilizador_id' => 'Fk Utilizador ID',
        ];
    }

    /**
     * Gets query for [[FkUtilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkUtilizador()
    {
        return $this->hasOne(Utilizador::class, ['utilizador_id' => 'fk_utilizador_id']);
    }


    /**
     * column time_format ENUM value labels
     * @return string[]
     */
    public static function optsTimeFormat()
    {
        return [
            self::TIME_FORMAT_12H => '12h',
            self::TIME_FORMAT_24H => '24h',
        ];
    }

    /**
     * @return string
     */
    public function displayTimeFormat()
    {
        return self::optsTimeFormat()[$this->time_format];
    }

    /**
     * @return bool
     */
    public function isTimeFormat12h()
    {
        return $this->time_format === self::TIME_FORMAT_12H;
    }

    public function setTimeFormatTo12h()
    {
        $this->time_format = self::TIME_FORMAT_12H;
    }

    /**
     * @return bool
     */
    public function isTimeFormat24h()
    {
        return $this->time_format === self::TIME_FORMAT_24H;
    }

    public function setTimeFormatTo24h()
    {
        $this->time_format = self::TIME_FORMAT_24H;
    }
}
