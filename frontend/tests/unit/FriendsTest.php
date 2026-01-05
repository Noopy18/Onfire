<?php


namespace frontend\tests\Unit;

use frontend\tests\UnitTester;
use frontend\models\Friends;
use common\models\Utilizador;
use common\models\User;

class FriendsTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $friend = new Friends();

        // Teste 'sender'.
        $friend->sender = 1;
        $this->assertTrue($friend->validate(['sender']));
        $friend->sender = "invalid";
        $this->assertFalse($friend->validate(['sender']));
        $friend->sender = null;
        $this->assertFalse($friend->validate(['sender']));

        // Teste 'receiver'.
        $friend->receiver = 1;
        $this->assertTrue($friend->validate(['receiver']));
        $friend->receiver = "invalid";
        $this->assertFalse($friend->validate(['receiver']));
        $friend->receiver = null;
        $this->assertFalse($friend->validate(['receiver']));

        // Teste 'status'.
        $friend->status = 'pendente';
        $this->assertTrue($friend->validate(['status']));
        $friend->status = 'invalid';
        $this->assertFalse($friend->validate(['status']));
        $friend->status = null;
        $this->assertFalse($friend->validate(['status']));

        // Criação de dois utilizador para teste.
        $user1 = new User();
        $user1->username = 'testuser1';
        $user1->email = 'test1@example.com';
        $user1->setPassword('password');
        $user1->generateAuthKey();
        $user1->save();

        $utilizador1 = new Utilizador();
        $utilizador1->name = 'Test User 1';
        $utilizador1->fk_user = $user1->id;
        $utilizador1->save();

        $user2 = new User();
        $user2->username = 'testuser2';
        $user2->email = 'test2@example.com';
        $user2->setPassword('password');
        $user2->generateAuthKey();
        $user2->save();

        $utilizador2 = new Utilizador();
        $utilizador2->name = 'Test User 2';
        $utilizador2->fk_user = $user2->id;
        $utilizador2->save();

        // Criação.
        $friend->sender = $utilizador1->utilizador_id;
        $friend->receiver = $utilizador2->utilizador_id;
        $friend->status = 'pendente';
        $this->assertTrue($friend->validate());
        $this->assertTrue($friend->save());
        
        // Visualização.
        $createdFriend = Friends::findOne(['sender' => $utilizador1->utilizador_id, 'receiver' => $utilizador2->utilizador_id]);
        $this->assertNotNull($createdFriend);

        // Atualização.
        $friend->status = 'aceite';
        $this->assertTrue($friend->save());
        $createdFriend = Friends::findOne(['sender' => $utilizador1->utilizador_id, 'receiver' => $utilizador2->utilizador_id]);
        $this->assertEquals('aceite', $createdFriend->status);

        // Eliminação.
        $friend->delete();
        $deletedFriend = Friends::findOne(['sender' => $utilizador1->utilizador_id, 'receiver' => $utilizador2->utilizador_id]);
        $this->assertNull($deletedFriend);
    }
}
