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

        // ################################################## UTILIZADOR

        //Permissão para a atualização de extras de um Utilizador.
        $updateUtilizador = $auth->createPermission('updateUtilizador');
        $auth->add($updateUtilizador);
        $auth->addChild($technician, $updateUtilizador);

        //Permissão para a vizualização de extras de um Utilizador.
        $viewUtilizador = $auth->createPermission('viewUtilizador');
        $auth->add($viewUtilizador);
        $auth->addChild($technician, $viewUtilizador);

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

        // ################################################## CONQUISTAS

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

        // ################################################## HÁBITOS

        //Permissão para a criação de Hábitos.
        $createHabit = $auth->createPermission('createHabit');
        $auth->add($createHabit);
        $auth->addChild($user, $createHabit);

        //Permissão para a atualização de Hábitos.
        $updateHabit = $auth->createPermission('updateHabit');
        $auth->add($updateHabit);
        $auth->addChild($user, $updateHabit);

        //Permissão para a vizualização de Hábitos.
        $viewHabit = $auth->createPermission('viewHabit');
        $auth->add($viewHabit);
        $auth->addChild($user, $viewHabit);

        //Permissão para a eliminação de Hábitos.
        $deleteHabit = $auth->createPermission('deleteHabit');
        $auth->add($deleteHabit);
        $auth->addChild($user, $deleteHabit);

        // ################################################## DESAFIOS SEMANAIS

        //Permissão para a criação de Desafios Semanais.
        $createWeeklychallenge = $auth->createPermission('createWeeklychallenge');
        $auth->add($createWeeklychallenge);
        $auth->addChild($technician, $createWeeklychallenge);

        //Permissão para a atualização de Desafios Semanais.
        $updateWeeklychallenge = $auth->createPermission('updateWeeklychallenge');
        $auth->add($updateWeeklychallenge);
        $auth->addChild($technician, $updateWeeklychallenge);

        //Permissão para a vizualização de Desafios Semanais.
        $viewWeeklychallenge = $auth->createPermission('viewWeeklychallenge');
        $auth->add($viewWeeklychallenge);
        $auth->addChild($user, $viewWeeklychallenge);

        //Permissão para a eliminação de Desafios Semanais.
        $deleteWeeklychallenge = $auth->createPermission('deleteWeeklychallenge');
        $auth->add($deleteWeeklychallenge);
        $auth->addChild($technician, $deleteWeeklychallenge);

        // ################################################## AMIGOS

        //Permissão para enviar um pedido de amizade.
        $sendInvitation = $auth->createPermission('sendInvitation');
        $auth->add($sendInvitation);
        $auth->addChild($user, $sendInvitation);

        //Permissão para rejeitar um pedido de amizade.
        $rejectInvitation = $auth->createPermission('rejectInvitation');
        $auth->add($rejectInvitation);
        $auth->addChild($user, $rejectInvitation);

        //Permissão para aceitar um pedido de amizade.
        $acceptInvitation = $auth->createPermission('acceptInvitation');
        $auth->add($acceptInvitation);
        $auth->addChild($user, $acceptInvitation);

    
    }

    public function down()
    {
        
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
    
}
