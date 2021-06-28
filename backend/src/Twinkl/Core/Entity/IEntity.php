<?php

namespace Twinkl\Core\Entity;


use Exception;
use Twinkl\Core\CustomTrait\Handler\Data\DataAssocArrayHandlerTrait;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Exception\SanitiseException;
use Twinkl\Core\InterfaceExt\IDataHandler;
use Twinkl\Core\InterfaceExt\ISanitisable;

/**
 * Class BaseEntity
 * @package Twinkl\Core\Config
 */
interface IEntity extends IDataHandler
{
    /**
     * @return array
     */
    public function toArray(): array;
    
    /**
     * @return string|null
     * @throws Exception
     */
    public function toJson();
    
    /**
     * @return $this
     */
    public function resetData();
    
    /**
     * @return $this
     */
    public function clearData();
    
    /**
     * @return $this
     */
    public function cleanData();
}
