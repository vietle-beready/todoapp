<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; // Add this line
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Todo List';
?>
<div class="site-index">

    <div class="px-5">
        <?php if (Yii::$app->session->hasFlash('taskSuccess')) : ?>
            <div class="alert alert-success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 1500)" x-show="show">
                <?= Yii::$app->session->getFlash('taskSuccess') ?>
            </div>
        <?php elseif (Yii::$app->session->hasFlash('taskError')) : ?>
            <div class="alert alert-error" x-data="{ show: true }" x-init="setTimeout(() => show = false, 1500)" x-show="show">
                <?= Yii::$app->session->getFlash('taskError') ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="flex justify-center items-center p-5 flex-col">

        <div x-data="{
        tasks: [
            <?php foreach ($tasks  as $task) : ?>
                { id: <?= $task->id ?>, title: '<?= $task->description ?>', completed: <?= $task->status ?> },
            <?php endforeach; ?>    
        ],
        
        get totalTask() {
            return this.tasks.length
        },
        get totalCompletedTask() {
            return this.tasks.filter(task => task.completed).length;
        },
        get totalUncompletedTask(){
            return this.tasks.filter(task => !task.completed).length
        },
        get isComplete() {
            return this.tasks.filter(task => !task.completed).length 
        },
        isFilter(isComplete) {
            if(this.filter==='all') return true
            if(this.filter==='complete' && isComplete) return true
            if(this.filter==='uncomplete' && !isComplete) return true
            return false
        },
        newTask: '',
        filter: 'all'
    }" class="w-full px-5 py-8 rounded-lg border-[1px] border-gray-300">
            <div class="flex justify-between items-center">

                <div class="flex justify-between items-center gap-4 font-semibold">
                    <div class="">
                        To dos: <span x-text="totalTask"></span>
                    </div>
                    <span>|</span>
                    <div>Completed: <span x-text="totalCompletedTask"></span></div>
                </div>
                <div class="flex justify-between items-center gap-10">
                    <?php $form = ActiveForm::begin([
                        'action' => ['search'],
                        'method' => 'get',
                        'options' => ['class' => 'flex justify-center items-center gap-3']
                    ]); ?>

                    <?= $form->field($model_search, 'description')->textInput(['class' => 'border-1 border-slate-500 px-2 py-1 rounded-md', 'placeholder' => 'Tìm kiếm...'])->label(false) ?>
                    <?= Html::submitButton('Tìm kiếm', ['class' => 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800']) ?>

                    <?php ActiveForm::end(); ?>


                    <?php $form = ActiveForm::begin([
                        'action' => ['filter'],
                        'method' => 'get',
                        'options' => ['class' => 'flex justify-center items-center gap-3']
                    ]); ?>

                    <?= $form->field($model_search, 'filter')->dropDownList([
                        'all' => 'Tất cả',
                        'complete' => 'Hoàn thành',
                        'uncomplete' => 'Chưa hoàn thành'
                    ], [
                        'class' => 'block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                        'onchange' => 'this.form.submit()',
                        // 'options' => [
                        //     $model_search->filter ?  $model_search->filter : 'all' => ['selected' => true]
                        // ]
                    ])->label(false) ?>

                    <?php ActiveForm::end(); ?>


                    <!-- <form class="">
                        <select id="small" x-model="filter" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="all">Tất cả </option>
                            <option value="complete">Hoàn thành</option>
                            <option value="uncomplete">Chưa hoàn thành</option>
                        </select>
                    </form> -->

                </div>
            </div>
            <div class="mt-3 mb-4">
                <div class="font-semibold" x-show="isComplete">
                    <span x-text="totalUncompletedTask">
                    </span>
                    <span> more to go!</span>
                </div>
                <div class="font-semibold" x-show="!isComplete && tasks.length!=0">
                    Congrats! You have completed all tasks!
                </div>
                <div class="font-semibold" x-show="tasks.length==0">
                    No task!
                </div>
            </div>
            <ul class="flex flex-col gap-3 min-h-40 p-0">
                <?php foreach ($tasks as $task) : ?>
                    <li class="rounded-md p-3 border-[1px] border-gray-300 flex justify-between" x-show="isFilter( <?= $task['status'] ?>)" :class="{ 'bg-gray-200': <?= $task['status'] ? 'true' : 'false' ?> }">
                        <div class="flex justify-center items-center gap-3">
                            <?= Html::beginForm(['update-status', 'id' => $task->id], 'post') ?>
                            <?= Html::checkbox('status', $task->status, ['onchange' => 'this.form.submit()', 'class' => 'w-4 h-4']) ?>
                            <?= Html::endForm() ?>

                            <div class="font-semibold">
                                <?= $task['description'] ?>
                            </div>
                        </div>
                        <div>

                            <?= Html::a('Remove', ['delete', 'id' => $task->id], [
                                'class' => 'text-slate-500 text-sm',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <!-- <button class="text-slate-500 text-sm">Remove</button> -->
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="mt-10 shadow-primary rounded-lg p-3">
                <?php $form = ActiveForm::begin([
                    'action' => ['task/create'],
                    'options' => ['class' => 'flex justify-center items-start gap-3'],
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'errorOptions' => ['class' => 'block invalid-feedback mb-2'],
                    ],
                ]); ?>

                <?= $form->field($model, 'description')->textInput(['class' => 'border-1 border-black px-2 py-1 rounded-sm w-full'])->label(false) ?>

                <?= Html::submitButton('Thêm', ['class' => 'px-2 py-1 h-auto border border-black rounded-sm font-medium hover:bg-slate-200']) ?>

                <?php ActiveForm::end(); ?>

                <!-- <form action="/task/create" method="POST" class="flex justify-center items-center gap-3">
                    <input class="border-1 border-black px-2 py-1 rounded-sm w-11/12" type="text" x-model="newTask" placeholder="Add a new task" required>
                    <button type="submit" class="flex-1 px-2 py-1 border border-black rounded-sm font-medium hover:bg-slate-200">Thêm</button>
                </form> -->
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            open: false,

            toggle() {
                this.open = !this.open
            },
        }))
    })
</script>