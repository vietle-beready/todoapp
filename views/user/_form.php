<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha; // Add this line to import the Captcha class

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="user-form border-[1px] border-slate-300 p-5 rounded-lg">
    <div class="text-2xl text-center font-semibold mb-10"><?= Html::encode($this->title) ?></div>
    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'mb-1 font-semibold'],
            'inputOptions' => ['class' => 'mb-3 col-lg-3 form-control'],
            'errorOptions' => ['class' => 'block col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'confirm_password')->passwordInput() ?>

    <div class="form-group flex justify-center items-center">
        <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-success mt-5 w-full']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>