<?php

namespace app\models\projectuser;
use app\models\Project;
use app\models\ProjectUser;
use app\models\User;
use yii\data\ActiveDataProvider;

class ProjectUserSearch extends \yii\base\Model
{
    /**
     * @var Project
     */
    private $project;

    public function __construct(Project $project, array $config = [])
    {
        parent::__construct($config);
        $this->project = $project;
    }

    public function search($params)
    {
        $query = ProjectUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->innerJoinWith(['user'],false);
        // grid filtering conditions
        $query->where([
            'project_id' => $this->project->id,
        ]);

        return $dataProvider;
    }
}