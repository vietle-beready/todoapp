<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UpdateUserForm extends Model
{
    public $id;
    public $name;
    public $email;
    public $oldPassword;
    public $newPassword;
    public $confirmNewPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'oldPassword', 'newPassword', 'confirmNewPassword'], 'required', 'message' => '{attribute} không thể thiếu.'],
            // email has to be a valid email address
            ['email', 'email'],
            ['newPassword', 'match', 'pattern' => '/^[a-zA-Z0-9@%&*]{8,}$/', 'message' => 'Mật khẩu phải chứa ít nhất 8 ký tự và không chứa ký tự đặc biệt.'],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Mật khẩu không khớp.'],
            ['oldPassword', 'validateOldPassword', 'when' => function ($model) {
                return !empty($model->newPassword);
            }],
            [
                'email', 'unique',
                'targetClass' => 'app\models\User',
                'targetAttribute' => ['email'],
                'filter' => function ($query) {
                    $query->andWhere(['is_deleted' => false]);
                    $query->andWhere(['!=', 'id', $this->id]);
                },
                'message' => Yii::t('app', 'Email này đã được sử dụng'),
            ],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Họ và tên',
            'email' => 'Email',
            'oldPassword' => 'Mật khẩu cũ',
            'newPassword' => 'Mật khẩu mới',
            'confirmNewPassword' => 'Xác nhận mật khẩu mới',
        ];
    }

    public function validateOldPassword($attribute, $params)
    {
        $user = Yii::$app->user->identity;
        if (!$user || !Yii::$app->security->validatePassword($this->oldPassword, $user->password)) {
            $this->addError($attribute, 'Mật khẩu cũ không chính xác.');
        }
    }

    public function updateProfile($user)
    {
        if ($this->validate()) {
            if (!empty($this->newPassword)) {
                $user->password = Yii::$app->security->generatePasswordHash($this->newPassword);
            }

            $user->name = $this->name;
            $user->email = $this->email;

            $user->save();
            return $user->save();
        }
        return false;
    }
}
