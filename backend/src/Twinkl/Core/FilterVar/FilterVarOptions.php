<?php

namespace Twinkl\Core\FilterVar;

use Twinkl\Core\CustomTrait\Handler\Data\DataAssocArrayHandlerTrait;
use Twinkl\Core\InterfaceExt\IArrayable;

/**
 * Class FilterVarOptions
 * @package Twinkl\Core\FilterVar
 * @see https://www.php.net/manual/en/function.filter-var.php
 * @see https://www.php.net/manual/en/function.filter-var-array.php
 */
class FilterVarOptions implements IArrayable, \Iterator
{
    /*
     * Traits
     */
    
    use DataAssocArrayHandlerTrait;
    
    /*
     * Init logic
     */
    
    /**
     * FilterVarOptions constructor.
     * @param mixed|null $default
     * @param int|null $decimal
     * @param float|int|null $minRange
     * @param float|int|null $maxRange
     * @param string|null $regexp
     */
    public function __construct(
        $default = null,
        int $decimal = null,
        $minRange = null,
        $maxRange = null,
        string $regexp = null
    ) {
        $this
            ->setDataDefault($default)
            ->setDecimal($decimal)
            ->setMinRange($minRange)
            ->setMaxRange($maxRange)
            ->setRegexp($regexp);
    }
    
    /*
     * Data logic
     */
    
    public function getDefaultAll(): array
    {
        return [
            'default'       => null,
            'decimals'      => null,
            'min_range'     => null,
            'max_range'     => null,
            'regexp'        => null,
        ];
    }
    
    /*
     * Default logic
     */
    
    /**
     * @return mixed|null
     */
    public function getDataDefault()
    {
        return $this->get('default');
    }
    
    /**
     * @param mixed|null $default
     * @return $this
     */
    public function setDataDefault($default)
    {
        return $this->set('default', $default);
    }
    
    /*
     * Decimal logic
     */
    
    /**
     * @return int|null
     */
    public function getDecimal(): ?int
    {
        return $this->get('decimal');
    }
    
    /**
     * @param int|null $decimal
     * @return $this
     */
    public function setDecimal(?int $decimal)
    {
        return $this->set('decimal', $decimal);
    }
    
    /*
     * Min range logic
     */
    
    /**
     * @return int|float|null
     */
    public function getMinRange()
    {
        return $this->get('min_range');
    }
    
    /**
     * @param int|float|null $minRange
     * @return $this
     */
    public function setMinRange($minRange)
    {
        return $this->set('min_range', $minRange);
    }
    
    /*
     * Max range logic
     */
    
    /**
     * @return int|float|null
     */
    public function getMaxRange()
    {
        return $this->get('max_range');
    }
    
    /**
     * @param int|float|null $maxRange
     * @return $this
     */
    public function setMaxRange($maxRange)
    {
        return $this->set('max_range', $maxRange);
    }
    
    /*
     * Regexp logic
     */
    
    /**
     * @return string|null
     */
    public function getRegexp(): ?string
    {
        return $this->get('regexp');
    }
    
    /**
     * @param string|null $regexp
     * @return $this
     */
    public function setRegexp(?string $regexp)
    {
        return $this->set('regexp', $regexp);
    }
    
    /*
     * Array logic
     */
    
    public function toArray(): array
    {
        return $this->getAll();
    }
}
