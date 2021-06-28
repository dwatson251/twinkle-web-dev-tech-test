<?php


namespace Twinkl\Dashboard\Widget\User;


use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Consts\UrlConsts;
use Twinkl\Core\Widget\BaseWidget;

class DashboardUserCreateWidget extends BaseWidget
{
    /*
     * Properties
     */
    
    protected $templateName = TemplateConsts::FLD_DASH . '::partial/user-create';
    /**
     * @var array|null
     */
    protected $user;
    
    /*
     * Init logic
     */
    
    /**
     * DashboardUserCreateWidget constructor.
     * @param array|null $user
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        array $user = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName ?? $this->templateName, $attrs, $config);
        $this->setUser($user);
    }
    
    /*
     * User logic
     */
    
    /**
     * @return array|null
     */
    public function getUser(): ?array
    {
        return $this->user;
    }
    
    /**
     * @param array|null $user
     * @return $this
     */
    public function setUser(?array $user)
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->user['id'] ?? null;
    }
    
    /**
     * @param int|null $userId
     * @return $this
     */
    public function setId(?int $userId)
    {
        $this->user['id'] = $userId;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->user['firstname'] ?? null;
    }
    
    /**
     * @param string|null $firstname
     * @return $this
     */
    public function setFirstname(?string $firstname)
    {
        $this->user['firstname'] = $firstname;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->user['lastname'] ?? null;
    }
    
    /**
     * @param string|null $lastname
     * @return $this
     */
    public function setLastname(?string $lastname)
    {
        $this->user['lastname'] = $lastname;
        return $this;
    }
}