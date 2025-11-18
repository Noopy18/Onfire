<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'password_reset_token' => Yii::$app->security->generateRandomString() . '_' . time(),
            'verification_token' => Yii::$app->security->generateRandomString() . '_' . time(),
            'email' => 'admin@gmail.com',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),

        ]);

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
        $auth->addChild($createUser, $technician);

        //Permissão para a atualização de Utilizadores.
        $updateUser = $auth->createPermission('updateUser');
        $auth->add($updateUser);
        $auth->addChild($updateUser, $technician);

        //Permissão para a vizualização de Utilizadores.
        $viewUser = $auth->createPermission('viewUser');
        $auth->add($viewUser);
        $auth->addChild($viewUser, $technician);

        //Permissão para a eliminação de Utilizadores.
        $deleteUser = $auth->createPermission('deleteUser');
        $auth->add($deleteUser);
        $auth->addChild($deleteUser, $technician);

        // ################################################## CATEGORIA

        //Permissão para a criação de Categorias.
        $createCategory = $auth->createPermission('createCategory');
        $auth->add($createCategory);
        $auth->addChild($createCategory, $technician);

        //Permissão para a atualização de Categorias.
        $updateCategory = $auth->createPermission('updateCategory');
        $auth->add($updateCategory);
        $auth->addChild($updateCategory, $technician);

        //Permissão para a vizualização de Categorias.
        $viewCategory = $auth->createPermission('viewCategory');
        $auth->add($viewCategory);
        $auth->addChild($viewCategory, $technician);

        //Permissão para a eliminação de Categorias.
        $deleteCategory = $auth->createPermission('deleteCategory');
        $auth->add($deleteCategory);
        $auth->addChild($deleteCategory, $technician);

        // ################################################## CRACHÁS

        //Permissão para a criação de Crachás.
        $createBadge = $auth->createPermission('createBadge');
        $auth->add($createBadge);
        $auth->addChild($createBadge, $technician);

        //Permissão para a atualização de Crachás.
        $updateBadge = $auth->createPermission('updateBadge');
        $auth->add($updateBadge);
        $auth->addChild($updateBadge, $technician);

        //Permissão para a vizualização de Crachás.
        $viewBadge = $auth->createPermission('viewBadge');
        $auth->add($viewBadge);
        $auth->addChild($viewBadge, $user);

        //Permissão para a eliminação de Crachás.
        $deleteBadge = $auth->createPermission('deleteBadge');
        $auth->add($deleteBadge);
        $auth->addChild($deleteBadge, $technician);


    }

    public function down()
    {
        $this->dropTable('{{%user}}');

        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
