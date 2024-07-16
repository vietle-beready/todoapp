<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Tải ảnh';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-upload flex justify-center items-center mt-5" x-data="imagePreview()">
    <div class="w-1/2">
        <h1 class="font-semibold mb-2"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="flex items-center justify-center w-full">
            <?= $form->field($model, 'imageFiles[]', ['options' => ['class' => 'hidden']])->fileInput(['id' => 'imageFiles', 'multiple' => true, 'accept' => 'image/png,image/jpeg,image/webp', '@change' => 'previewImages']) ?>
            <label for="imageFiles" class="cursor-pointer w-full h-full">
                <div class="w-full h-full flex items-center justify-center border-[1px] border-slate-400 border-dashed p-5">
                    <template x-if="images.length == 0">
                        <span class="font-medium">Có thể chọn nhiều ảnh. Chỉ chấp nhận jpg, png và webp</span>
                    </template>
                    <template x-if="images.length > 0">
                        <div class="relative grid grid-cols-4 gap-3">
                            <template x-for="(image, index) in images" :key="index">
                                <div class="relative inline-block border-[1px] border-slate-300 w-[100px] h-[100px]">
                                    <img :src="image" class="w-[100x] h-[100px] object-cover">
                                    <button type="button" class="absolute top-0 right-0 text-red-500 font-semibold  rounded-full px-2 text-2xl" @click="removeImage(index)">x</button>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </label>
        </div>

        <div class="form-group mt-4">
            <?= Html::submitButton('Tải lên', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    function imagePreview() {
        return {
            images: [],
            previewImages(event) {
                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileType = file.type;
                    const allowedTypes = ['image/png', 'image/jpeg', 'image/webp'];

                    if (!allowedTypes.includes(fileType)) {
                        alert('Chỉ chấp nhận ảnh thuộc dạng PNG, JPG, WEBP');
                        continue;
                    }

                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.images.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            },
            removeImage(index) {
                this.images.splice(index, 1);
            }
        }
    }
</script>