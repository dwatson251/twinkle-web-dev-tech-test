<?php
$widgetTitle = $widget->getTitle() ?? 'Oops! Something went wrong!';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $widgetTitle ?></title>
    </head>
    <body>
        <h1><?= $widgetTitle ?></h1>
        
        <?= $this->content() ?>
        
        <?php if ($widget->showDebug()) : ?>
            <?= $this->section('debug') ?>
        <?php endif ?>
    </body>
</html>