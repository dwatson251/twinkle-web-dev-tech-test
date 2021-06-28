<?php


namespace Twinkl\Core\Controller;

use Twinkl\Core\TemplateBuilder\LeaguePlates\RootLeaguePlatesTemplateBuilder;

/**
 * Class RootController
 * @package Twinkl\Core\Controller
 * @property RootLeaguePlatesTemplateBuilder|null $templateBuilder
 */
class RootController extends BaseController
{
    /*
     * Template builder logic
     */
    
    protected function buildTemplateBuilder()
    {
        $this->templateBuilder = (new RootLeaguePlatesTemplateBuilder())
            ->init();
        return $this;
    }
    
    /*
     * Render logic
     */
    
    public function render(string $templateName = null, array $data = null): string
    {
        $this->checkIssetTemplateBuilder();
        return $this->templateBuilder->render($templateName, $data);
    }
}
