<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

final class RegisterCest
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

    public function registerUser(FunctionalTester $I): void
    {
        $I->amOnRoute('/site/signup');
        $I->fillField('SignupForm[username]', 'newuser');
        $I->fillField('SignupForm[email]', 'newuser@example.com');
        $I->fillField('SignupForm[password]', 'newuserpassword');
        $I->fillField('SignupForm[confirmPassword]', 'newuserpassword');
        $I->click('Criar conta');
        $I->see('Amigos', 'a');
        $I->see('Sair', 'form button');
    }
}
