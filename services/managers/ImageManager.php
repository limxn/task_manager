<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 012 12.02.18
 * Time: 23:09
 */

namespace app\services\managers;


use yii\web\UploadedFile;

class ImageManager
{
    private $path;

    public function __construct()
    {
        $this->path = \Yii::getAlias('@app/web');
    }

    public function save(UploadedFile $image)
    {
        $path = $this->path.'/'.$this->viewPath($image);
        $image->saveAs($path);
        return $this->viewPath($image);
    }

    private function viewPath($image)
    {
        return '/uploads/'.$image->baseName . '.' . $image->extension;
    }
}