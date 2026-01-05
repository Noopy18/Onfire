<?php

namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\Category;

class CategoryTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCategory()
    {
        $category = new Category();

        // Teste 'name'.
        $category->name = 'Exercício';
        $this->assertTrue($category->validate(['name']));
        $category->name = str_repeat('a', 300);
        $this->assertFalse($category->validate(['name']));
        $category->name = null;
        $this->assertFalse($category->validate(['name']));

        // Teste 'description'.
        $category->description = 'Descrição da categoria.';
        $this->assertTrue($category->validate(['description']));
        $category->description = str_repeat('a', 300);
        $this->assertFalse($category->validate(['description']));
        $category->description = null;
        $this->assertTrue($category->validate(['description']));

        // Teste 'color'.
        $category->color = '#FF0000';
        $this->assertTrue($category->validate(['color']));
        $category->color = str_repeat('a', 10);
        $this->assertFalse($category->validate(['color']));
        $category->color = null;
        $this->assertTrue($category->validate(['color']));

        // Criação.
        $category->name = 'Exercício';
        $category->description = 'Descrição da categoria.';
        $category->color = '#FF0000';
        $this->assertTrue($category->save());
         
         // Visualização.
        $createdCategory = Category::findOne($category->category_id);
        $this->assertNotNull($createdCategory);

        // Atualização.
        $category->name = 'Saúde';
        $this->assertTrue($category->save());
        $createdCategory = Category::findOne($category->category_id);
        $this->assertEquals('Saúde', $createdCategory->name);
 
        // Eliminação.
        $categoryId = $category->category_id;
        $category->delete();
        $deletedCategory = Category::findOne($categoryId);
        $this->assertNull($deletedCategory);
    }
}
