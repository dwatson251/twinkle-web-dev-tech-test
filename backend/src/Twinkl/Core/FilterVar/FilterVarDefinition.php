<?php


namespace Twinkl\Core\FilterVar;

use Exception;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\CustomTrait\Handler\Data\DataAssocArrayHandlerTrait;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\InterfaceExt\IArrayable;

/**
 * Class FilterVarDefinition
 * @package Twinkl\Core\FilterVar
 * @see https://www.php.net/manual/en/function.filter-var.php
 * @see https://www.php.net/manual/en/function.filter-var-array.php
 */
class FilterVarDefinition implements IArrayable
{
    /*
     * Traits
     */
    
    use DataAssocArrayHandlerTrait;
    
    /*
     * Init logic
     */
    
    /**
     * FilterVarDefinition constructor.
     * @param int|null $filter
     * @param null $options
     * @param int|null $flags
     * @throws Exception
     */
    public function __construct(int $filter = null, $options = null, int $flags = null)
    {
        $this
            ->setFilter($filter)
            ->setOptions($options)
            ->setFlags($flags);
    }
    
    /*
     * Data logic
     */
    
    public function getDefaultAll(): array
    {
        return [
            'filter'    => null,
            'options'   => null,
            'flags'     => null,
        ];
    }
    
    /*
     * Filter logic
     */
    
    /**
     * @return int|null
     */
    public function getFilter(): ?int
    {
        return $this->get('filter');
    }
    
    /**
     * @param int|null $filter
     * @return $this
     */
    public function setFilter(?int $filter)
    {
        return $this->set('filter', $filter);
    }
    
    /*
     * Options logic
     */
    
    /**
     * @return FilterVarOptions|callable|null
     */
    public function getOptions()
    {
        return $this->get('options');
    }
    
    /**
     * @param FilterVarOptions|callable|null $options
     * @return $this
     * @throws Exception
     */
    public function setOptions($options)
    {
        if ($options !== null
            && !is_callable($options)
            && !($options instanceof FilterVarOptions)
        ) {
            $fvOptsClass = FilterVarOptions::class;
            throw new ExceptionExt(
                'Invalid options.',
                HttpConsts::CODE_SERVER_ERROR,
                "options is not null / callable / {$fvOptsClass}.",
                "null / callable / {$fvOptsClass}."
            );
        }
        $this->set('options', $options);
        return $this;
    }
    
    /*
     * Flags logic
     */
    
    /**
     * @return int|null
     */
    public function getFlags(): ?int
    {
        return $this->get('flags');
    }
    
    /**
     * @param int|null $flags
     * @return $this
     */
    public function setFlags(?int $flags)
    {
        return $this->set('flags', $flags);
    }
    
    /*
     * Array logic
     */
    
    public function toArray(): array
    {
        return $this->getAll();
    }
}
