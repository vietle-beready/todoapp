<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * UserForm is the model behind the contact form.
 */
class UserForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $confirm_password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'password', 'confirm_password'], 'required', 'message' => '{attribute} không thể thiếu.'],
            // email has to be a valid email address
            ['email', 'email'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9@%&*]{8,}$/', 'message' => 'Mật khẩu phải chứa ít nhất 8 ký tự và không chứa ký tự đặc biệt.'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Mật khẩu không khớp.'],
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
            'password' => 'Mật khẩu',
            'confirm_password' => 'Xác nhận mật khẩu',
            'verifyCode' => 'Mã xác nhận',
        ];
    }
}
