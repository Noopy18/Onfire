<?php

declare(strict_types=1);

namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

final class BadgeCest
{
    public function _before(FunctionalTester $I): void
    {
        // Code here will be executed before each test function.
    }

    // All `public` methods will be executed as tests.
    public function tryToTest(FunctionalTester $I): void
    {
        // Login do utilizador.
        $I->amOnRoute('/site/login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');
        $I->click('Entrar');

        // Criação.
        $I->amOnRoute('/badge/create');
        $I->fillField('Badge[name]', 'Nova conquista.');
        $I->fillField('Badge[description]', 'Descrição da nova conquista.');
        $I->selectOption('Badge[condition_type]', 'streak');
        $I->fillField('Badge[condition_value]', '10');
        $I->click('Salvar');

        // Visualização.
        $I->see('Nova conquista.', 'dd');
        $I->see('Descrição da nova conquista.', 'dd');

        // Obter o ID da badge criada
        $badge_id = $I->grabFromCurrentUrl('~badge_id=(\d+)~');

        // Atualização.
        $I->amOnRoute('/badge/update', ['badge_id' => $badge_id]);
        $I->fillField('Badge[name]', 'Nova conquista atualizada.');
        $I->click('Salvar');
        $I->see('Nova conquista atualizada.', 'dd');

        // Eliminação.
        $I->amOnRoute('/badge/view', ['badge_id' => $badge_id]);
        $I->click('Eliminar');
        $I->dontSee('Nova conquista atualizada.', 'dd');
    }
}
