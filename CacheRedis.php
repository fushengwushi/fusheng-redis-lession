<?php
/**
 *
 * @package    CacheRedis.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

class CacheRedis
{
    private static $_instance = null;

    private function __construct() {
    }

    /**
     * @param $server
     * @return null|\Redis
     */
    public static function getInstance($server) {
        if (is_null(self::$_instance)) {
            self::$_instance = new \Redis();
            list($host, $port) = explode(':', $server);
            self::$_instance->connect($host, $port);
        }
        return self::$_instance;
    }

    private function __clone() {
    }
}