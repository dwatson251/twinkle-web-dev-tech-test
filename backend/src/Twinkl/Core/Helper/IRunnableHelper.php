<?php

namespace Twinkl\Core\Helper;

use Exception;
use Twinkl\Core\Helper\ArrayExt\IMapHelper;

/**
 * Class BaseRunnableHelper
 * @package Twinkl\Core\Helper\Parse
 */
interface IRunnableHelper
{
    /**
     * @return mixed|null
     */
    public function getContext();
    
    /**
     * @param mixed|null $context
     * @return $this
     */
    public function setContext($context);
    
    /**
     * @return bool|null
     */
    public function getOverwriteSource(): ?bool;
    
    /**
     * @param bool $overwriteSrc
     * @return $this
     */
    public function setOverwriteSource(?bool $overwriteSrc);
    
    /**
     * @return mixed|null
     */
    public function getResult();
    
    /**
     * @return $this
     * @throws Exception
     */
    public function run();
}
