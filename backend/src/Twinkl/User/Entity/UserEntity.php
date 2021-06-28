<?php


namespace Twinkl\User\Entity;


use Twinkl\Core\Entity\BaseEntity;
use Twinkl\Core\Helper\EvalExt\EvalHelper;

/**
 * Class UserEntity
 * @package Twinkl\User\Config
 */
class UserEntity extends BaseEntity
{
    /*
     * Data logic
     */
    
    public function getDefaultAll(): array
    {
        return [
            'id'            => null,
            'firstname'     => null,
            'lastname'      => null,
            'active'        => null,
            'created_at'    => null,
            'updated_at'    => null,
        ];
    }
    
    /*
     * ID logic
     */
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->get('id');
    }
    
    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id)
    {
        return $this->set('id', $id);
    }
    
    /*
     * Firstname logic
     */
    
    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->get('firstname');
    }
    
    /**
     * @param string|null $firstname
     * @return $this
     */
    public function setFirstname(?string $firstname)
    {
        return $this->set('firstname', $firstname);
    }
    
    /*
     * Lastname logic
     */
    
    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->get('lastname');
    }
    
    /**
     * @param string|null $lastname
     * @return $this
     */
    public function setLastname(?string $lastname)
    {
        return $this->set('lastname', $lastname);
    }
    
    /*
     * Active logic
     */
    
    /**
     * @return string|bool||null
     */
    public function getActive(bool $asBool = false)
    {
        $active = $this->get('active');
        return $asBool ? (int) $active === 1 : $active;
    }
    
    /**
     * @param string|bool|null $active
     * @return $this
     */
    public function setActive($active)
    {
        if ($active !== null) {
            $active = (new EvalHelper($active))->isTruthyBoolIntStr();
        }
        return $this->set('active', $active);
    }
    
    /*
     * Created at logic
     */
    
    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->get('created_at');
    }
    
    /**
     * @param string|null $createdAt
     * @return $this
     */
    public function setCreatedAt(?string $createdAt)
    {
        return $this->set('created_at', $createdAt);
    }
    
    /*
     * Updated at logic
     */
    
    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->get('updated_at');
    }
    
    /**
     * @param string|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?string $updatedAt)
    {
        return $this->set('updated_at', $updatedAt);
    }
}
