<?php

use Twinkl\Core\Widget\Script\ScriptWidget;

/** @var ScriptWidget[]|string[] $widgets */
$widgets;
?>

<?php foreach ($widgets as $iScriptWidget) : ?>
    <?php if (is_string($iScriptWidget)) : ?>
        <script src="<?= $iScriptWidget ?>"></script>
    <?php else : ?>
        <script <?= $iScriptWidget->renderAttrs() ?>><?= $iScriptWidget->renderContent() ?></script>
    <?php endif ?>
<?php endforeach ?>