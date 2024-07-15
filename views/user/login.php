<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Đăng nhập';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="flex justify-center items-center">
    <div class="w-2/5 mt-5 mb-10">
        <div class="site-login border-[1px] border-slate-300 p-5 rounded-lg">

            <div class="text-2xl text-center font-semibold mb-10"><?= Html::encode($this->title) ?></div>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'mb-1 font-semibold'],
                    'inputOptions' => ['class' => 'mb-3 col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'block col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Mật khẩu') ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'label' => 'Ghi nhớ tôi',
            ]) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>