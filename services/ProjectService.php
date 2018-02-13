<?php
namespace app\services;

use app\forms\project\ProjectUserJoinForm;
use app\models\Project;
use app\repositories\ProjectRepository;
use app\repositories\ProjectUserRepository;
use app\repositories\UserRepository;

class ProjectService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var ProjectUserRepository
     */
    private $projectUserRepository;

    public function __construct(UserRepository $userRepository,ProjectRepository $projectRepository, ProjectUserRepository $projectUserRepository)
    {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->projectUserRepository = $projectUserRepository;
    }

    /**
     * @param $form
     * @param Project $project
     * @throws \Exception
     */
    public function addUser(ProjectUserJoinForm $form, Project $project)
    {
        $user = $this->findUser($form->user_id);
        $project->add($user);
        $this->projectRepository->save($project);
    }

    /**
     * @param $form
     * @param Project $project
     * @throws \Exception
     */
    public function addAdmin($form, $project)
    {
        $user = $this->findUser($form->user_id);
        /** @var \app\models\ProjectUser $projectUser */
        $projectUser = $this->projectUserRepository->findNotAdminUser($project->id,$user->id);
        if(empty($projectUser)){
            throw new \Exception('Пользователь уже администратор проекта');
        }
        $projectUser->nowAdmin();
        $this->projectUserRepository->save($projectUser);
    }

    private function findUser($id)
    {
        $user = $this->userRepository->findById($id);
        if(empty($user)){
            throw new \Exception('Пользователь не найден');
        }
        return $user;
    }
}