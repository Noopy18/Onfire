<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

final class HabitCest
{
    public function _before(FunctionalTester $I): void
    {
        // Login do utilizador.
        $I->amOnRoute('/site/login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');
        $I->click('Entrar');
    }


    public function testHabit(FunctionalTester $I): void
    {
        // CRIAÇÃO DE UM HÁBITO
        $I->amOnRoute('/habit/index');
        // Aceder à página de criação de hábitos.
        $I->click('button[data-bs-target="#createHabitModal"]');
        $I->fillField('Habit[name]', 'New Habit');
        $I->fillField('Habit[description]', 'This is a new habit for testing.');
        $I->selectOption('Habit[fk_category]', 'Sport');
        $I->fillField('Habit[frequency]', '[1,1,1,1,1,1,1]');
        // Guardar o novo hábito.
        $I->click('Salvar');
        // Verify that the habit was created successfully
        $I->see('New Habit', 'td');
        $I->see('This is a new habit for testing.', 'td');

        // ATUALIZAÇÃO DE UM HÁBITO
        // Clicar no botão de edição do primeiro hábito na lista.
        $I->amOnRoute('/habit/index');
        $I->click('button[name="view"]', 0);
        $I->click('Atualizar');
        $I->fillField('Habit[name]', 'Updated Habit Name');
        $I->fillField('Habit[description]', 'Updated description for testing.');
        // Guardar as alterações.
        $I->click('button.btn.btn-primary.btn-lg');
        $I->see('Updated Habit Name', 'h1');
        $I->see('Updated description for testing.', 'p');

        // Fazer uma compleção.
        $I->amOnRoute('/habit/index');
        $I->click('Completar');
        $I->see('Completed', 'button');

        // ELIMINAR HÁBITO
        $I->amOnRoute('/habit/index');
        // Clicar no botão de edição do primeiro hábito na lista.
        $I->click('button[name="view"]', 0);
        // Clicar no botão eliminar.
        $I->click('a.btn-danger.btn.w-100.py-4.text-white');
        $I->dontSee('Updated Habit Name', 'td');
    }
}
