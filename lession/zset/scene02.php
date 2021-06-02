<?php
/**
 * 排行榜
 *
 * @package    scene01.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 分数排行榜

$key = 'top:list';

// step1: 从数据库中读取分数数据，写入redis
$user_score = [
    'zs' => 60,
    'li' => 90,
    'ww' => 70,
    'fg' => 95,
    'wf' => 80
];
foreach ($user_score as $val => $score) {
    $res = $redis->zAdd($key, [], $score, $val);
}
$redis->expire($key, 5);

// step2: 获取排行榜
$res = $redis->zRevRange($key, 0, 2);
var_dump($res);