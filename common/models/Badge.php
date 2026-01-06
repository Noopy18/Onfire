<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;

/**
 * This is the model class for table "Badge".
 *
 * @property int $badge_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $condition_type
 * @property int $condition_value
 */
class Badge extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const CONDITION_TYPE_STREAK = 'streak';
    const CONDITION_TYPE_HABIT_COMPLETIONS = 'habit_completions';
    const CONDITION_TYPE_HABITS_COMPLETED = 'habits_completed';
    const CONDITION_TYPE_WC_COMPLETIONS = 'wc_completions';
    const CONDITION_TYPE_WC_COMPLETED = 'wc_completed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Badge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'condition_type', 'condition_value'], 'required'],
            [['image'], 'safe'],
            [['condition_type'], 'string'],
            [['condition_value'], 'integer'],
            [['name', 'description', 'image'], 'string', 'max' => 255],
            ['condition_type', 'in', 'range' => array_keys(self::optsConditionType())],
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
            'condition_type' => 'Condition Type',
            'condition_value' => 'Condition Value',
        ];
    }


    /**
     * column condition_type ENUM value labels
     * @return string[]
     */
    public static function optsConditionType()
    {
        return [
            self::CONDITION_TYPE_STREAK => 'Streak',
            self::CONDITION_TYPE_HABIT_COMPLETIONS => 'Habit Completions',
            self::CONDITION_TYPE_HABITS_COMPLETED => 'Habits Completed',
            self::CONDITION_TYPE_WC_COMPLETIONS => 'Weekly Habits Completions',
            self::CONDITION_TYPE_WC_COMPLETED => 'Weekly Habits Completed',
        ];
    }

    /**
     * @return string
     */
    public function displayConditionType()
    {
        return self::optsConditionType()[$this->condition_type];
    }

    /**
     * @return bool
     */
    public function isConditionTypeStreak()
    {
        return $this->condition_type === self::CONDITION_TYPE_STREAK;
    }

    public function setConditionTypeToStreak()
    {
        $this->condition_type = self::CONDITION_TYPE_STREAK;
    }

    /**
     * @return bool
     */
    public function isConditionTypeHabitcompletions()
    {
        return $this->condition_type === self::CONDITION_TYPE_HABIT_COMPLETIONS;
    }

    public function setConditionTypeToHabitcompletions()
    {
        $this->condition_type = self::CONDITION_TYPE_HABIT_COMPLETIONS;
    }

    /**
     * @return bool
     */
    public function isConditionTypeHabitscompleted()
    {
        return $this->condition_type === self::CONDITION_TYPE_HABITS_COMPLETED;
    }

    public function setConditionTypeToHabitscompleted()
    {
        $this->condition_type = self::CONDITION_TYPE_HABITS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isConditionTypeWccompletions()
    {
        return $this->condition_type === self::CONDITION_TYPE_WC_COMPLETIONS;
    }

    public function setConditionTypeToWccompletions()
    {
        $this->condition_type = self::CONDITION_TYPE_WC_COMPLETIONS;
    }

    /**
     * @return bool
     */
    public function isConditionTypeWccompleted()
    {
        return $this->condition_type === self::CONDITION_TYPE_WC_COMPLETED;
    }

    public function setConditionTypeToWccompleted()
    {
        $this->condition_type = self::CONDITION_TYPE_WC_COMPLETED;
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

    public static function checkBadges($user_id){

        $badges = self::find()->all();
        $userBadges = BadgeUtilizador::find()->where(['fk_utilizador' => $user_id])->select('fk_badge')->column();
        $utilizador = Utilizador::find()->where(['utilizador_id' => $user_id])->one();

        $badge_array = [];

        foreach ($badges as $badge){
            if (in_array($badge->badge_id, $userBadges)) { continue; }

            switch ($badge->condition_type) {
                case self::CONDITION_TYPE_STREAK:
                    if ($utilizador == null) { break; }
                    foreach ($utilizador->habits as $habit) {
                        if ($habit->getBestStreak() >= $badge->condition_value) {
                            $badge_array[] = $badge;
                            break;
                        }
                    }
                case self::CONDITION_TYPE_HABIT_COMPLETIONS:
                    $hc = 0;
                    foreach ( $utilizador->habits as $habit ){
                        foreach ($habit->habitCompletions as $h){
                            $hc++;
                        }
                    }

                    if ($hc >= $badge->condition_value){
                        $badge_array[] = $badge;
                    }
                case self::CONDITION_TYPE_HABITS_COMPLETED:
                    $hc = 0;
                    foreach ( $utilizador->habits as $habit ){
                        if ($habit->isFinished()){$hc++;}
                    }

                    if ($hc >= $badge->condition_value){
                        $badge_array[] = $badge;
                    }
                case self::CONDITION_TYPE_WC_COMPLETIONS:
                    $weekly_challenges_utilizador = WeeklyChallengeUtilizador::find()->where(['fk_utilizador' => $user_id])->all();
                    $wc_completions = 0;
                    
                    foreach ( $weekly_challenges_utilizador as $wcu ){
                        foreach ($wcu->weeklyChallengeCompletions as $wcc){
                            $wc_completions++;
                        }
                    }

                    if ($wc_completions >= $badge->condition_value){
                        $badge_array[] = $badge;
                    }
                case self::CONDITION_TYPE_WC_COMPLETED:
                    $weekly_challenges_utilizador = WeeklyChallengeUtilizador::find()->where(['fk_utilizador' => $user_id])->all();
                    $wc_completed = 0;
                    
                    foreach ( $weekly_challenges_utilizador as $wcu ){
                        if ($wcu->fkWeeklyChallenge->isExpired()){$wc_completed++;}
                    }

                    if ($wc_completed >= $badge->condition_value){
                        $badge_array[] = $badge;
                    }
            }

        }
    
        return count($badge_array) > 0 ? $badge_array : null;
    }
    
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        //Obter dados do registo em causa
        $id=$this->badge_id;
        $name=$this->name;
        $description=$this->description;
        $image=$this->image;
        $myObj=new \stdClass();
        $myObj->id=$id;
        $myObj->name=$name;
        $myObj->description=$description;
        $myObj->image=$image;
        $myJSON = json_encode($myObj);
        if($insert){
            $this->FazPublishNoMosquitto("Badge-INSERT",$myJSON);
        } else {
            $this->FazPublishNoMosquitto("Badge-UPDATE",$myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $badge_id= $this->badge_id;
        $myObj=new \stdClass();
        $myObj->id=$badge_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("Badge-DELETE",$myJSON);
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
