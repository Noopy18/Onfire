<?php

namespace common\models;

use Yii;
use common\models\WeeklyChallengeCompletion;
use common\mosquitto\phpMQTT;

/**
 * This is the model class for table "weekly_challenge_utilizador".
 *
 * @property int $weekly_challenge_utilizador_id
 * @property int $fk_utilizador
 * @property int $fk_weekly_challenge
 *
 * @property Utilizador $fkUtilizador
 * @property WeeklyChallenge $fkWeeklyChallenge
 * @property WeeklyChallengeCompletion[] $weeklyChallengeCompletions
 */
class WeeklyChallengeUtilizador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weekly_challenge_utilizador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_utilizador', 'fk_weekly_challenge'], 'required'],
            [['fk_utilizador', 'fk_weekly_challenge'], 'integer'],
            [['fk_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::class, 'targetAttribute' => ['fk_utilizador' => 'utilizador_id']],
            [['fk_weekly_challenge'], 'exist', 'skipOnError' => true, 'targetClass' => WeeklyChallenge::class, 'targetAttribute' => ['fk_weekly_challenge' => 'weekly_challenge_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'weekly_challenge_utilizador_id' => 'Weekly Challenge Utilizador ID',
            'fk_utilizador' => 'Fk Utilizador',
            'fk_weekly_challenge' => 'Fk Weekly Challenge',
        ];
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
     * Gets query for [[FkWeeklyChallenge]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkWeeklyChallenge()
    {
        return $this->hasOne(WeeklyChallenge::class, ['weekly_challenge_id' => 'fk_weekly_challenge']);
    }

    /**
     * Gets query for [[WeeklyChallengeCompletions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWeeklyChallengeCompletions()
    {
        return $this->hasMany(WeeklyChallengeCompletion::class, ['fk_weekly_challenge_utilizador' => 'weekly_challenge_utilizador_id']);
    }

    public function isCompleted()
    {
        return WeeklyChallengeCompletion::find()
            ->where([
                'fk_weekly_challenge_utilizador' => $this->weekly_challenge_utilizador_id,
                'completed' => 1,
            ])
            ->exists();
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $id = $this->weekly_challenge_utilizador_id;
        $fk_utilizador = $this->fk_utilizador;
        $fk_weekly_challenge = $this->fk_weekly_challenge;
        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->fk_utilizador = $fk_utilizador;
        $myObj->fk_weekly_challenge = $fk_weekly_challenge;
        $myJSON = json_encode($myObj);
        if($insert){
            $this->FazPublishNoMosquitto("WeeklyChallengeUtilizador-INSERT", $myJSON);
        } else {
            $this->FazPublishNoMosquitto("WeeklyChallengeUtilizador-UPDATE", $myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $weekly_challenge_utilizador_id = $this->weekly_challenge_utilizador_id;
        $myObj = new \stdClass();
        $myObj->id = $weekly_challenge_utilizador_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("WeeklyChallengeUtilizador-DELETE", $myJSON);
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
