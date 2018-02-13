<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 07.02.18
 * Time: 8:51
 */

namespace app\controllers;

use yii\web\Controller;

class ErrorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}