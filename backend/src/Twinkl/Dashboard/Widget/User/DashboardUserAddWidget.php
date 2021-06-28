<?php


namespace Twinkl\Dashboard\Widget\User;

use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Consts\UrlConsts;
use Twinkl\Core\Widget\BaseWidget;

/**
 * Class DashboardUserAddWidget
 * @package Twinkl\Dashboard\Widget\User
 */
class DashboardUserAddWidget extends BaseWidget
{
    /*
     * Properties
     */
    
    protected $templateName = TemplateConsts::FLD_DASH . '::partial/user-add';
    
    /*
     * Init logic
     */
    
    /**
     * DashboardUserAddWidget constructor.
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName ?? $this->templateName, $attrs, $config);
    }
    
    /*
     * URI logic
     */
    
    /**
     * @return array
     */
    public function getUris(): array
    {
        return $this->uris;
    }
    
    /**
     * @param array|null $uris
     * @return $this
     */
    public function setUris(?array $uris)
    {
        $this->uris = $uris ?? [];
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getCreateUri(): ?string
    {
        return $this->uris['create'] ?? null;
    }
    
    /**
     * @param string|null $createUri
     * @return $this
     */
    public function setCreateUri(?string $createUri)
    {
        $this->uris['create'] = $createUri;
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildUris()
    {
        return $this->setCreateUri(UrlConsts::URI_DASH_USERS_CREATE);
    }
}
