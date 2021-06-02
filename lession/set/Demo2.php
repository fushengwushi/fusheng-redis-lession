<?php
/**
 *
 * @package    Demo2.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

$key1 = 'set:1';
$key2 = 'set:2';
$key3 = 'set:3';

$res = $redis->sAdd($key1, 1, 2, 3, 4);
$res = $redis->sAdd($key2, 2, 3, 4);
$res = $redis->sAdd($key3, 3, 4, 5, 6);
$redis->expire($key1, 5);
$redis->expire($key2, 5);
$redis->expire($key3, 5);

// 集合间操作

// sinter: 求多个集合的交集
$res = $redis->sInter($key1, $key2, $key3);
var_dump($res);

// sunion: 求多个集合的并集
$res = $redis->sUnion($key1, $key2, $key3);
var_dump($res);

// sdiff: 求多个集合的差集(第一个集合 - 其他集合， 也就说，结果是返回第一个集合中特有的元素)
$res = $redis->sDiff($key1, $key2, $key3);
var_dump($res);

$key1_store = 'set:s:1';
// sinterstore: 计算交集并将结果保存 ps: sUnionStore sDiffStore
$res = $redis->sInterStore($key1_store, $key1, $key2, $key3);
var_dump($res);
$res = $redis->sMembers($key1_store);
var_dump($res);

// ps: 集合间的运算都比较耗时，所以，在数据量非常大的情况下，一般都是异步使用(脚本预热数据等方式)， 使用store命令将结果缓存下来，使用的时候不需要实时计算，直接从缓存中取