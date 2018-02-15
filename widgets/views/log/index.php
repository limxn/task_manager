<?php if($items):?>
<div id="task-log" class="inner-bottom-xs">
    <h2>История задач</h2>
        <?php
        /** @var \app\utils\TaskLogPresenter $item */
        foreach ($items as $item): ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        <?=$item->name()?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
</div>
<?php endif;?>
