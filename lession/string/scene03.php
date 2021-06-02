<?php
/**
 * 场景3: 共享登录态
 *
 * @package    scene03.php
 * @author     fushengwushi<fushengwushi@126.com>
 */

require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 共享session
$keyPrefix = 'login:uid:';
$id = 19;
$key = $keyPrefix . $id;
$sessionExpire = 3600;

// 1. 登录，设置session

// db获取用户信息
$userInfo = [
    'name' => 'ethan',
    'email' => '11@qq.com'
];

// 种session缓存
$rand1 = rand(10000000, 99999999); // 生成一个随机数
$rand2 = rand(10000000, 99999999);
$cookie = md5(sprintf("%d_%d_%d_%d", $id, $rand1, $rand2, time()));
$res = $redis->setex($cookie, $sessionExpire, json_encode($userInfo));

// 种浏览器cookie
$cookieExpire = time() + $sessionExpire;
$domain = '.baidu.com';
setcookie('LOGIN', $cookie, $cookieExpire, '/', $domain);

// 2. 判断登录态

// 从浏览器获取cookie  php: $cookie = $_COOKIE['LOGIN']
$cookieNow = $cookie;

// $userInfo非空，已登录状态, 如果为空，跳转登录页
$userInfo = $redis->get($cookieNow);

// 3. 登出

// 清session缓存
$res = $redis->del($cookie);

// 清cookie
setcookie('LOGIN', "", time() - 86400, '/', $domain);

// 扩展 不同服务器，甚至是不同的业务方，都能够共享数据

