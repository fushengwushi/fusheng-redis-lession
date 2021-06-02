<?php
/**
 * 场景1：减少数据库压力
 *
 * @package    scene01.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

$expire = 3600; // 1h
$key_prefix = 'goods:';

// 常规使用流程

// step1: 接受参数
$id = 16;

// step2: 读redis
$key = $key_prefix . $id;
$info = $redis->get($key);

// $info = '[]'

if (!empty($info)) {
    $info = json_decode($info, true);

    // $info = []

    echo 'get from redis' . PHP_EOL;
    var_dump($info);
    return $info;
}

// step3: 读db
$info = [
    'id' => 15,
    'name' => '商品3',
    'price' => 29
];
$info = [];

// $info为空的时候，也要种缓存， json_encode([]) = '[]'

// step4: 写redis, 种缓存
$res = $redis->setex($key, $expire, json_encode($info));

// step5: 返回
echo 'get from db' . PHP_EOL;
var_dump($info);
return $info;
