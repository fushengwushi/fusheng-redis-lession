<?php
/**
 *
 * @package    Demo.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// rpush: 在列表右侧插入数据 lpush在列表左侧插入数据
$key = 'list:test';
$res = $redis->rPush($key, 1);
$res = $redis->rPush($key, 2);
$res = $redis->rPush($key, 3, 4, 5);
/*$res = $redis->lPush($key, 6);
$res = $redis->rPush($key, 7);*/
$res = $redis->expire($key, 5);

// lrange: 从左到右获取列表元素 key start end end=-1取全部元素
$res = $redis->lRange($key, 0, -1);
$res = $redis->lRange($key, 0, 3);
var_dump($res);

// lpop: 从列表左侧删除数据， rpop: 从列表右侧删除元素
$res = $redis->lPop($key);
$res = $redis->rPop($key);
$res = $redis->lRange($key, 0, -1);
var_dump($res);

// lindex: 根据下标获取列表元素
$res = $redis->lIndex($key, 1);
var_dump($res);

// llen: 获取列表长度
$res = $redis->lLen($key);
var_dump($res);

