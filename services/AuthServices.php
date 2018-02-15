<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 011 11.02.18
 * Time: 19:48
 */

namespace app\services;


use app\models\User;
use app\repositories\UserRepository;

class AuthServices
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($form)
    {
        /** @var User $user */
        $user = $this->userRepository->findByEmail($form->email);
        if(empty($user)){
            throw new \Exception('Пользователь не найден или не верный пароль');
        }
        if(!$user->validatePassword($form->password)){
            throw new \Exception('Пользователь не найден или не верный пароль');
        }
        return $user;
    }
}