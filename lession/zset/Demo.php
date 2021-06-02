<?php
/**
 *
 * @package    Demo.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

$key = 'sort:list:demo';

// 写入数据
$res = $redis->zAdd($key, [], 60, 'zs');
$res = $redis->zAdd($key, [], 70, 'ls');
$res = $redis->zAdd($key, [], 50, 'ww');
$res = $redis->zAdd($key, [], 80, 'fg');
$res = $redis->zAdd($key, [], 90, '2f');
$redis->expire($key, 10);

// 读取数据 zRange: 升序，从小到大 zRevRange:降序
$res = $redis->zRange($key, 0, 2, true);
var_dump($res);

$res = $redis->zRevRange($key, 0, -1, true);
var_dump($res);

// 删除某个数据 zRem
$res = $redis->zRevRange($key, 0, -1, true);
var_dump($res);
$res = $redis->zRem($key, 'ww');
$res = $redis->zRevRange($key, 0, -1, true);
var_dump($res);

// 根据score范围获取数据  zRangeByScore:升序, zRevRangeByScore:降序
$res = $redis->zRangeByScore($key, 50, 80, ['withscores' => true, 'limit' => [0, 3]]);
var_dump($res);

// 获取成员排名 zRank正序排名, zRevRank倒序排名
$res = $redis->zRange($key, 0, -1, true);
var_dump($res);
$res = $redis->zRank($key, 'ls');
var_dump($res);
$res = $redis->zRevRank($key, 'ls');
var_dump($res);

// 获取总数量 zCard
$res = $redis->zCard($key);
var_dump($res);

// 获取指定score区间内的总量 zCount
$res = $redis->zRange($key, 0, -1, true);
var_dump($res);
$res = $redis->zCount($key, 50, 70);
var_dump($res);


// 批量删除
$res = $redis->zRange($key, 0, -1, true);
var_dump($res);

// 移除给定的排名区间的所有成员
/*$res = $redis->zRemRangeByRank($key, 1, 2);
$res = $redis->zRange($key, 0, -1, true);
var_dump($res);*/

// 移除非定的score区间的所有成员
$res = $redis->zRemRangeByScore($key, 50, 70);
$res = $redis->zRange($key, 0, -1, true);
var_dump($res);



