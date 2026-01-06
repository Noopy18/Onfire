<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;

/**
 * This is the model class for table "weekly_challenge".
 *
 * @property int $weekly_challenge_id
 * @property string $name
 * @property string|null $description
 * @property string $start_date
 * @property int $status
 *
 * @property WeeklyChallengeUtilizador[] $weeklyChallengeUtilizadors
 */
class WeeklyChallenge extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weekly_challenge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['name', 'start_date', 'status'], 'required'],
            [['start_date'], 'safe'],
            [['status'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'weekly_challenge_id' => 'Weekly Challenge ID',
            'name' => 'Name',
            'description' => 'Description',
            'start_date' => 'Start Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[WeeklyChallengeUtilizadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWeeklyChallengeUtilizadors()
    {
        return $this->hasMany(WeeklyChallengeUtilizador::class, ['fk_weekly_challenge' => 'weekly_challenge_id']);
    }

    //verifica se o desafio semanal ja foi completado pelo user
    public function isCompletedByUser($userId = null)
    {
        if ($userId === null) {
            $userId = Yii::$app->user->id;
        }

        return WeeklyChallengeUtilizador::find()
        ->innerJoinWith('weeklyChallengeCompletions')
        ->where([
            'weekly_challenge_utilizador.fk_weekly_challenge' => $this->weekly_challenge_id,
            'weekly_challenge_utilizador.fk_utilizador' => $userId,
            'weekly_challenge_completion.completed' => 1,
        ])
        ->exists();
    }

    public function getEndDate(): \DateTime
    {
        return (new \DateTime($this->start_date))
            ->setTime(23, 59, 59)
            ->modify('+6 days');
    }

    
    public function isExpired(): bool
    {
        return new \DateTime() > $this->getEndDate();
    }

    // Dias restantes
    public function getDaysLeft(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        $now = new \DateTime();
        $endDate = $this->getEndDate(); 

        return (int)$now->diff($endDate)->format('%a');
    }

    
    public function getTimeLeftLabel(): array
    {
        if ($this->isExpired()) {
            return [
                'label' => 'Expirado',
                'class' => 'badge bg-secondary'
            ];
        }

        if ($this->getDaysLeft() === 0) {
            return [
                'label' => 'Último dia!',
                'class' => 'badge bg-danger'
            ];
        }

        return [
            'label' => $this->getDaysLeft() . ' dias restantes',
            'class' => 'badge bg-info'
        ];
    }

    
    public function isActive(): bool
    {
        return !$this->isExpired() && $this->status == 1;
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $id = $this->weekly_challenge_id;
        $name = $this->name;
        $description = $this->description;
        $start_date = $this->start_date;
        $status = $this->status;
        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->name = $name;
        $myObj->description = $description;
        $myObj->start_date = $start_date;
        $myObj->status = $status;
        $myJSON = json_encode($myObj);
        if($insert){
            $this->FazPublishNoMosquitto("WeeklyChallenge-INSERT", $myJSON);
        } else {
            $this->FazPublishNoMosquitto("WeeklyChallenge-UPDATE", $myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $weekly_challenge_id = $this->weekly_challenge_id;
        $myObj = new \stdClass();
        $myObj->id = $weekly_challenge_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("WeeklyChallenge-DELETE", $myJSON);
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
