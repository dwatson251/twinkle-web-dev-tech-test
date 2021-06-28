<?php $this->layout('error::layout/index', ['widget' => $widget]) ?>

<div>
    <?= $widget->renderMessage() ?>
</div>

<?php $this->section('debug') ?>
    <div class="debug-block">
        <?= $widget->renderDebug() ?>
    </div>
<?php $this->stop() ?>
