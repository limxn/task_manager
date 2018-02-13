<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 07.02.18
 * Time: 8:51
 */

namespace app\controllers;

use app\forms\RegisterForm;
use app\services\RegisterService;
use yii\web\Controller;

class RegistrationController extends Controller
{
    /**
     * @var RegisterService
     */
    private $registerService;

    public function __construct($id, $module, RegisterService $register, array $config = [])
    {
        $this->registerService = $register;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex()
    {
        $form = new RegisterForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->registerService->register($form);
                \Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались');
                return $this->goBack();
            } catch (\Exception $ex) {
                \Yii::$app->session->setFlash('error', $ex->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
        ]);
    }
}