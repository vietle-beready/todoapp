<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['name', 'email', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['authKey', 'accessToken'], 'string', 'max' => 32],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => 10],
            [['is_deleted'], 'boolean'],
            [['is_deleted'], 'default', 'value' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        if (($model = User::findOne(['email' => $email, 'is_deleted' => false])) !== null) {
            return $model;
        }
        return null;
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = User::findOne($id);
        return isset($user) ? new static($user) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = User::findOne(['accessToken' => $token]);
        if ($user) {
            return new static($user);
        }
        return null;
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
