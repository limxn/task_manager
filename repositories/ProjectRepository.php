<?php
namespace app\repositories;

use app\models\Project;
use yii\base\InvalidCallException;

class ProjectRepository
{
    public function save(Project $project)
    {
        if(!$project->save()){
            throw new \Exception('Ошибка создания проекта');
        }
    }
}