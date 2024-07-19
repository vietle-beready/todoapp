<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use app\models\TaskForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\HttpException;
use yii\helpers\Json;

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
                            'actions' => ['index', 'create', 'update-status', 'delete', 'search', 'filter'],
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
        $user = Yii::$app->user->identity;
        $query = Task::find()->where(['is_deleted' => false, 'id_user' => $user->id])->all();
        return $this->render('index', [
            'tasks' => $query,
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
                    Yii::$app->session->setFlash('taskError', 'Có lỗi xảy ra khi lưu dữ liệu.');
                }
            }
        }
        return $this->redirect(['index']);
    }

    public function actionUpdateStatus($id)
    {
        $task = Task::findOne($id);
        if ($this->validatePermission($task->id_user)) {
            if ($this->request->isPost) {
                $task->status = $this->request->post('status');
                if ($task->save()) {
                    Yii::$app->session->setFlash('taskSuccess', 'Cập nhập nhiệm vụ thành công.');
                } else {
                    Yii::$app->session->setFlash('taskError', 'Có lỗi xảy ra khi lưu dữ liệu.');
                }
            }
            return $this->redirect(['index']);
        }
    }

    public function actionDelete($id)
    {
        $task = Task::findOne($id);

        if ($this->validatePermission($task->id_user)) {
            $task->is_deleted = 1;
            if ($task->save()) {
                Yii::$app->session->setFlash('taskSuccess', 'Xóa nhiệm vụ thành công.');
            } else {
                Yii::$app->session->setFlash('taskError', 'Có lỗi xảy ra khi lưu dữ liệu.');
            }
            return $this->redirect(['index']);
        }
    }

    public function actionSearch()
    {
        $model_search = new TaskSearch();
        // $description = Yii::$app->request->get('description');
        // $dataProvider = $model_search->search(['description' => $description]);
        $dataProvider = $model_search->search(Yii::$app->request->queryParams);
        $tasks = $dataProvider ? $dataProvider->getModels() : [];

        return $this->render('index', [
            'tasks' => $tasks,
            'model' => new TaskForm(),
            'model_search' => $model_search,
        ]);
    }

    public function actionFilter()
    {
        $model_search = new TaskSearch();
        $dataProvider = $model_search->filter(Yii::$app->request->queryParams);
        $tasks = $dataProvider ? $dataProvider->getModels() : [];

        $filter = Yii::$app->request->queryParams['TaskSearch']['filter'];


        return $this->render('index', [
            'tasks' => $tasks,
            'model' => new TaskForm(),
            'model_search' => new TaskSearch(['filter' => $filter]),
        ]);
    }

    public function validatePermission($id_user)
    {
        if ($id_user !== Yii::$app->user->id) {
            throw new \yii\web\HttpException(403, 'You do not have permission to perform this action');
        } else {
            return true;
        }
    }
}
