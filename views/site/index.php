<?php

/** @var yii\web\View $this */

$this->title = 'Todo List';
?>
<div class="site-index">
    <div class="flex justify-center items-center p-5">
        <div x-data="{
        tasks: [],
        addTask() {
            this.tasks.push({ id: Date.now(), title: this.newTask, completed: false });
            this.newTask = '';
        },
        removeTask(index) {
            this.tasks.splice(index, 1);
        },
        get toggleTask() {
            this.tasks[index].completed = !this.tasks[index].completed
        },
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
                <div class="">
                    <form class="max-w-sm mx-auto w-full">
                        <!-- <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Small select</label> -->
                        <select id="small" @change="console.log(filter)" x-model="filter" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="all">Tất cả </option>
                            <option value="complete">Hoàn thành</option>
                            <option value="uncomplete">Chưa hoàn thành</option>
                        </select>
                    </form>
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
                <template x-for="(task, index) in tasks" :key="index">
                    <li x-show="isFilter(task.completed)" class="rounded-md p-3 border-[1px] border-gray-300 flex justify-between" :class="{ 'bg-gray-200': task.completed }">
                        <div class="flex justify-center items-center gap-3">
                            <input type="checkbox" class="w-4 h-4" x-model="task.completed">
                            <div class="font-semibold" x-text="task.title" :class="{'line-through': task.completed}"></div>
                        </div>
                        <div>
                            <button @click="removeTask(index)" class="text-slate-500 text-sm">Remove</button>
                        </div>
                    </li>
                </template>
            </ul>

            <div class="mt-10 shadow-primary rounded-lg p-3">
                <form @submit.prevent="addTask" class="flex justify-center items-center gap-3">
                    <input class="border-1 border-black px-2 py-1 rounded-sm w-11/12" type="text" x-model="newTask" placeholder="Add a new task" required>
                    <button type="submit" class="flex-1 px-2 py-1 border border-black rounded-sm font-medium hover:bg-slate-200">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div @foo="console.log('foo was dispatched')">
    <button @click="$dispatch('foo')">hello</button>
</div>

<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content</div>
</div>

<div x-data="dropdown">
    <button @click="toggle">Toggle Content</button>

    <div x-show="open">
        Content...
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