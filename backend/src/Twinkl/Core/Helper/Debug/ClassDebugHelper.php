<?php


namespace Twinkl\Core\Helper\Debug;

use Exception;
use LogicException;
use ReflectionClass;
use ReflectionException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Helper\BaseHelper;

/**
 * Class ClassDebugHelper
 * @package Twinkl\Core\Helper\Debug
 * @property object|null $src
 * @method object|null getSource()
 * @method $this setSource(?object $src)
 */
class ClassDebugHelper extends BaseHelper
{
    /*
     * Properties
     */
    
    /**
     * @var ReflectionClass|null
     */
    protected $reflClass;
    
    /*
     * Init logic
     */
    
    /**
     * ClassHelper constructor.
     * @param string|null $src
     * @param ReflectionClass|null $reflClass
     */
    public function __construct(string $src = null, ReflectionClass $reflClass = null)
    {
        parent::__construct($src);
        $this->setReflectionClass($reflClass);
    }
    
    /*
     * Reflection logic
     */
    
    /**
     * @return ReflectionClass|null
     */
    public function getReflectionClass()
    {
        return $this->reflClass;
    }
    
    /**
     * @param ReflectionClass|null $reflClass
     * @return $this
     */
    public function setReflectionClass(?ReflectionClass $reflClass)
    {
        $this->reflClass = $reflClass;
        return $this;
    }
    
    /**
     * @return $this
     * @throws Exception|ReflectionException
     */
    public function buildRelectionClass()
    {
        if (!$this->src) {
            throw new LogicException('Source is not defined.', HttpConsts::CODE_SERVER_ERROR);
        }
        $this->reflClass = new ReflectionClass($this->src);
        return $this;
    }
    
    /*
     * Vars logic
     */
    
    /**
     * @param bool $requireParentPrivateVars
     * @param bool $asArrValues
     * @return array
     * @throws Exception|ReflectionException
     */
    public function returnVars(
        bool $requireParentPrivateVars = false,
        bool $asArrValues = false
    ) {
        if (!$this->reflClass) {
            throw new LogicException('Reflection class is not defined.', HttpConsts::CODE_SERVER_ERROR);
        }
        $classVars = $this->reflClass->getDefaultProperties();
        if ($requireParentPrivateVars) {
            $classVars = array_replace(
                $this->processReturnParentVars($this->reflClass),
                $classVars
            );
        }
        return $asArrValues ? array_values($classVars) : $classVars;
    }
    
    /**
     * @param bool $asArrValues
     * @return array
     * @throws Exception|ReflectionException
     */
    public function returnParentVars(bool $asArrValues = false) {
        if (!$this->reflClass) {
            throw new LogicException('Reflection class is not defined.', HttpConsts::CODE_SERVER_ERROR);
        }
        $classVars = $this->processReturnParentVars($this->reflClass);
        return $asArrValues ? array_values($classVars) : $classVars;
    }
    
    /**
     * @param ReflectionClass|null $reflClass
     * @return array
     * @throws Exception|ReflectionException
     */
    protected function processReturnParentVars(?ReflectionClass $reflClass) {
        if (!$reflClass) {
            return [];
        }
        $classVars = [];
        if ($parentReflClass = $reflClass->getParentClass()) {
            $classVars = array_replace(
                $this->processReturnParentVars($parentReflClass),
                $parentReflClass->getDefaultProperties()
            );
        }
        return $classVars;
    }
}
