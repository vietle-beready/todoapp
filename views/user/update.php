<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; // Add this line

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Cập nhập người dùng';
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">
    <?php if (Yii::$app->session->hasFlash('updateUserSuccess')) : ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('updateUserSuccess') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('updateUserError')) : ?>
        <div class="alert alert-error">
            <?= Yii::$app->session->getFlash('updateUserError') ?>
        </div>
    <?php else : ?>

        <div class="flex justify-center items-center">
            <div class="w-2/5 mt-5 mb-10">
                <div class="site-login border-[1px] border-slate-300 p-5 rounded-lg">

                    <div class="text-2xl text-center font-semibold mb-10"><?= Html::encode($this->title) ?></div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'update-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'mb-1 font-semibold'],
                            'inputOptions' => ['class' => 'mb-1 col-lg-3 form-control'],
                            'errorOptions' => ['class' => 'block invalid-feedback mb-2'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'name')->textInput() ?>

                    <?= $form->field($model, 'email')->textInput() ?>

                    <?= $form->field($model, 'oldPassword')->passwordInput() ?>
                    <?= $form->field($model, 'newPassword')->passwordInput() ?>
                    <?= $form->field($model, 'confirmNewPassword')->passwordInput() ?>

                    <div class="form-group flex justify-center items-center">
                        <?= Html::submitButton('Cập nhập', ['class' => 'btn btn-success mt-5 w-full']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>

    <?php endif; ?>


</div>