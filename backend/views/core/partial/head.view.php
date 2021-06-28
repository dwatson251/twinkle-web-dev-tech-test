<?php

use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Widget\Head\HeadWidget;
use Twinkl\Core\Widget\Text\TextWidget;

/** @var HeadWidget $widget */
$widget = $widget ?? new HeadWidget();
$titleWidget = $titleWidget ?? ($widget->getTitle() ?? new TextWidget('Twinkl Test Site'));
?>

<head <?= $widget->renderAttrs() ?>>
    <title><?= $titleWidget->renderContent() ?></title>
    
    <!-- START - Header Links -->
    <?= $this->insert(
        $widget->getTemplateName() ?? TemplateConsts::FLD_PARTIAL . '::link-section',
        ['widgets' => $widget->returnLinks()]
    ) ?>
    <?= $this->section('header-links') ?>
    <!-- END - Header Links -->
    
    <!-- START - Header Scripts -->
    <?= $this->insert(
        $widget->getTemplateName() ?? TemplateConsts::FLD_PARTIAL . '::script-section',
        ['widgets' => $widget->returnScripts()]
    ) ?>
    <?= $this->section('header-scripts') ?>
    <!-- END - Header Scripts -->
</head>