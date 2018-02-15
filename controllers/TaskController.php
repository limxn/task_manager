<?php

namespace app\controllers;

use app\forms\CommentForm;
use app\forms\StatusForm;
use app\forms\TaskForm;
use app\models\Project;
use app\models\Task;
use app\models\TaskSearch;
use app\services\TaskService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{

    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct($id, $module, TaskService $taskService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->taskService = $taskService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index', 'view','comment'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['projectPanel'],
                        'roleParams' => function ($rule) {
                            return ['project' => $this->findProject(Yii::$app->request->get('project_id'))];
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex($project_id)
    {
        /** @var Project $project */
        $project = $this->findProject($project_id);
        $searchModel = new TaskSearch($project);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $project_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'project' => $project
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($project_id,$task_id)
    {
        /** @var Project $project */
        $project = $this->findProject($project_id);

        /** @var Task $model */
        $model = $this->findModel($task_id);
        $statusForm = new StatusForm($model);
        return $this->render('view', [
            'model' => $model,
            'project' => $project,
            'statusForm' => $statusForm
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($project_id)
    {
        /** @var Project $project */
        $project = $this->findProject($project_id);
        $model = new TaskForm($project);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try{
                $task  = $this->taskService->save($model,\Yii::$app->user->id);
                return $this->redirect(['view', 'project_id' => $project->id, 'task_id' => $task->id]);
            } catch (\Exception $ex){
                \Yii::$app->session->setFlash('error', $ex->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $model,
            'project' => $project
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($project_id,$task_id)
    {
        /** @var Task $model */
        $model = $this->findModel($task_id);

        /** @var Project $project */
        $project = $this->findProject($project_id);
        $form = new TaskForm($project,$model);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $form,
            'project' => $project,
            'task' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionComment($id)
    {
        /** @var Task $task */
        $task = $this->findModel($id);

        $model = new CommentForm($task,\Yii::$app->user->id);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            try{
                $this->taskService->saveComment($model,$task);
                \Yii::$app->session->setFlash('success', 'Коментарий успешно сохранен');
                return $this->redirect(['view', 'project_id' => $task->project->id, 'task_id' => $task->id]);
            } catch (\Exception $ex){
                \Yii::$app->session->setFlash('error', $ex->getMessage());
            }
        }
        return $this->render('comment', [
            'model' => $model,
            'task' => $task
        ]);
    }

    public function actionStatus($project_id,$task_id)
    {
        /** @var Task $task */
        $task = $this->findModel($task_id);
        $statusForm = new StatusForm($task,\Yii::$app->user);
        if($statusForm->load(\Yii::$app->request->post()) && $statusForm->validate()){
            try{
                $this->taskService->changeStatus($statusForm,\Yii::$app->user->id);
                \Yii::$app->session->setFlash('success', 'Статус изменен успешно сохранен');
            } catch (\Exception $ex){
                \Yii::$app->session->setFlash('error', $ex->getMessage());
            }
        }
        if($statusForm->hasErrors()){
            \Yii::$app->session->setFlash('error', $statusForm->getFirstErrors());
        }
        return $this->redirect(['view', 'project_id' => $task->project->id, 'task_id' => $task->id]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    private function findProject($id)
    {
        $model = Project::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
