<?php
/**
 * 存储映射信息
 *
 * @package    scene02.php
 * @author     fushengwushi<fushengwushi@126.com>
 */
require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

//  存储映射
$key = 'uid:to:name';
$map = [
    15 => '张三',
    16 => '李四',
    17 => '王五'
];
$res = $redis->hMSet($key, $map);
$redis->expire($key, 10);

$name = $redis->hGet($key, 15);
var_dump($name);

$map = $redis->hGetAll($key);
var_dump($map);