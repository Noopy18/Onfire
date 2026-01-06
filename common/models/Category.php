<?php

namespace common\models;

use frontend\models\Habit;
use Yii;
use common\mosquitto\phpMQTT;

/**
 * This is the model class for table "category".
 *
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string $color
 *
 * @property Habit[] $habits
 */
class Category extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['color'], 'default', 'value' => '#000000'],
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'name' => 'Name',
            'description' => 'Description',
            'color' => 'Color',
        ];
    }

    /**
     * Gets query for [[Habits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabits()
    {
        return $this->hasMany(Habit::class, ['fk_category' => 'category_id']);
    }

    public function getOppositeColor(){
        $color = list($r, $g, $b) = sscanf($this->color, "#%02x%02x%02x");

        $check_light = $color[1] + $color[1] +$color[1] / 1000;
        //#000000 = White | #FFFFFF = Black | se o RGB a dividir por 1000 é menor de 250, cor é escura.
        return $check_light > 250 ? '#000000' : '#FFFFFF';
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        //Obter dados do registo em causa
        $id=$this->category_id;
        $name=$this->name;
        $description=$this->description;
        $color=$this->color;
        $myObj=new \stdClass();
        $myObj->id=$id;
        $myObj->name=$name;
        $myObj->description=$description;
        $myObj->color=$color;
        $myJSON = json_encode($myObj);
        if($insert){$this->FazPublishNoMosquitto("Category-INSERT",$myJSON);}
        else{$this->FazPublishNoMosquitto("Category-UPDATE",$myJSON);}
    }

    public function afterDelete(){
        parent::afterDelete();
        $category_id= $this->category_id;
        $myObj=new \stdClass();
        $myObj->id=$category_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("Category-DELETE",$myJSON);
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
