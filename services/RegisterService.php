<?php
namespace app\services;

use app\models\User;
use app\repositories\UserRepository;
use app\services\managers\RoleManager;


class RegisterService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleManager
     */
    private $roleManager;

    public function __construct(UserRepository $userRepository,RoleManager $roleManager)
    {
        $this->userRepository = $userRepository;
        $this->roleManager = $roleManager;
    }

    public function register($form)
    {
        $user = User::register($form->name, $form->email, $form->password);
        $this->userRepository->save($user);
        $this->roleManager->createUserRole($user->id);
    }
}