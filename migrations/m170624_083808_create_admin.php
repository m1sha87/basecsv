<?php

use yii\db\Migration;
use app\models\User;

class m170624_083808_create_admin extends Migration
{
    public function up()
    {
        $admin = new User();
        $admin->login = "admin";
        $admin->password = "admin";
        $admin->name = "admin";
        $admin->save();
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole('admin');
        $auth->assign($role, $admin->getId());
    }

    public function down()
    {
        $admin = User::find()
            ->where(['login' => 'admin'])
            ->one();
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole('admin');
        $auth->revoke($role, $admin->id);
        $admin->delete();
    }
}
