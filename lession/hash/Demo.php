<?php
/**
 *
 * @package    Demo.php
 * @author     fushengwushi<fushengwushi@126.com>
 */
require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// hset: 将入数据存储入redis
$str = '生活的美好';
$key = 'user1';

$field1 = 'name';
$value1 = 'ethan';
$field2 = 'like';
$value2 = 141;

$res = $redis->hSet($key, $field1, $value1);
$res = $redis->expire($key, 10);

// hget: 将数据取出
$info = $redis->hGet($key, $field1);
var_dump($info);

// hmset: 批量存储field
$res = $redis->hMSet($key, [
    $field1 => $value1,
    $field2 => $value2
]);
$redis->expire($key, 10);

$info = $redis->hGet($key, $field1);
var_dump($info);
$info = $redis->hGet($key, $field2);
var_dump($info);

// hgetall
$infos = $redis->hGetAll($key);
var_dump($infos);

// del
// $res = $redis->del($key);

// hdel: 删除field
$res = $redis->hDel($key, $field1);
$infos = $redis->hGetAll($key);
var_dump($infos);

// hIncrBy 递增
$res = $redis->hIncrBy($key, $field2, 1);
$infos = $redis->hGetAll($key);
var_dump($infos);
