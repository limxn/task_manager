<?php

namespace app\forms;

use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['email','email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Электронный адрес',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить'
        ];
    }
}
