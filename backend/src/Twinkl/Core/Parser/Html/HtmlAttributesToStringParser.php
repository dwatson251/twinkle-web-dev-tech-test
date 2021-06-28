<?php


namespace Twinkl\Core\Parser\Html;

use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Consts\RegexConsts;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\EvalExt\EvalHelper;
use Twinkl\Core\Parser\BaseParser;


class HtmlAttributesToStringParser extends BaseParser
{
    /*
     * Config logic
     */
    
    /**
     * @return string|null
     */
    public function getAttrValueDelim(): ?string
    {
        return $this->config['attr_val_delim'] ?? null;
    }
    
    /**
     * @param string|null $delim
     * @return $this
     */
    public function setAttrValueDelim(?string $delim)
    {
        $this->config['attr_val_delim'] = $delim;
        return $this;
    }
    
    /*
     * Parse logic
     */
    
    public function parse()
    {
        try {
            $this->reset();
            $this->value = $this->processParse($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? 'HTML attributes to string';
            throw new ParseException(
                'Unable to parse html attributs to string.',
                $ex->getCode(),
                $ex->getMessage(),
                'null / array.',
                $this->value,
                $prop,
                $this->context,
                $ex
            );
        }
    }
    
    /**
     * @param mixed $value
     * @return string|null
     */
    protected function processParse($value): ?string
    {
        if ($value === null) {
            return $this->defValue;
        }
        
        if (!is_array($value)) {
            throw new LogicException('Value is not an array.', HttpConsts::CODE_SERVER_ERROR);
        }
    
        $return = [];
        foreach ($value as $iKey => $iVal) {
            if (trim($iKey) === '') {
                continue;
            }
            $return[] = $this->parseKeyValue($iKey, $iVal);
        }
    
        return implode(' ', $return);
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    protected function parseKeyValue($key, $value)
    {
        if (trim($key) === '') {
            throw new LogicException('Key is not defined!', HttpConsts::CODE_SERVER_ERROR);
        }
        
        if (is_array($value)) {
            return $this->returnArrayAttr($key, $value);
        }
        
        $value = $value ?? true;
        if (is_bool($value)) {
            return $this->returnBoolAttr($key, $value);
        }
        
        return $this->returnAttr($key, $value);
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    public function returnAttr($key, $value)
    {
        return "{$this->formatAttrKey($key)}=\"{$this->formatAttrKey($value)}\"";
    }
    
    /*
     * Array attr logic
     */
    
    /**
     * @param string $key
     * @param array $value
     * @return string
     */
    public function returnArrayAttr($key, array $value)
    {
        return $this->returnAttr(
            $key,
            implode(
                $this->getAttrValueDelim() ?? ',',
                $value
            )
        );
    }
    
    /*
     * Bool attr logic
     */
    
    /**
     * @param string $key
     * @param bool $value
     * @return string
     */
    protected function returnBoolAttr($key, bool $value)
    {
        return $value ? $this->formatAttrKey($key) : '';
    }
    
    /*
     * Format logic
     */
    
    /**
     * @param string $key
     * @return string
     */
    protected function formatAttrKey($key): string
    {
        if (($key = trim($key)) === '') {
            return '';
        }
        $key = preg_replace(RegexConsts::NEWLINE, '', $key);
        $key = preg_replace(RegexConsts::SPACES_GT_1, ' ', $key);
        return htmlspecialchars($key);
    }
    
    /**
     * @param string $value
     * @return string
     */
    protected function formatAttrValue($value): string
    {
        return htmlspecialchars($value);
    }
}
