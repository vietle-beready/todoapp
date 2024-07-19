<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\UploadForm;
use \yii\web\HttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class GalleryController extends Controller
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
                            'actions' => ['upload', 'index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],

                ],

            ],
        );
    }

    public function actionUpload()
    {
        // Chỉ định domain hợp lệ
        $validDomain = $_ENV['VALID_DOMAIN'];

        $referer = Yii::$app->request->headers->get('referer');

        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);

            if ($refererHost !== $validDomain) {
                throw new HttpException(403, 'Invalid Domain.');
            }
        } else {
            throw new HttpException(403, 'No referer header.');
        }

        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                // Yii::$app->session->setFlash('success', 'Upload successful.');
                return $this->redirect(['/gallery']);  // Chuyển hướng đến trang gallery
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionIndex()
    {
        $user_name = Yii::$app->user->identity->name;
        $safe_user_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $user_name); // Thay thế ký tự không hợp lệ
        $userImageDirectory = Yii::getAlias("@webroot/$safe_user_name/uploads/webp/");

        $webpImages = [];
        if (!is_dir($userImageDirectory)) {
            return $this->render('gallery', [
                'webpImages' => $webpImages,
            ]);
        } else {
            // Lấy danh sách các file WebP có trong thư mục user
            $files = scandir($userImageDirectory);
            foreach ($files as $file) {
                $filePath = $userImageDirectory . $file;
                if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'webp') {
                    $webpImages[] = [
                        'name' => $file,
                        'url' => "@web/$safe_user_name/uploads/webp/" . $file,
                    ];
                }
            }
            return $this->render('gallery', [
                'webpImages' => $webpImages,
            ]);
        }
    }
}
