<?php
/**
 *
 * @package    Demo.php
 * @author     fushengwushi<fushengwushi@126.com>
 */
require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// set: 将字符串存储入redis
$str = '假如生活欺骗了你';
$key = 'l1';

$res = $redis->set($key, $str);
$redis->expire($key, 2);
var_dump($res);

// get: 将字符串取出来
$res = $redis->get($key);
var_dump($res);

// 过期时间
sleep(3);
$res = $redis->get($key);
var_dump($res);