<div id="comments" class="inner-bottom-xs">
    <h2>Комментарии</h2>
    <?php use yii\bootstrap\Html;
    use yii\widgets\ActiveForm;

    foreach ($items as $item): ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <p class="comment-content">
                    <?= Yii::$app->formatter->asNtext($item->body) ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="reply-block" class="leave-reply">
    <?php $form = ActiveForm::begin([
        'action' => ['comment', 'id' => $task->id],
    ]); ?>

    <?= $form->field($commentForm, 'body')->textarea(['rows' => 5]) ?>
    <?= $form->field($commentForm, 'image')->fileInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить комментирий', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>