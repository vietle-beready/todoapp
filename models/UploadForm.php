<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use WebPConvert\WebPConvert;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]|null
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, webp', 'maxFiles' => 10, 'maxSize' => 2 * 1024 * 1024],
        ];
    }


    public function upload()
    {


        if ($this->validate()) {
            $user_name = Yii::$app->user->identity->name;
            $path = Yii::getAlias("@webroot/$user_name/uploads/");
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            foreach ($this->imageFiles as $file) {
                $fileName = Yii::$app->security->generateRandomString(16) . '.' . $file->extension;
                $filePath = $path . $fileName;
                if ($file->saveAs($filePath)) {
                    $this->actionConvertToWebP($path, $fileName);
                } else {
                    Yii::error("Failed to save file '{$file->name}' to '{$filePath}'");
                    Yii::error($file->error);
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function actionConvertToWebP($path, $fileName)
    {
        // Đường dẫn đến thư mục lưu trữ ảnh WebP
        $webpImageDirectory = $path . '/webp/';

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!file_exists($webpImageDirectory)) {
            mkdir($webpImageDirectory, 0777, true);
        }

        // Đường dẫn đến tệp ảnh gốc
        $sourceImagePath = $path . $fileName; // Thay đổi đường dẫn và tên file ảnh gốc tùy theo dự án của bạn

        // Tạo tên tệp ảnh WebP mới
        $webpImageName = pathinfo($fileName, PATHINFO_FILENAME) . '.webp'; // Tên file ảnh WebP sau khi chuyển đổi
        $destinationImagePath = $webpImageDirectory . $webpImageName;

        // Cấu hình cho quá trình chuyển đổi
        $options = [
            'quality' => 80, // Chất lượng ảnh WebP, từ 0 (tệ nhất) đến 100 (tốt nhất)
        ];

        // Thực hiện chuyển đổi
        $result = WebPConvert::convert($sourceImagePath, $destinationImagePath, $options);

        // Kiểm tra và thông báo kết quả
        if ($result === true) {
            return true;
            Yii::$app->session->setFlash('success', 'Chuyển đổi ảnh sang WebP thành công.');
        } else {
            return false;
            Yii::$app->session->setFlash('error', 'Đã xảy ra lỗi khi chuyển đổi ảnh sang WebP: ' . $result);
        }
    }
}
