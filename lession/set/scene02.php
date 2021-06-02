<?php
/**
 * 实现访问的独立ip统计
 *
 * @package    scene02.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 实际业务场景

// 3个 用户访问page_id=1的一个站点页面
$user_ips = ['123.23.34.12', '123.34.23.12', '123,44,12,32', '123,44,12,32', '123,44,12,32'];

$page_ip_key = 'page:ip:1:' . date("Ymd");

// 模拟每个用户访问页面
foreach ($user_ips as $user_ip) {
    $res = $redis->sAdd($page_ip_key, $user_ip);
    $res = $redis->expire($page_ip_key, 5);
}

// 获取页面ip的访问总量
$res = $redis->sCard($page_ip_key);
var_dump($res);
$res = $redis->sMembers($page_ip_key);
var_dump($res);

