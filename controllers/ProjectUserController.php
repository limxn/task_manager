<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 011 11.02.18
 * Time: 23:47
 */

namespace app\controllers;

use app\forms\project\ProjectAddAdminForm;
use app\forms\project\ProjectUserJoinForm;
use app\models\Project;
use app\models\projectuser\ProjectUserSearch;
use app\services\ProjectService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProjectUserController extends Controller
{

    /**
     * @var ProjectService
     */
    private $projectService;

    public function __construct($id, $module, ProjectService $projectService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->projectService = $projectService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['projectPanel'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($project_id)
    {
        $project = $this->findProject($project_id);
        $searchModel = new ProjectUserSearch($project);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'project' => $project
        ]);
    }

    private function findProject($id)
    {
        $model = Project::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

    public function actionCreate($project_id)
    {
        $project = $this->findProject($project_id);
        $form = new ProjectUserJoinForm($project);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->projectService->addUser($form, $project);
                return $this->redirect(['index', 'project_id' => $project->id]);
            } catch (\Exception $ex) {
                \Yii::$app->session->setFlash('error', $ex->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form, 'project' => $project
        ]);
    }

    public function actionAdmin($project_id)
    {
        $project = $this->findProject($project_id);
        $form = new ProjectAddAdminForm($project);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->projectService->addAdmin($form, $project);
                return $this->redirect(['index', 'project_id' => $project->id]);
            } catch (\Exception $ex) {
                \Yii::$app->session->setFlash('error', $ex->getMessage());
            }
        }
        return $this->render('admin', [
            'model' => $form, 'project' => $project
        ]);
    }
}