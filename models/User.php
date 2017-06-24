<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name Имя
 * @property string $login Логин
 * @property string $password Пароль
 * @property string $email E-mail
 *
 * @property EntityInWorkAggregate[] $entityInWorkAggregates
 * @property NestingInWork[] $nestingInWorks
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    CONST ROLE_ADMIN = 'admin';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'login', 'password'], 'required'],
            [['id'], 'integer'],
            [['name', 'login'], 'string', 'max' => 64],
            [['password', 'email'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'E-mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityInWorkAggregates()
    {
        return $this->hasMany(EntityInWorkAggregate::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNestingInWorks()
    {
        return $this->hasMany(NestingInWork::className(), ['user_id' => 'id']);
    }
    
    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert == self::EVENT_BEFORE_INSERT) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }
    /**
     * @param $id
     * @return ActiveRecord
     */
    public static function findIdentity ($id)
    {
        return static::findOne($id);
    }
    
    public function getAuthKey ()
    {
    }
    
    public function validateAuthKey ($authKey)
    {
    }
    
    public static function findIdentityByAccessToken ($token, $type = null)
    {
    }
    
    public function savePassword ($password)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
        $this->save();
    }
    
    public function getRole ()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        return key($roles);
    }
    
    public function getRoles ()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        return $roles;
    }
    
    public function hasRole ($needRole)
    {
        $roles = $this->getRoles();
        return isset($roles[$needRole]) && $roles[$needRole] ? true : false;
    }
}
