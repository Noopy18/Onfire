<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

final class HabitCest
{
    public function _before(FunctionalTester $I): void
    {
        // Code here will be executed before each test function.
    }

    // All `public` methods will be executed as tests.
    public function tryToTest(FunctionalTester $I): void
    {
        // Write your test content here.
    }

    public function createHabit(FunctionalTester $I): void
    {
        // Login do utilizador.
        $I->amOnRoute('/site/login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');
        $I->click('Entrar');

        // Aceder à página de criação de hábitos.
        $I->click('button[data-bs-target="#createHabitModal"]');

        // Preencher o formulário de criação de hábito.
        $I->fillField('Habit[name]', 'New Habit');
        $I->fillField('Habit[description]', 'This is a new habit for testing.');
        $I->selectOption('Habit[fk_category]', 'Sport');
        $I->fillField('Habit[frequency]', '[1,0,0,0,0,0,0]');

        // Guardar o novo hábito.
        $I->click('Salvar');

        // Verify that the habit was created successfully
        $I->see('New Habit', 'td');
        $I->see('This is a new habit for testing.', 'td');
    }
}
