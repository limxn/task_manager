<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskSearch represents the model behind the search form of `app\models\Task`.
 */
class TaskSearch extends Model
{
    /**
     * @inheritdoc
     */

    public $id;
    public $project_id;
    public $user_id;
    public $status_id;
    public $estimated_time;
    public $title;
    public $body;


    private $project;


    /**
     * TaskSearch constructor.
     * @param Project $project
     * @param array $config
     */
    public function __construct(Project $project, array $config = [])
    {
        $this->project = $project;
        $this->project_id = $project->id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['id', 'project_id', 'user_id', 'status_id', 'estimated_time'], 'integer'],
            [['title', 'body'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        $query->innerJoinWith(['project']);
        $query->where(['project_id' => $this->project_id]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
            'estimated_time' => $this->estimated_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
