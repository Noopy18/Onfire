<?php

namespace common\models;

use common\models\User;
use frontend\models\Friends;
use frontend\models\Habit;
use Yii;
use common\mosquitto\phpMQTT;

/**
 * This is the model class for table "Utilizador".
 *
 * @property int $utilizador_id
 * @property string|null $profile_picture
 * @property string $name
 * @property int|null $fk_user
 */
class Utilizador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Utilizador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_picture', 'fk_user'], 'default', 'value' => null],
            [['name'], 'required'],
            [['fk_user'], 'integer'],
            [['private_profile'], 'boolean'],
            [['profile_picture'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 150],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    public function getHabits()
    {
        return $this->hasMany(Habit::class, ['fk_utilizador' => 'utilizador_id']);
    }

    public function getBadges()
    {
        return $this->hasMany(BadgeUtilizador::class, ['fk_utilizador' => 'utilizador_id']);
    }

    public function getWeeklyChallenges()
    {
        return $this->hasMany(WeeklyChallengeUtilizador::class, ['fk_utilizador' => 'utilizador_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'utilizador_id' => 'Utilizador ID',
            'profile_picture' => 'Profile Picture',
            'name' => 'Name',
            'private_profile' => 'Perfil Privado',
            'fk_user' => 'Fk User',
        ];
    }

    public function friendshipWith($id){
        $friends = new Friends();
        return $friends->findFriendship($id);
    }

    public function getProfilePictureUrl(){
        if ($this->profile_picture){
            return Yii::getAlias('@web') . '/' . $this->profile_picture;
        } 

        return Yii::getAlias('@web') . '/uploads/profile/avatar.png';
    }

    public function isPrivateProfile(){
        return (bool) $this->private_profile;
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $id = $this->utilizador_id;
        $name = $this->name;
        $profile_picture = $this->profile_picture;
        $fk_user = $this->fk_user;
        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->name = $name;
        $myObj->profile_picture = $profile_picture;
        $myObj->fk_user = $fk_user;
        $myJSON = json_encode($myObj);
        if($insert){$this->FazPublishNoMosquitto("Utilizador-INSERT",$myJSON);}
        else{$this->FazPublishNoMosquitto("Utilizador-UPDATE",$myJSON);}
    }

    public function afterDelete(){
        parent::afterDelete();
        $utilizador_id = $this->utilizador_id;
        $myObj = new \stdClass();
        $myObj->id = $utilizador_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("Utilizador-DELETE",$myJSON);
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
