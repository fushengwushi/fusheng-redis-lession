<?php
/**
 *
 * @package    Demo.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

$key = 'set:test';

// sadd: 添加元素
$res = $redis->sAdd($key, 1, 2, 3, 4);
$res = $redis->expire($key, 5);

// sMembers: 获取所有元素, O(n), 如果数据量非常多，要慎用
$res = $redis->sMembers($key);
var_dump($res);

// srem: 删除元素
$res = $redis->sRem($key, 4);
$res = $redis->sMembers($key);
var_dump($res);

// scard: 获取集合中的元素个数
$res = $redis->sCard($key);
var_dump($res);

// sismember: 判断是否是集合内的元素
$item = 4;
if ($redis->sIsMember($key, $item)) {
    var_dump($item . ' is member');
} else {
    var_dump($item . ' is not member');
}

// srandmember: 随机从集合中获取指定的元素个数，常用业务场景，抽奖，随即推荐
$res = $redis->sRandMember($key, 2);
var_dump($res);