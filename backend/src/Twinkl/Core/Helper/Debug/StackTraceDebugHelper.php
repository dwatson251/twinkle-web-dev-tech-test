<?php

namespace Twinkl\Core\Helper\Debug;

use Twinkl\Core\Debug\StackTraceItem;
use Twinkl\Core\Helper\BaseHelper;

/**
 * Class StackTraceDebugHelper
 * @package Twinkl\Core\Helper\Debug
 * @see https://www.php.net/manual/en/function.debug-backtrace.php
 */
class StackTraceDebugHelper extends BaseHelper
{
    /*
     * Build logic
     */
    
    /**
     * @param int|null $offset
     * @param int|null $limit
     * @param int|null $options
     * @return $this
     */
    public function build(int $offset = null, int $limit = null, int $options = null)
    {
        $stackTrace = debug_backtrace(
            $options ?? DEBUG_BACKTRACE_IGNORE_ARGS,
            $limit ?? 0
        );
        if ($offset !== null) {
            $stackTrace = array_slice($stackTrace, $offset);
        }
        $this->src = $stackTrace;
        return $this;
    }
    
    /*
     * Getter logic
     */
    
    /**
     * @return StackTraceItem[]|array
     */
    public function getAll()
    {
        return $this->getAsStackTraceItem(true) ?
            $this->parseStackTraceItems($this->src)
            : $this->src;
    }
    
    
    /**
     * @param int $offset
     * @param int|null $len
     * @return StackTraceItem[]|array
     */
    public function getAllAt(int $offset, int $len = null)
    {
        $stackTrace = array_slice($this->src, $offset, $len);
        if ($this->getAsStackTraceItem(true)) {
            $stackTrace = $this->parseStackTraceItems($stackTrace);
        }
        return $stackTrace;
    }
    
    /**
     * @param int $idx
     * @return StackTraceItem|array|null
     */
    public function getAt(int $idx)
    {
        $stackTraceItem = $this->src[$idx] ?? null;
        return $this->getAsStackTraceItem(true) ?
            $this->parseStackTraceItem($stackTraceItem)
            : $stackTraceItem;
    }
    
    /*
     * Stack trace item logic
     */
    
    /**
     * Returns previous stack trace item, from the call execution this method.
     * e.g. a.php -> b.php -> c.php -> returnPreviousStackTrace() = b.php stack trace.
     * @return StackTraceItem|array|null
     */
    public function returnPreviousStackTrace()
    {
        return $this->getAt(2);
    }
    
    /**
     * @param array $stItems
     * @return StackTraceItem[]
     */
    public function parseStackTraceItems(array $stItems): array
    {
        return array_map(
            function ($iStItem) {
                return $this->parseStackTraceItem($iStItem);
            },
            array_filter($stItems)
        );
    }
    
    /**
     * @param array|null $stItem
     * @return StackTraceItem|null
     */
    public function parseStackTraceItem(?array $stItem): ?StackTraceItem
    {
        if ($stItem === null) {
            return null;
        }
        return new StackTraceItem(
            $stItem['function'] ?? null,
            $stItem['args'] ?? null,
            $stItem['object'] ?? null,
            $stItem['class'] ?? null,
            $stItem['file'] ?? null,
            $stItem['line'] ?? null,
            $stItem['type'] ?? null
        );
    }
    
    /*
     * Config logic
     */
    
    /**
     * @return bool|null
     */
    public function getAsStackTraceItem(bool $asBool = false): ?bool
    {
        $asStackTraceItem = $this->config['as_stack_trace_item'] ?? null;
        return $asBool ? ($asStackTraceItem === true) : $asStackTraceItem;
    }
    
    /**
     * @param bool|null $asStackTraceItem
     * @return $this
     */
    public function setAsStackTraceItem(?bool $asStackTraceItem)
    {
        $this->config['as_stack_trace_item'] = $asStackTraceItem;
        return $this;
    }
}
