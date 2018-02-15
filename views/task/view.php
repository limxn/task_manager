<?php

use app\models\Task;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index','project_id' => $project->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(\Yii::$app->user->can('projectPanel',['project' => $project])):?>
        <?= Html::a('Обновить', ['update', 'project_id' => $project->id,'task_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete','project_id' => $project->id,'task_id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'body:ntext',
            [
                'label' => 'Проект',
                'value' => $model->project->name
            ],
            [
                'attribute'=>'image_path',
                'value'=> Yii::$app->homeUrl.'uploads/'.$model->image_path,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],
            [
                'label' => 'Назначена',
                'value' => $model->user->name
            ],
            [
                'attribute' => 'status',
                'label' => 'Стату',
                'value' => \app\utils\StatusUtils::getStatusById($model->status_id)['name']
            ],
            'estimated_time',
        ],
    ]) ?>

    <div id="status-block">
        <?php $form = ActiveForm::begin([
            'action' => ['status', 'task_id' => $model->id,'project_id' => $project->id],
        ]); ?>

        <?= /** @var \app\forms\StatusForm $statusForm */
        $form->field($statusForm, 'status_id')->dropDownList($statusForm->getStatus()) ?>

        <div class="form-group">
            <?= Html::submitButton('Обновить статус', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <?=\app\widgets\TaskLogWidget::widget([
        'task' => $model
    ])?>
    <?=\app\widgets\CommentWidget::widget([
        'task' => $model
    ])?>
</div>
