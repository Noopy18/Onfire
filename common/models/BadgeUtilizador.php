<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;

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

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $fk_utilizador = $this->fk_utilizador;
        $fk_badge = $this->fk_badge;
        $myObj = new \stdClass();
        $myObj->fk_utilizador = $fk_utilizador;
        $myObj->fk_badge = $fk_badge;
        $myJSON = json_encode($myObj);
        if($insert){
            $this->FazPublishNoMosquitto("BadgeUtilizador-INSERT", $myJSON);
        } else {
            $this->FazPublishNoMosquitto("BadgeUtilizador-UPDATE", $myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $fk_utilizador = $this->fk_utilizador;
        $fk_badge = $this->fk_badge;
        $myObj = new \stdClass();
        $myObj->fk_utilizador = $fk_utilizador;
        $myObj->fk_badge = $fk_badge;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("BadgeUtilizador-DELETE", $myJSON);
    }

    public function FazPublishNoMosquitto($canal, $msg){
        try {
            $server = "127.0.0.1";
            $port = 1883;

            $username = Yii::$app->user->identity->username;
            $password = Yii::$app->user->identity->password_hash;
            $client_id = Yii::$app->user->identity->id;
            
            $mqtt = new phpMQTT($server, $port, $client_id);
            if ($mqtt->connect(true, NULL, $username, $password)) {
                $mqtt->publish($canal, $msg, 0);
                $mqtt->close();
            } else {
                Yii::error("MQTT conexão falhada para tópico: $canal");
            }
        } catch (\Exception $e) {
            Yii::error("MQTT erro ao publicar: " . $e->getMessage());
        }
    }
}
