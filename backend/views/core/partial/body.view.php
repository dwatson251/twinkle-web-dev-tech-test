<?php

use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Widget\Body\BodyWidget;

/** @var BodyWidget $widget */
$widget = $widget ?? new BodyWidget();
$h1Widget = $h1Widget ?? $widget->getH1();
?>

<body <?= $widget->renderAttrs() ?>>
    <?php if ($h1Widget) : ?>
        <h1 <?= $h1Widget->renderAttrs() ?>>
            <?= $h1Widget->renderContent() ?>
        </h1>
    <?php endif ?>

    <!-- START - Content -->
    <?= $content ?>
    <!-- END - Content -->
    
    <!-- START - Footer Scripts -->
    <?= $this->insert(
        $widget->getTemplateName() ?? TemplateConsts::FLD_PARTIAL . '::script-section',
        ['widgets' => $widget->returnScripts()]
    ) ?>
    <?= $this->section('footer-scripts') ?>
    <!-- END - Footer Scripts -->
</body>