<?php

namespace frontend\models;

use common\models\BadgeUtilizador;
use common\models\Badge;
use Yii;
use common\mosquitto\phpMQTT;

/**
 * This is the model class for table "habit_completion".
 *
 * @property int $habit_completion_id
 * @property string $date
 * @property int $completed
 * @property int $fk_habit
 *
 * @property Habit $fkHabit
 */
class HabitCompletion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'habit_completion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'completed', 'fk_habit'], 'required'],
            [['date'], 'safe'],
            [['completed', 'fk_habit'], 'integer'],
            [['fk_habit'], 'exist', 'skipOnError' => true, 'targetClass' => Habit::class, 'targetAttribute' => ['fk_habit' => 'habit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'habit_completion_id' => 'Habit Completion ID',
            'date' => 'Date',
            'completed' => 'Completed',
            'fk_habit' => 'Fk Habit',
        ];
    }

    /**
     * Gets query for [[FkHabit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkHabit()
    {
        return $this->hasOne(Habit::class, ['habit_id' => 'fk_habit']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if ($insert){
            $habit = $this->fkHabit;
            if ($habit){
                $earnedBadges = Badge::checkBadges($habit->fk_utilizador);
                if (!$earnedBadges) { return; }
                foreach ($earnedBadges as $badge){
                    $bu = new BadgeUtilizador();
                    $bu->fk_utilizador = $habit->fk_utilizador;
                    $bu->fk_badge = $badge->badge_id;
                    $bu->save();
                }
            }
        }

        $id = $this->habit_completion_id;
        $date = $this->date;
        $completed = $this->completed;
        $fk_habit = $this->fk_habit;
        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->date = $date;
        $myObj->completed = $completed;
        $myObj->fk_habit = $fk_habit;
        $myJSON = json_encode($myObj);
        if($insert){
            $this->FazPublishNoMosquitto("HabitCompletion-INSERT", $myJSON);
        } else {
            $this->FazPublishNoMosquitto("HabitCompletion-UPDATE", $myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $habit_completion_id = $this->habit_completion_id;
        $myObj = new \stdClass();
        $myObj->id = $habit_completion_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("HabitCompletion-DELETE", $myJSON);
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
