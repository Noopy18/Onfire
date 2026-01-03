<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->fillField('Username', 'admin');
        $I->fillField('Password', 'admin');
        $I->click('Entrar');

        $I->see('[administrator] - admin', 'a[href="#"]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
