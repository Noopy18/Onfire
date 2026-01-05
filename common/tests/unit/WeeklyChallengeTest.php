<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\WeeklyChallenge;

class WeeklyChallengeTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $challenge = new WeeklyChallenge();

        // Teste 'name'.
        $challenge->name = 'Weekly Challenge Name';
        $this->assertTrue($challenge->validate(['name']));
        $challenge->name = str_repeat('a', 300);
        $this->assertFalse($challenge->validate(['name']));
        $challenge->name = null;
        $this->assertFalse($challenge->validate(['name']));

        // Teste 'description'.
        $challenge->description = 'Challenge description.';
        $this->assertTrue($challenge->validate(['description']));
        $challenge->description = str_repeat('a', 300);
        $this->assertFalse($challenge->validate(['description']));
        $challenge->description = null;
        $this->assertTrue($challenge->validate(['description']));

        // Teste 'start_date'.
        $challenge->start_date = date('Y-m-d');
        $this->assertTrue($challenge->validate(['start_date']));
        $challenge->start_date = null;
        $this->assertFalse($challenge->validate(['start_date']));

        // Teste 'status'.
        $challenge->status = 1;
        $this->assertTrue($challenge->validate(['status']));
        $challenge->status = "invalid";
        $this->assertFalse($challenge->validate(['status']));
        $challenge->status = null;
        $this->assertFalse($challenge->validate(['status']));

        // Criação.
        $challenge->name = 'Weekly Challenge Name';
        $challenge->description = 'Challenge description.';
        $challenge->start_date = date('Y-m-d');
        $challenge->status = 1;
        $this->assertTrue($challenge->save());
        
        // Visualização.
        $createdChallenge = WeeklyChallenge::findOne($challenge->weekly_challenge_id);
        $this->assertNotNull($createdChallenge);

        // Atualização.
        $challenge->name = 'Updated Challenge Name';
        $this->assertTrue($challenge->save());
        $createdChallenge = WeeklyChallenge::findOne($challenge->weekly_challenge_id);
        $this->assertEquals('Updated Challenge Name', $createdChallenge->name);

        // Eliminação.
        $challengeId = $challenge->weekly_challenge_id;
        $challenge->delete();
        $deletedChallenge = WeeklyChallenge::findOne($challengeId);
        $this->assertNull($deletedChallenge);
    }
}
