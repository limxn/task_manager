<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 012 12.02.18
 * Time: 22:51
 */

namespace app\services;


use app\dispatchers\EventDispatcher;
use app\events\NewTaskEvent;
use app\forms\CommentForm;
use app\forms\TaskForm;
use app\models\Comment;
use app\models\Task;
use app\repositories\TaskRepository;
use app\repositories\UserRepository;
use app\services\managers\ImageManager;

class TaskService
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ImageManager
     */
    private $imageManager;
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(TaskRepository $taskRepository,UserRepository $userRepository, ImageManager $imageManager,EventDispatcher $dispatcher)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->imageManager = $imageManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param TaskForm $form
     * @return Task
     */
    public function save(TaskForm $form,$userId)
    {
        $user = $this->userRepository->findById($form->user_id);
        if(empty($user)){
            throw new \Exception('Ошибка пользователя не существует');
        }
        /** @var Task $task */
        $task = Task::create($form->title, $form->body, $form->project_id, $form->user_id,$form->estimated_time);
        if($form->image){
            $task->addImage($this->imageManager->save($form->image));
        }
        $this->taskRepository->save($task);
        $this->dispatcher->dispatch(new NewTaskEvent($task,$userId));
        return $task;
    }


    /**
     * @param CommentForm $form
     * @param Task $task
     */
    public function saveComment(CommentForm $form, Task $task)
    {
        $comment = Comment::create($form->body);
        $task->addComment($comment);
        $this->taskRepository->save($task);
    }
}