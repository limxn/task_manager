<?php

namespace tests\form;

use app\models\LoginForm;
use Codeception\Specify;
use Yii;

class LoginFormTest extends \Codeception\Test\Unit
{

    public function testEmptyForm()
    {
        $form = new LoginForm();
        expect($form->validate())->false();
    }

    public function testNotSetPassswordForm()
    {
        $form = new LoginForm([
            'username' => 'admin',
            'password' => '',
        ]);
        expect($form->validate())->false();
        expect('erro message password', $form->errors)->hasKey('password');
    }

    public function testNotSetUserForm()
    {
        $form = new LoginForm([
            'username' => '',
            'password' => 'admin',
        ]);
        expect($form->validate())->false();
        expect('error message user name', $form->errors)->hasKey('username');
    }

    public function testSuccessValidate()
    {
        $form = new LoginForm([
            'username' => 'admin',
            'password' => 'admin',
        ]);
        expect($form->validate())->true();
        expect('error message user name', $form->errors)->hasntKey('username');}

}
