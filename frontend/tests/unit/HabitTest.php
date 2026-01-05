<?php


namespace frontend\tests\Unit;

use frontend\tests\UnitTester;
use frontend\models\Habit;

class HabitTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $habit = new Habit();

        // Teste 'name'.
        $habit->name = 'Correr 1KM';
        $this->assertTrue($habit->validate(['name']));
        $habit->name = str_repeat('a', 300);
        $this->assertFalse($habit->validate(['name']));
        $habit->name = null;
        $this->assertFalse($habit->validate(['name']));

        // Teste 'description'.
        $habit->description = 'Descrição simples.';
        $this->assertTrue($habit->validate(['description']));
        $habit->description = str_repeat('a', 300);
        $this->assertFalse($habit->validate(['description']));
        $habit->description = null;
        $this->assertTrue($habit->validate(['description']));

        // Teste 'frequency'.
        $habit->frequency = '[1,0,0,0,0,0,0]';
        $this->assertTrue($habit->validate(['frequency']));
        $habit->frequency = str_repeat('a', 300);
        $this->assertFalse($habit->validate(['frequency']));
        $habit->frequency = null;
        $this->assertFalse($habit->validate(['frequency']));

        // Teste 'final_date'.
        $habit->final_date = date('Y-m-d');
        $this->assertTrue($habit->validate(['final_date']));
        $habit->final_date = null;
        $this->assertTrue($habit->validate(['final_date']));

        // Teste 'type'.
        $habit->type = "boolean";
        $this->assertTrue($habit->validate(['type']));
        $habit->type = "int";
        $this->assertTrue($habit->validate(['type']));
        $habit->type = "other";
        $this->assertFalse($habit->validate(['type']));
        $habit->type = null;
        $this->assertFalse($habit->validate(['type']));

        // Teste 'created_at'.
        $habit->created_at = date('Y-m-d');
        $this->assertTrue($habit->validate(['created_at']));
        $habit->created_at = null;
        $this->assertFalse($habit->validate(['created_at']));

        // Teste 'fk_utilizador'.
        $habit->fk_utilizador = 1;
        $this->assertTrue($habit->validate(['fk_utilizador']));
        $habit->fk_utilizador = null;
        $this->assertFalse($habit->validate(['fk_utilizador']));
        $habit->fk_utilizador = "invalid";
        $this->assertFalse($habit->validate(['fk_utilizador']));

        // Teste 'fk_category'.
        $habit->fk_category = 1;
        $this->assertTrue($habit->validate(['fk_category']));
        $habit->fk_category = null;
        $this->assertFalse($habit->validate(['fk_category']));
        $habit->fk_category = "invalid";
        $this->assertFalse($habit->validate(['fk_category']));

        // Criação.
        $habit->name = 'Correr 1KM';
        $habit->description = 'Descrição simples.';
        $habit->frequency = '[1,0,0,0,0,0,0]';
        $habit->final_date = date('Y-m-d');
        $habit->type = "boolean";
        $habit->created_at = date('Y-m-d');
        $habit->fk_utilizador = 1;
        $habit->fk_category = 1;
        $this->assertTrue($habit->save());
        
        // Visualização.
        $createdHabit = Habit::findOne($habit->habit_id);
        $this->assertNotNull($createdHabit);

        // Atualização.
        $habit->name = 'Correr 2KM';
        $this->assertTrue($habit->save());
        $createdHabit = Habit::findOne($habit->habit_id);
        $this->assertEquals('Correr 2KM', $createdHabit->name);

        // Eliminação.
        $habitId = $habit->habit_id;
        $habit->delete();
        $deletedHabit = Habit::findOne($habitId);
        $this->assertNull($deletedHabit);
    }
}
