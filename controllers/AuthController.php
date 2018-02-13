<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 011 11.02.18
 * Time: 19:40
 */

namespace app\controllers;

use app\decorators\UserIdentityDecorator;
use app\forms\LoginForm;
use app\services\AuthServices;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    /**
     * @var AuthServices
     */
    private $authServices;

    public function __construct($id, $module, AuthServices $authServices , array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authServices = $authServices;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try{
                $user = $this->authServices->login($model);
                Yii::$app->user->login(new UserIdentityDecorator($user), $model->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->redirect(['project/index']);
            }catch (\Exception $ex){
                Yii::$app->session->setFlash('error', 'Ошибка входа, попробуйте еще раз');
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}