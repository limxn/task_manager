<?php use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html; ?>
<?php
/** @var \app\models\Task $task */
$this->title = $task->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index', 'project_id' => $task->project->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="reply-block" class="leave-reply">
    <?php
    $form = ActiveForm::begin([
        'action' => ['comment', 'id' => $task->id],
    ]); ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 5]) ?>
    <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить комментирий', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>