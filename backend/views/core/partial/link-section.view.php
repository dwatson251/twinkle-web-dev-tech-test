<?php

use Twinkl\Core\Widget\Link\LinkWidget;

/** @var LinkWidget[]|string[] $widgets */
$widgets;
?>

<?php foreach ($widgets as $iLinkWidget) : ?>
    <?php if (is_string($iLinkWidget)) : ?>
        <link href="<?= $iLinkWidget ?>">
    <?php else : ?>
        <link <?= $iLinkWidget->renderAttrs() ?>>
    <?php endif ?>
<?php endforeach ?>