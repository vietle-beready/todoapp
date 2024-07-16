<?php

use yii\helpers\Html;

$this->title = 'Bộ sưu tập ảnh';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery px-10">
    <h1 class="font-medium text-xl mb-3"><?= Html::encode($this->title) ?></h1>
    <a href="/gallery/upload" class="px-4 py-2 bg-green-400 rounded-md text-white">Tải ảnh</a>
    <?php if (!empty($webpImages)) : ?>

        <div class="image-gallery bg-slate-50  grid grid-cols-4 gap-5 p-4 border border-slate-300 mt-5 rounded-md">
            <?php foreach ($webpImages as $image) : ?>
                <div class="image-item bg-white  border-[1px] border-slate-300 shadow-primary rounded-md">
                    <?= Html::img($image['url'], ['alt' => $image['name'], 'style' => 'max-width: 400px; width: 100%; height:200px;']) ?>

                    <p class="font-medium py-2 w-full text-center border-t-[1px] border-slate-300"><?= Html::encode($image['name']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="py-4">Không có ảnh nào.</p>
    <?php endif; ?>
</div>