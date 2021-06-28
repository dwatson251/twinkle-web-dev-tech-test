<?php
use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Dashboard\Widget\DashboardWidget;

$this->layout(TemplateConsts::FLD_LAYOUT . '::index', ['widget' => $widget]);

/** @var DashboardWidget $widget */
$widget;
?>

<div class="grid-block main">
    <div class="banner page-banner-block bg-blue">
        <img class="d-block m-auto" src="<?= $widget->getTwinklLogo() ?>" width="120" height="75" />
    </div>
    
    <div class="widget widget-block dash">
        <?php foreach ($widget->getUserWidgets() as $iUserWidget) : ?>
            <?= $this->insert(
                $iUserWidget->getTemplateName() ?? TemplateConsts::FLD_DASH . '::partial/user-edit',
                ['widget' => $iUserWidget]
            ) ?>
        <?php endforeach ?>
    </div>

    <div class="banner page-banner-block bg-blue">
    
    </div>
</div>