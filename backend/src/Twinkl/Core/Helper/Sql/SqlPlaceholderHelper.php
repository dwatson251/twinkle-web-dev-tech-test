<?php


namespace Twinkl\Core\Helper\Sql;


use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Helper\BaseHelper;
use Twinkl\Core\Helper\EvalExt\EvalHelper;

/**
 * Class SqlPlaceholderHelper
 * @package Twinkl\Core\Helper\Sql
 */
class SqlPlaceholderHelper extends BaseHelper
{
    /*
     * Properties
     */
    
    /**
     * @var array
     */
    protected $placeholders = [];
    /**
     * @var array
     */
    protected $params = [];
    
    /*
     * Placeholders logic
     */
    
    /**
     * @return string[]
     */
    public function getPlaceholders(): array
    {
        return $this->placeholders;
    }
    
    /**
     * @return string|null
     */
    public function getLastPlaceholder(): ?string
    {
        $placeholders = $this->placeholders;
        return array_pop($placeholders);
    }
    
    /**
     * @return string
     */
    public function toPlaceholderString(): string
    {
        return implode(',', $this->placeholders);
    }
    
    /*
     * Params logic
     */
    
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
    
    /**
     * @return mixed|null
     */
    public function getLastParams()
    {
        $placeholders = $this->placeholders;
        return array_pop($placeholders);
    }
    
    /*
     * Build logic
     */
    
    /**
     * @return $this
     * @throws Exception
     */
    public function build()
    {
        if ($this->getTriggerReset(true)) {
            $this->reset();
        }
        
        $evalHlpr = new EvalHelper($this->src);
        if ($evalHlpr->isNull()) {
            return $this;
        }
        
        if (is_array($this->src)) {
            return $this->parseArray($this->src);
        }
        
        if (!$evalHlpr->isNonBoolScalar()) {
            throw new LogicException('Unexpected value type.', HttpConsts::CODE_SERVER_ERROR);
        }
        
        return $this->appendValue($this->src);
    }
    
    /**
     * @param mixed $value
     * @return $this
     */
    protected function appendValue($value)
    {
        $this->placeholders[] = '?';
        $this->params[] = $value;
        return $this;
    }
    
    /**
     * @param array $srcArr
     * @return $this
     */
    protected function parseArray(array $srcArr)
    {
        array_push(
            $this->placeholders,
            ...array_fill(0, count($srcArr), '?')
        );
        array_push($this->params, ...$srcArr);
        return $this;
    }
    
    /*
     * Reset logic
     */
    
    /**
     * @return $this
     */
    public function reset()
    {
        $this->placeholders = [];
        return $this;
    }
    
    /**
     * @return bool|null
     */
    public function getTriggerReset(bool $asBool = false): ?bool
    {
        $triggerReset = $this->config['trigger_reset'] ?? null;
        return $asBool ? $triggerReset === true : $triggerReset;
    }
    
    /**
     * @param bool|null $triggerReset
     * @return $this
     */
    public function setTriggerReset(?bool $config)
    {
        $this->config['trigger_reset'] = $config;
        return $this;
    }
}
