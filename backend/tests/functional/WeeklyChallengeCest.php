<?php

declare(strict_types=1);

namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

final class WeeklyChallengeCest
{
    public function testWeeklyChallenge(FunctionalTester $I): void
    {
        // Login do utilizador.
        $I->amOnRoute('/site/login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');
        $I->click('Entrar');

        // Criação.
        $I->amOnRoute('/weekly-challenge/create');
        $I->fillField('WeeklyChallenge[name]', 'Novo desafio semanal');
        $I->fillField('WeeklyChallenge[description]', 'Novo desafio semanal descrição.');
        $I->fillField('WeeklyChallenge[start_date]', date('Y-m-d'));
        $I->fillField('WeeklyChallenge[status]', '1');
        $I->click('Salvar');

        // Visualização.
        $I->see('Novo desafio semanal', 'td');
        $I->see('Novo desafio semanal descrição.', 'td');

        // Obter o ID da categoria criada.
        $weekly_challenge_id = $I->grabFromCurrentUrl('~weekly_challenge_id=(\d+)~');

        // Atualização.
        $I->amOnRoute('/weekly-challenge/update', ['weekly_challenge_id' => $weekly_challenge_id]);
        $I->fillField('WeeklyChallenge[name]', 'Desafio semanal atualizado');
        $I->click('Salvar');
        $I->see('Desafio semanal atualizado', 'td');

        // Eliminação.
        $I->amOnRoute('/weekly-challenge/view', ['weekly_challenge_id' => $weekly_challenge_id]);
        $I->click('Eliminar');
        $I->dontSee('Desafio semanal atualizado', 'td');
    }
}
