<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exception \yii\web\HttpException */
/* @var $code int */

$this->title = 'Error ' . $code;

?>
<div class="mt-10 flex items-center justify-center w-full">
    <div class="max-w-xl w-full text-center">
        <h1 class="text-4xl font-bold text-red-600">Error <?= Html::encode($code) ?></h1>
        <div class="mt-4 text-lg text-red-500">
            <?= nl2br(Html::encode($exception->getMessage())) ?>
        </div>
        <p class="mt-4">
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>
        <a href="<?= Yii::$app->homeUrl ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Go to Homepage
        </a>
    </div>
</div>