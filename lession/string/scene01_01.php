<?php
/**
 * 清缓存
 *
 * @package    scene01_01.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

$key_prefix = 'goods:';

// step1: 改db

// step2: 清缓存

$id = 15;
$key = $key_prefix . $id;
$res = $redis->del($key);

$info = $redis->get($key);
var_dump($info);
