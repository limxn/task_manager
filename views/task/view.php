<?php

use app\models\Task;
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
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
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
            'image_path:image',
            [
                'label' => 'Назначена',
                'value' => $model->user->name
            ],
            'status_id',
            'estimated_time',
        ],
    ]) ?>

    <?=\app\widgets\CommentWidget::widget([
        'task' => $model
    ])?>
</div>
