<?php

use yii\db\Migration;
use app\models\User;
use yii\rbac\DbManager;

class m170624_083808_create_admin extends Migration
{
    public function up()
    {
        $admin = new User();
        $admin->login = "admin";
        $admin->password = "admin";
        $admin->name = "admin";
        $admin->save();
//        $admin->savePassword('admin');
        $auth = new Yii::$app->getAuthManager();
        $role = $auth->getRole(User::ROLE_ADMIN);
        $auth->assign($role, $admin->getId());
    }

    public function down()
    {
        $auth = new DbManager();
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole(Users::ROLE_ADMIN);
        $auth->revoke($role, $modelUsers->id);
    }
}
