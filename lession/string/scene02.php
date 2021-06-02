<?php
/**
 * 场景2：计数器
 *
 * @package    scene02.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 简单计数

// 视频播放量
$keyPrefix = 'video:play:count:';
$videoId = 23;
$key = $keyPrefix . $videoId;
//$total = $redis->incr($key);
//var_dump($total);

// 页面访问量
$key2 = 'request:count';
//$total2 = $redis->incr($key2);
//var_dump($total2);

// 投票量，点赞量等等

// 按照月/天/小时计数 (可以运用过期时间)

// 每天的页面访问量
$key3 = 'request:total:' . date("Ymd");
var_dump($key3);
$total3 = $redis->incr($key3);
$res = $redis->expire($key3, 3600 * 24 * 2);
var_dump($total3);

// 落库

// 定时存db, 每天，每小时跑脚本，将redis中的统计数据，写到db里(存在误差)
//$total = $redis->get($key3);
//var_dump($total);
// 写db

// ps
$key4 = 'ps1';
//$total4 = $redis->incrBy($key4, 3);
//var_dump($total4);

//$total5 = $redis->decr($key4);
//var_dump($total5);

//$total6 = $redis->decrBy($key4, 2);
//var_dump($total6);
