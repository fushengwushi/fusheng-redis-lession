<?php
/**
 * 获取用户共同感兴趣的标签，共同的好友列表
 *
 * @package    scene03.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 实际业务场景

// 两个用户
$user_id1 = 1;
$user_id2 = 2;

// step1: 用户选择标签, save db

// step2: 用户1访问用户2的个人主页，显示与用户2共同的兴趣标签

// 用户下的标签
$user_key_1 = 'user:' . $user_id1 . ':tags';
$user_key_2 = 'user:' . $user_id2 . ':tags';

// 判断$user_key_1, $user_key_2是否为空， 为空的话取db, 种缓存
if (!$redis->exists($user_key_1)) {
    // $user_key_1 缓存为空，从db取数据，种缓存
    $user1_tags = ['娱乐', '历史', '新闻']; // 从db中取出的数据
    foreach ($user1_tags as $user1_tag) {
        $res = $redis->sAdd($user_key_1, $user1_tag);
    }
    $res = $redis->expire($user_key_1, 5);
}

if (!$redis->exists($user_key_2)) {
    // $user_key_2 缓存为空，从db取数据，种缓存
    $user2_tags = ['历史', '文化', '经济', '新闻']; // 从db中取出的数据
    foreach ($user2_tags as $user2_tag) {
        $res = $redis->sAdd($user_key_2, $user2_tag);
    }
    $res = $redis->expire($user_key_2, 5);
}

// 做交集， 获取用户1，用户2共同感兴趣的标签
$res = $redis->sInter($user_key_1, $user_key_2);
var_dump($res);

// step3: 用户修改标签信息，清缓存
$res = $redis->del($user_key_1);
$res = $redis->del($user_key_2);

// ps: 同样的方法，也可以获取用户1，用户2共同的好友列表，共同的联系人等等
// ps: 此业务逻辑，只适合标签这类数据量少的情况。若是像微博粉丝，粉丝量达到千万级别的，保证缓存中有数据，通过脚本预热的操作