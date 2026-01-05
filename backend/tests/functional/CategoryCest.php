<?php

declare(strict_types=1);

namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

final class CategoryCest
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

    public function createCategory(FunctionalTester $I): void
    {
        // Login do utilizador.
        $I->amOnRoute('/site/login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');
        $I->click('Entrar');

        // Criação de uma nova categoria.
        $I->amOnRoute('/category/create');
        $I->fillField('Category[name]', 'New Category');
        $I->fillField('Category[description]', 'New category description to test.');
        $I->fillField('Category[color]', '#000000');
        $I->click('Salvar');


        // Verificação de que a categoria foi criada com sucesso.
        $I->see('New Category', 'h1');
        $I->see('New category description to test.', 'td');
    }
}
