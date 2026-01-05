<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

final class LoginCest
{
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
