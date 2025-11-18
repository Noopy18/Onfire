<?php

use yii\db\Migration;

class m251118_144537_rbac extends Migration
{

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
    $auth = Yii::$app->authManager;

        //Criação da role "User".
        $user = $auth->createRole('user');
        $auth->add($user);

        //Criação da role "Technician" com a herança de todas as permições do "User".
        $technician = $auth->createRole('technician');
        $auth->add($technician);
        $auth->addChild($technician, $user);

        //Criação da role "Administrator" com a herança de todas as permições do "Technician".
        $administrator = $auth->createRole('administrator');
        $auth->add($administrator);
        $auth->addChild($administrator, $technician);
        $auth->assign($administrator, 1);

        // ################################################## USER

        //Permissão para a criação de Utilizadores.
        $createUser = $auth->createPermission('createUser');
        $auth->add($createUser);
        $auth->addChild($technician, $createUser);

        //Permissão para a atualização de Utilizadores.
        $updateUser = $auth->createPermission('updateUser');
        $auth->add($updateUser);
        $auth->addChild($technician, $updateUser);

        //Permissão para a vizualização de Utilizadores.
        $viewUser = $auth->createPermission('viewUser');
        $auth->add($viewUser);
        $auth->addChild($technician, $viewUser);

        //Permissão para a eliminação de Utilizadores.
        $deleteUser = $auth->createPermission('deleteUser');
        $auth->add($deleteUser);
        $auth->addChild($technician, $deleteUser);

        // ################################################## CATEGORIA

        //Permissão para a criação de Categorias.
        $createCategory = $auth->createPermission('createCategory');
        $auth->add($createCategory);
        $auth->addChild($technician, $createCategory);

        //Permissão para a atualização de Categorias.
        $updateCategory = $auth->createPermission('updateCategory');
        $auth->add($updateCategory);
        $auth->addChild($technician, $updateCategory);

        //Permissão para a vizualização de Categorias.
        $viewCategory = $auth->createPermission('viewCategory');
        $auth->add($viewCategory);
        $auth->addChild($technician, $viewCategory);

        //Permissão para a eliminação de Categorias.
        $deleteCategory = $auth->createPermission('deleteCategory');
        $auth->add($deleteCategory);
        $auth->addChild($technician, $deleteCategory);

        // ################################################## Conquistas

        //Permissão para a criação de Conquistas.
        $createBadge = $auth->createPermission('createBadge');
        $auth->add($createBadge);
        $auth->addChild($technician, $createBadge);

        //Permissão para a atualização de Conquistas.
        $updateBadge = $auth->createPermission('updateBadge');
        $auth->add($updateBadge);
        $auth->addChild($technician, $updateBadge);

        //Permissão para a vizualização de Conquistas.
        $viewBadge = $auth->createPermission('viewBadge');
        $auth->add($viewBadge);
        $auth->addChild($user, $viewBadge);

        //Permissão para a eliminação de Conquistas.
        $deleteBadge = $auth->createPermission('deleteBadge');
        $auth->add($deleteBadge);
        $auth->addChild($technician, $deleteBadge);


    
    }

    public function down()
    {
        
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
    
}
