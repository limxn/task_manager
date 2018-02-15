<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Обновить задачу '.$task->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $task->title, 'url' => ['view', 'task_id' => $task->id,'project_id' => $project->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="task-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'user_id')->dropDownList($model->getUsers()) ?>

        <?= $form->field($model, 'estimated_time')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Обновить задачу', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>