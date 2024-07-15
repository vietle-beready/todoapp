<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */


$this->title = 'Đăng ký';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">


    <div class="flex justify-center items-center">
        <div class="w-2/5 mt-5 mb-10">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>