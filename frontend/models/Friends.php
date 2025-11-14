<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property int $sender
 * @property int $receiver
 * @property string $status
 *
 * @property Utilizador $receiver0
 * @property Utilizador $sender0
 */
class Friends extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_REJEITADO = 'rejeitado';
    const STATUS_ACEITE = 'aceite';
    const STATUS_PENDENTE = 'pendente';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender', 'receiver', 'status'], 'required'],
            [['sender', 'receiver'], 'integer'],
            [['status'], 'string'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['sender', 'receiver'], 'unique', 'targetAttribute' => ['sender', 'receiver']],
            [['sender'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::class, 'targetAttribute' => ['sender' => 'utilizador_id']],
            [['receiver'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::class, 'targetAttribute' => ['receiver' => 'utilizador_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sender' => 'Sender',
            'receiver' => 'Receiver',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Receiver0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver0()
    {
        return $this->hasOne(Utilizador::class, ['utilizador_id' => 'receiver']);
    }

    /**
     * Gets query for [[Sender0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender0()
    {
        return $this->hasOne(Utilizador::class, ['utilizador_id' => 'sender']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_REJEITADO => 'rejeitado',
            self::STATUS_ACEITE => 'aceite',
            self::STATUS_PENDENTE => 'pendente',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusRejeitado()
    {
        return $this->status === self::STATUS_REJEITADO;
    }

    public function setStatusToRejeitado()
    {
        $this->status = self::STATUS_REJEITADO;
    }

    /**
     * @return bool
     */
    public function isStatusAceite()
    {
        return $this->status === self::STATUS_ACEITE;
    }

    public function setStatusToAceite()
    {
        $this->status = self::STATUS_ACEITE;
    }

    /**
     * @return bool
     */
    public function isStatusPendente()
    {
        return $this->status === self::STATUS_PENDENTE;
    }

    public function setStatusToPendente()
    {
        $this->status = self::STATUS_PENDENTE;
    }
}
