<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

final class LoginCest
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

    public function loginUser(FunctionalTester $I): void
    {
        $I->amOnRoute('/site/login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');
        $I->click('Entrar');
        $I->see('Amigos', 'a');
        $I->see('Sair', 'form button');
    }
}
