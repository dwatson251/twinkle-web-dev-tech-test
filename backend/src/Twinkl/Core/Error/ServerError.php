<?php


namespace Twinkl\Core\Error;

/**
 * Class ServerError
 * @package Twinkl\Core\Error
 * @see https://www.php.net/manual/en/function.set-error-handler.php
 */
class ServerError
{
    /*
     * Properties
     */
    
    /**
     * Error level / No.
     * $errno error_handler argument.
     * @var int|null
     */
    protected $level;
    /**
     * Error message / string.
     * $errstr error_handler argument.
     * @var string|null
     */
    protected $message;
    /**
     * Error filename / file.
     * $errfile error_handler argument.
     * @var string|null
     */
    protected $filename;
    /**
     * Error line.
     * $errline error_handler argument.
     * @var int|null
     */
    protected $line;
    
    /*
     * Init logic
     */
    
    public function __construct(
        int $level,
        string $message,
        string $filename = null,
        int $line = null
    ) {
        $this->level = $level;
        $this->message = $message;
        $this->filename = $filename;
        $this->line = $line;
    }
    
    /*
     * No. / Level logic
     */
    
    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
    
    /*
     * String / Message logic
     */
    
    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /*
     * File logic
     */
    
    /**
     * @return string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    /*
     * Line logic
     */
    
    /**
     * @return int|null
     */
    public function getLine()
    {
        return $this->line;\ErrorException::()
    }
}