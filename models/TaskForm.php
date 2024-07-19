<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TaskForm extends Model
{
    public $description;
    public $status;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['description'], 'required', 'message' => 'Tên nhiệm vụ không thể thiếu.'],
            ['description', 'string', 'max' => 1000],
            ['status', 'integer'],


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
        ];
    }
}
