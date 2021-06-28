<?php


namespace Twinkl\Core\Parser\Entity;


use Exception;
use LogicException;
use ReflectionClass;
use ReflectionException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Entity\IEntity;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Parser\BaseParser;

/**
 * Class EntityParser
 * @package Twinkl\Core\Parser\Config
 */
class EntityParser extends BaseParser
{
    /*
     * Properties
     */
    
    /**
     * @var string|null
     */
    protected $entClass;
    
    /*
     * Init logic
     */
    
    /**
     * EntityParser constructor.
     * @param null|mixed $value
     * @param null|mixed $defValue
     * @param string|null $entClass
     * @param string|null $prop
     * @param null|mixed $context
     * @param array|null $config
     */
    public function __construct(
        $value = null,
        $defValue = null,
        string $entClass = null,
        string $prop = null,
        $context = null,
        array $config = null
    ) {
        parent::__construct($value, $defValue, $prop, $context, $config);
        $this->setEntityClass($entClass);
    }
    
    /*
     * Config logic
     */
    
    /**
     * @return string|null
     */
    public function getEntityClass(): ?string
    {
        return $this->entClass;
    }
    
    /**
     * @param string|null $entClass
     * @return $this
     */
    public function setEntityClass(?string $entClass)
    {
        $this->entClass = $entClass;
        return $this;
    }
    
    /*
     * Config logic
     */
    
    /**
     * @param bool $asBool
     * @return bool|null
     */
    public function getTriggerClean(bool $asBool = false): ?bool
    {
        $triggerClean = $this->config['trigger_clean'] ?? null;
        return $asBool ? $triggerClean === true : $triggerClean;
    }
    
    /**
     * @param bool|null $triggerClean
     * @return $this
     */
    public function setTriggerClean(?bool $triggerClean)
    {
        $this->config['trigger_clean'] = $triggerClean;
        return $this;
    }
    
    /*
     * Parse logic
     */
    
    public function parse()
    {
        try {
            $this->reset();
            $this->validateEntityClass();
            $this->value = $this->processParse($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? ($this->entClass ?? 'entity');
            $this->ex = new ParseException(
                "Unable to parse {$prop}.",
                HttpConsts::CODE_SERVER_ERROR,
                "{$prop} is not null / array / entity / {$this->entClass}.",
                "null / array / entity / {$this->entClass}.",
                $this->value,
                $prop,
                $this->context
            );
            throw $this->ex;
        }
    }
    
    /**
     * @param mixed $value
     * @return IEntity|null
     * @throws Exception
     */
    protected function processParse($value): ?IEntity
    {
        if ($value === null) {
            return $this->defValue;
        }
        if ($value instanceof IEntity) {
            $ent = $this->processParseEntity($value);
        } elseif (is_array($value)) {
            $ent = $this->processParseArray($value);
        }
        if ($ent) {
            if ($this->getTriggerClean(true)) {
                $ent->cleanData();
            }
            return $ent;
        }
        
        throw new LogicException('Unexpected value type.', HttpConsts::CODE_SERVER_ERROR);
    }
    
    /**
     * @param IEntity $value
     * @return IEntity
     */
    protected function processParseEntity(IEntity $value): IEntity
    {
        return new $this->entClass($value->getAll());
    }
    
    /**
     * @param array $value
     * @return IEntity
     */
    protected function processParseArray(array $value): IEntity
    {
        return new $this->entClass($value);
    }
    
    /**
     * @return bool
     * @throws Exception|ReflectionException
     */
    protected function validateEntityClass(): bool
    {
        if (!$this->entClass) {
            throw new LogicException('Config class is not defined.', HttpConsts::CODE_SERVER_ERROR);
        }
        
        $reflClass = new ReflectionClass($this->entClass);
        if (!$reflClass->implementsInterface(IEntity::class)) {
            throw new ReflectionException(
                'Config class does not implement ' . IEntity::class . '.',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        
        return true;
    }
}
