<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(\Yii::$app->user->can('projectPanel')):?>

        <p>
            <?= Html::a('Задачи', ['task/index','project_id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Пользователи проекта', ['project-user/index','project_id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы точно хотите удалить элемент?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif;?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
