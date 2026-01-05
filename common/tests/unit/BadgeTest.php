<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\Badge;

class BadgeTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    public function testBadge()
    {
        $badge = new Badge();

        // Teste 'name'.
        $badge->name = 'Badge Name';
        $this->assertTrue($badge->validate(['name']));
        $badge->name = str_repeat('a', 300);
        $this->assertFalse($badge->validate(['name']));
        $badge->name = null;
        $this->assertFalse($badge->validate(['name']));

        // Teste 'description'.
        $badge->description = 'Badge description.';
        $this->assertTrue($badge->validate(['description']));
        $badge->description = str_repeat('a', 300);
        $this->assertFalse($badge->validate(['description']));
        $badge->description = null;
        $this->assertFalse($badge->validate(['description']));

        // Teste 'image'.
        $badge->image = 'image.png';
        $this->assertTrue($badge->validate(['image']));
        $badge->image = str_repeat('a', 300);
        $this->assertFalse($badge->validate(['image']));
        $badge->image = null;
        $this->assertTrue($badge->validate(['image']));

        // Teste 'condition_type'.
        $badge->condition_type = 'streak';
        $this->assertTrue($badge->validate(['condition_type']));
        $badge->condition_type = 'invalid';
        $this->assertFalse($badge->validate(['condition_type']));
        $badge->condition_type = null;
        $this->assertFalse($badge->validate(['condition_type']));

        // Teste 'condition_value'.
        $badge->condition_value = 10;
        $this->assertTrue($badge->validate(['condition_value']));
        $badge->condition_value = "invalid";
        $this->assertFalse($badge->validate(['condition_value']));
        $badge->condition_value = null;
        $this->assertFalse($badge->validate(['condition_value']));

        // Criação.
        $badge->name = 'Badge Name';
        $badge->description = 'Badge description.';
        $badge->image = 'image.png';
        $badge->condition_type = 'streak';
        $badge->condition_value = 10;
        $this->assertTrue($badge->save());
        
        // Visualização.
        $createdBadge = Badge::findOne($badge->badge_id);
        $this->assertNotNull($createdBadge);

        // Atualização.
        $badge->name = 'Updated Badge Name';
        $this->assertTrue($badge->save());
        $createdBadge = Badge::findOne($badge->badge_id);
        $this->assertEquals('Updated Badge Name', $createdBadge->name);

        // Eliminação.
        $badgeId = $badge->badge_id;
        $badge->delete();
        $deletedBadge = Badge::findOne($badgeId);
        $this->assertNull($deletedBadge);
    }
}
