<?php


namespace Twinkl\Core\Entity;


use Exception;
use Iterator;
use Serializable;
use Twinkl\Core\CustomTrait\Handler\{CloneHandlerTrait,
    Data\DataAssocArrayHandlerTrait,
    Iterator\ArrayIteratorHandlerTrait,
    SerialiseHandlerTrait};
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\InterfaceExt\IArrayable;
use Twinkl\Core\InterfaceExt\ISanitisable;
use Twinkl\Core\Parser\Entity\EntityParser;

/**
 * Class BaseEntity
 * @package Twinkl\Core\Config
 */
class BaseEntity implements
    IEntity,
    Serializable,
    Iterator,
    IArrayable
{
    /*
     * Traits
     */
    
    use DataAssocArrayHandlerTrait,
        CloneHandlerTrait,
        SerialiseHandlerTrait,
        ArrayIteratorHandlerTrait;
    
    /*
     * Init logic
     */
    
    /**
     * BaseEntity constructor.
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->setAll($data ?? $this->getDefaultAll());
    }
    
    /*
     * Setter logic
     */
    
    public function setAll(?array $data)
    {
        $data = $data ?? [];
        if (!is_array($data)) {
            $data = static
                ::parseInst($data)
                ->getAll();
        }
        $this->data = $data;
        return $this;
    }
    
    /*
     * Iterator logic
     */
    
    protected function getIteratorData(): array
    {
        return $this->data;
    }
    
    /*
     * Array logic
     */
    
    public function toArray(): array
    {
        return $this->data;
    }
    
    /*
     * Parse logic
     */
    
    /**
     * @param mixed $inst
     * @return static|null
     * @throws ParseException
     */
    public static function parseInst($inst)
    {
        return (new EntityParser($inst, null, static::class))
            ->parse()
            ->getValue();
    }
}
