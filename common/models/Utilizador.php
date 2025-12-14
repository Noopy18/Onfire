<?php

namespace common\models;

use common\models\User;
use frontend\models\Friends;
use frontend\models\Habit;
use Yii;

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
            [['profile_picture'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 150],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    public function getHabits()
    {
        return $this->hasMany(Habit::class, ['fk_utilizador' => 'utilizador_id']);
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
            'fk_user' => 'Fk User',
        ];
    }

    public function friendshipWith($id){
        $friends = new Friends();
        return $friends->findFriendship($id);
    }

}
