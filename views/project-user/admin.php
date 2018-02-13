<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $project app\models\Project */
/* @var $model app\forms\project\ProjectAddAdminForm */

$this->title = 'Назначить администратора';
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index', 'project_id' => $project->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
