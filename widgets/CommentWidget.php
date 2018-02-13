<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 13.02.18
 * Time: 11:58
 */

namespace app\widgets;


use app\forms\CommentForm;
use app\models\Task;
use yii\bootstrap\Widget;

class CommentWidget extends Widget
{
    /**
     * @var Task
     */
    public $task;

    public function run()
    {
        $form = new CommentForm($this->task,\Yii::$app->user->id);

        $comments = $this->task->getComments()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        return $this->render('comments/index', [
            'task' => $this->task,
            'items' => $comments,
            'commentForm' => $form,
        ]);
    }

}