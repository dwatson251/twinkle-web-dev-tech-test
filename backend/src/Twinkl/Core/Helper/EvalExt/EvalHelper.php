<?php


namespace Twinkl\Core\Helper\EvalExt;

use Twinkl\Core\Consts\BoolConsts;
use Twinkl\Core\Helper\BaseHelper;

/**
 * Class EvalHelper
 * @package Twinkl\Core\Helper\EvalExt
 */
class EvalHelper extends BaseHelper
{
    /*
     * String logic
     */
    
    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        $src = $this->src;
    
        if (is_bool($src)) {
            return $src;
        }
        if (is_string($src)) {
            return $this->isEmptyStr();
        }
        if (is_numeric($src)) {
            return false;
        }
        return empty($src);
    }
    
    /*
     * String logic
     */
    
    /**
     * @return bool
     */
    public function isEmptyStr(): bool
    {
        return (
            $this->isNonBoolScalar()
            && trim($this->src) === ''
        );
    }
    
    /*
     * Number logic
     */
    
    /**
     * @return bool
     */
    public function isInt(): bool
    {
        return (
            is_numeric($this->src)
            && is_int($this->src + 0)
        );
    }
    
    /**
     * @return bool
     */
    public function isFloat(): bool
    {
        return (
            is_numeric($this->src)
            && is_float($this->src + 0)
        );
    }
    
    /*
     * Bool logic
     */
    
    /**
     * @return bool
     */
    public function isTruthy(): bool
    {
        return $this->returnBoolEval(BoolConsts::TRUTHY_ARR);
    }
    
    /**
     * @return string
     */
    public function isTruthyBoolIntStr(): string
    {
        return $this->isTruthy() ? BoolConsts::VAL_INT_STR_T : BoolConsts::VAL_INT_STR_F;
    }
    
    /**
     * @return bool
     */
    public function isFalsy(): bool
    {
        return $this->returnBoolEval(BoolConsts::FALSY_ARR);
    }
    
    /**
     * @param array $boolArr
     * @return bool
     */
    protected function returnBoolEval(array $boolArr)
    {
        return (
            in_array($this->src, $boolArr, true)
            || in_array(
                strtolower(
                    trim($this->src)
                ),
                $boolArr,
                true
            )
        );
    }
    
    /*
     * Scalar logic
     */
    
    /**
     * @return bool
     */
    public function isScalar(): bool
    {
        return is_scalar($this->src);
    }
    
    /**
     * @return bool
     */
    public function isNonBoolScalar(): bool
    {
        return (
            !is_bool($this->src)
            && is_scalar($this->src)
        );
    }
    
    /*
     * Isset logic
     */
    
    /**
     * @return bool
     */
    public function issetAll(): bool
    {
        if (!$this->src) {
            return false;
        }
        $isArr = is_array($this->src);
        $keys = array_keys($this->src);
        foreach ($keys as $iKey) {
            if (!$isArr) {
                if (!isset($this->src->$iKey)) {
                    return false;
                }
                continue;
            }
            if (!isset($this->src[$iKey])) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function issetAllAt(...$keys): bool
    {
        if (!$this->src) {
            return false;
        }
        $isArr = is_array($this->src);
        foreach ($keys as $iKey) {
            if (!$isArr) {
                if (!isset($this->src->$iKey)) {
                    return false;
                }
                continue;
            }
            if (!isset($this->src[$iKey])) {
                return false;
            }
        }
        return true;
    }
    
    /*
     * Exists logic
     */
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function existsAllAt(...$keys): bool
    {
        if (!$this->src) {
            return false;
        }
        $isArr = is_array($this->src);
        foreach ($keys as $iKey) {
            if (!$isArr) {
                if (!property_exists($this->src, $iKey)
                    && !method_exists($this->src, $iKey)
                ) {
                    return false;
                }
                continue;
            }
            if (!array_key_exists($iKey, $this->src)) {
                return false;
            }
        }
        return true;
    }
    
    /*
     * Empty logic
     */
    
    /**
     * @return bool
     */
    public function isEmptyAll(): bool
    {
        if (!$this->src) {
            return false;
        }
        $isArr = is_array($this->src);
        $keys = array_keys($this->src);
        foreach ($keys as $iKey) {
            if (!$isArr) {
                if (!empty($this->src->$iKey)) {
                    return false;
                }
                continue;
            }
            if (!empty($this->src[$iKey])) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function isEmptyAllAt(...$keys): bool
    {
        if (!$this->src) {
            return false;
        }
        $isArr = is_array($this->src);
        foreach ($keys as $iKey) {
            if (!$isArr) {
                if (!empty($this->src->$iKey)) {
                    return false;
                }
                continue;
            }
            if (!empty($this->src[$iKey])) {
                return false;
            }
        }
        return true;
    }
    
    /*
     * Null logic
     */
    
    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->src === null;
    }
}
