<?php
/**
 * 存储对象信息
 *
 * @package    scene01.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 存储对象信息
$key = 'goods:15';
$info = [
    'id' => 15,
    'name' => '商品1',
    'price' => 12,
    'buy' => 13
];
$res = $redis->hMSet($key, $info);
$redis->expire($key, 10);
$name = $redis->hGet($key, 'name');
var_dump($name);

$info = $redis->hGetAll($key);
var_dump($info);


$res = $redis->hIncrBy($key, 'buy', 1);
$buy = $redis->hGet($key, 'buy');
var_dump($buy);