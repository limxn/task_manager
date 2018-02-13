<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи проекта('.$project->name.')';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Html::a('Добавить пользователя', ['create','project_id' => $project->id], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Добавить администратора', ['admin','project_id' => $project->id], ['class' => 'btn btn-success']) ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'label' => 'Пользователь',
                    'value' => function($model){
                        return $model->user->name;
                    }
            ],
            [
                    'label' => 'Администратор',
                    'value' => function ($model) {
                        if($model->is_admin){
                            return 'Администратор проекта';
                        }
                    }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
