<?php

declare(strict_types=1);

namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

final class CategoryCest
{
    public function testCategory(FunctionalTester $I): void
    {
        // Login do utilizador.
        $I->amOnRoute('/site/login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');
        $I->click('Entrar');

        // Criação.
        $I->amOnRoute('/category/create');
        $I->fillField('Category[name]', 'New Category');
        $I->fillField('Category[description]', 'New category description to test.');
        $I->fillField('Category[color]', '#000000');
        $I->click('Salvar');

        // Visualização.
        $I->see('New Category', 'td');
        $I->see('New category description to test.', 'td');

        // Obter o ID da categoria criada.
        $category_id = $I->grabFromCurrentUrl('~category_id=(\d+)~');

        // Atualização.
        $I->amOnRoute('/category/update', ['category_id' => $category_id]);
        $I->fillField('Category[name]', 'Updated Category');
        $I->click('Salvar');
        $I->see('Updated Category', 'td');

        // Eliminação.
        $I->amOnRoute('/category/view', ['category_id' => $category_id]);
        $I->click('Eliminar');
        $I->dontSee('Updated Category', 'td');
    }
}
