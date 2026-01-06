<?php

namespace common\models;

use Yii;
use common\models\FkWeeklyChallengeUtilizador;
use common\mosquitto\phpMQTT;

/**
 * This is the model class for table "weekly_challenge_completion".
 *
 * @property int $weekly_challenge_completion_id
 * @property string $date
 * @property int $completed
 * @property int $fk_weekly_challenge_utilizador
 *
 * @property WeeklyChallengeUtilizador $fkWeeklyChallengeUtilizador
 */
class WeeklyChallengeCompletion extends \yii\db\ActiveRecord
{

    //campo virtual para guardar o desafio semanal selecionado
    public $fk_weekly_challenge;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weekly_challenge_completion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'completed', 'fk_weekly_challenge_utilizador'], 'required'],
            [['date'], 'safe'],
            [['fk_weekly_challenge'], 'safe'], //atributo virtual para guardar o desafio semanal selecionado
            [['completed', 'fk_weekly_challenge_utilizador'], 'integer'],
            [['fk_weekly_challenge_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => WeeklyChallengeUtilizador::class, 'targetAttribute' => ['fk_weekly_challenge_utilizador' => 'weekly_challenge_utilizador_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'weekly_challenge_completion_id' => 'Weekly Challenge Completion ID',
            'date' => 'Date',
            'completed' => 'Completed',
            'fk_weekly_challenge_utilizador' => 'Fk Weekly Challenge Utilizador',
        ];
    }

    /**
     * Gets query for [[FkWeeklyChallengeUtilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkWeeklyChallengeUtilizador()
    {
        return $this->hasOne(WeeklyChallengeUtilizador::class, ['weekly_challenge_utilizador_id' => 'fk_weekly_challenge_utilizador']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if ($insert){
            $wcu = $this->fkWeeklyChallengeUtilizador;
            if ($wcu){
                $earnedBadges = Badge::checkBadges($wcu->fk_utilizador);
                if (!$earnedBadges) { return; }
                foreach ($earnedBadges as $badge){
                    $bu = new BadgeUtilizador();
                    $bu->fk_utilizador = $wcu->fk_utilizador;
                    $bu->fk_badge = $badge->badge_id;
                    $bu->save();
                }
            }
        }
        
        $id = $this->weekly_challenge_completion_id;
        $date = $this->date;
        $completed = $this->completed;
        $fk_weekly_challenge_utilizador = $this->fk_weekly_challenge_utilizador;
        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->date = $date;
        $myObj->completed = $completed;
        $myObj->fk_weekly_challenge_utilizador = $fk_weekly_challenge_utilizador;
        $myJSON = json_encode($myObj);
        if($insert){
            $this->FazPublishNoMosquitto("WeeklyChallengeCompletion-INSERT", $myJSON);
        } else {
            $this->FazPublishNoMosquitto("WeeklyChallengeCompletion-UPDATE", $myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $weekly_challenge_completion_id = $this->weekly_challenge_completion_id;
        $myObj = new \stdClass();
        $myObj->id = $weekly_challenge_completion_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("WeeklyChallengeCompletion-DELETE", $myJSON);
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

