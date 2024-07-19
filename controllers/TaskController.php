<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use app\models\TaskForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class TaskController extends \yii\web\Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'update-status', 'delete', 'search'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],

                ],

            ],
        );
    }
    public function actionIndex()
    {
        return $this->render('index', [
            'tasks' => Task::find()->where(['is_deleted' => false])->all(),
            'model' => new TaskForm(),
            'model_search' => new TaskSearch(),
        ]);
    }

    public function actionCreate()
    {
        $task = new Task();
        $task_form = new TaskForm();
        if ($this->request->isPost) {
            $task_form->load($this->request->post());
            if ($task_form->validate()) {
                $task->description = $task_form->description;
                $task->status = 0;
                $task->id_user = Yii::$app->user->identity->id;
                $task->is_deleted = 0;

                if ($task->save()) {
                    Yii::$app->session->setFlash('taskSuccess', 'Thêm nhiệm vụ thành công.');
                } else {
                    // return $this->asJson(['task' => $task, 'error' => $task->errors]);
                    Yii::$app->session->setFlash('taskError', 'Có lỗi xảy ra khi lưu dữ liệu.');
                }
            }
        }
        return $this->redirect(['index']);
    }

    public function actionUpdateStatus($id)
    {
        if ($this->request->isPost) {
            $task = Task::findOne($id);
            $task->status = $this->request->post('status');
            if ($task->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $task = Task::findOne($id);
        $task->is_deleted = 1;
        if ($task->save()) {
            return $this->redirect(['index']);
        }
    }

    public function actionSearch()
    {
        $model_search = new TaskSearch();
        $dataProvider = $model_search->search(Yii::$app->request->queryParams);
        // return $this->asJson(['error' => $dataProvider]);
        return $this->render('index', [
            'tasks' => $dataProvider->getModels(),
            'model' => new TaskForm(),
            'model_search' => $model_search,
        ]);
    }
}
