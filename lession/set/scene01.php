<?php
/**
 * 随机推送热点信息，热点新闻，关注推荐等等
 *
 * @package    scene01.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 随机关注推荐的实际业务场景

// key
$key = 'rec:user:1';

// 根据一定的推荐算法机制(相同的兴趣/共同的爱好 等等), 获取到一批的用户id
$rec_ids = [2,3,4,5,6];

foreach ($rec_ids as $rec_id) {
    $res = $redis->sAdd($key, $rec_id);
}
$res = $redis->expire($key, 5);

// 获取随机推荐
$res = $redis->sRandMember($key, 3);
var_dump($res);