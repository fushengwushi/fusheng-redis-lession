<?php
/**
 * 有序列表
 *
 * @package    scene01.php
 * @author     fushengwushi<fushengwushi@126.com>
 */
require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 获取收藏列表

$keyPre = 'uid:like:list:';
$userId = 12;
$key = $keyPre . $userId;

$artIds = [9, 10, 11, 12, 13, 14, 15];

// step1: 模拟用户收藏操作
foreach ($artIds as $artId) {
    sleep(1);
    $res = $redis->zAdd($key, [], time(), $artId);
    $redis->expire($key, 5);
}

// step2: 用户访问收藏列表
$cursor = 0;
$count = 2;
do {
    $end = $cursor + $count - 1;
    if (!$redis->exists($key)) {
        // 读db 执行step1操作，种缓存
    }

    $res = $redis->zRevRange($key, $cursor, $end);
    echo 'cursor:' . $cursor . ',end:' . $end . PHP_EOL;
    var_dump($res);

    $size = $redis->zCard($key);
    if ($cursor + $count >= $size) {
        $cursor = 0;
        break;
    } else {
        $cursor = $cursor + $count;
    }

} while(true);

// ps: 如果score是点赞数，则可以实现点赞量的排行榜，同样，收藏排行榜，订阅排行榜等等都可以，这就是有序集合最大的用途，就是根据score有序，让我们能够满足各类的应用场景。