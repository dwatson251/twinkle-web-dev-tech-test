<?php

namespace Twinkl\Eloquent\Util;

use Exception;
use LogicException;
use PDO;
use Illuminate\Database\Capsule\Manager as Capsule;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\CustomTrait\SingletonTrait;
use Twinkl\Core\Glob\GlobalsGlob;
use Twinkl\Core\InterfaceExt\ISingleton;
use Twinkl\Eloquent\Builder\QueryBuilder;

/**
 * Class EloquentUtils
 * @package Twinkl\Util
 */
class EloquentUtils implements ISingleton
{
    /*
     * Traits
     */

    use SingletonTrait;
    
    /*
     * Properties
     */
    
    /**
     * @var bool
     */
    protected $hasInitConns = false;

    /*
     * Init logic
     */

    /**
     * @return $this
     */
    public function initConnections()
    {
        if ($this->hasInitConns) {
            return $this;
        }
        
        $globals = new GlobalsGlob();
        $dbConfigs = $globals->getDbConfigs() ?? [];
        if (!$dbConfigs) {
            $globals->setUseSessAsDb(true);
            return $this;
        }
        
        $capsule = new Capsule();
        $capsule->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($dbConfigs as $iDbConfig) {
            $capsule->addConnection(
                $iDbConfig->returnEloquentCapsuleConfig()
            );
        }
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        
        $this->hasInitConns = true;
        return $this;
    }
    
    /*
     * Logging logic
     */

    /**
     * @param bool $enable
     * @throws Exception
     */
    public function enableQueryLogging($enable = true)
    {
        $this->initConnections();
        $conn = Capsule::connection();
        if ($enable) {
            $conn->enableQueryLog();
        } else {
            $conn->disableQueryLog();
        }
    }
    
    /**
     * Disables query logging.
     * @throws Exception
     */
    public function disableQueryLogging()
    {
        $this->initConnections();
        Capsule::connection()->disableQueryLog();
    }
    
    /**
     * Returns query log.
     * @return array
     */
    public function returnQueryLog()
    {
        return Capsule::connection()->getQueryLog();
    }
    
    /*
     * Query builder logic
     */
    
    /**
     * @param string|null $from
     * @return QueryBuilder
     * @throws Exception
     */
    public function createQueryBuilder(string $from = null)
    {
        $this->initConnections();
        $qb = new QueryBuilder(Capsule::connection());
        if ($from) {
            $qb->from($from);
        }
        return $qb;
    }
}
