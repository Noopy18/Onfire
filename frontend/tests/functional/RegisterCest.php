<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

final class RegisterCest
{
    public function registerUser(FunctionalTester $I): void
    {
        $I->amOnRoute('/site/signup');
        $I->fillField('SignupForm[username]', 'newuser');
        $I->fillField('SignupForm[email]', 'newuser@example.com');
        $I->fillField('SignupForm[password]', 'newuserpassword');
        $I->fillField('SignupForm[confirmPassword]', 'newuserpassword');
        $I->click('Criar conta', 'button[type=submit]');
        $I->see('Sair', 'button');
    }
}
