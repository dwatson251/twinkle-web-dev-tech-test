<?php

use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Widget\Layout\LayoutWidget;

/** @var LayoutWidget $widget */
$widget;
$headWidget = $widget->getHead();
$headWidgetTemplName = $headWidget ? $headWidget->getTemplateName() : null;
$bodyWidget = $widget->getBody();
$bodyWidgetTemplName = $bodyWidget ? $bodyWidget->getTemplateName() : null;
?>

<!DOCTYPE html>
<html lang="en">
    <?= $this->insert(
        $headWidgetTemplName ?? TemplateConsts::FLD_PARTIAL . '::head',
        ['widget'       => $widget->getHead()]
    ) ?>
    
    <?= $this->insert(
        $bodyWidgetTemplName ?? TemplateConsts::FLD_PARTIAL . '::body',
        [
            'widget'    => $widget->getBody(),
            'content'   => $this->section('content'),
        ]
    ) ?>
</html>