<?php
/**
 * 场景4: 限速
 *
 * @package    scene04.php
 * @author     fushengwushi<fushengwushi@126.com>
 */
require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 限速

$keyPrefix = 'phone:limit:';
$phone = 15511111111;
$key = $keyPrefix . $phone;

// 限制用户每分钟获取验证码频率，如一分钟不能超过3次

$expire = 60;

// expire重复设置，会覆盖上一次的过期时间

// 错误写法
/*$total = $redis->incr($key);
$redis->expire($key, $expire);
var_dump($total);
if ($total <=3 ) {
    var_dump('send success');
} else {
    var_dump('send limit');
}*/

// 正确写法
/*$res = $redis->get($key);
if ($res) {
    $total = $redis->incr($key);
} else {
    $res = $redis->setex($key, $expire, 1);
    $total = 1;
}
if ($total <=3 ) {
    var_dump('send success');
} else {
    var_dump('send limit');
}*/

// 进阶

// setnx: 若key已存在，重复设置会失败
/*$res = $redis->setnx($key, 1);
if ($res) {
    $redis->expire($key, $expire);
    $total = 1;
} else {
    $total = $redis->incr($key);
}
if ($total <=3 ) {
    var_dump('send success');
} else {
    var_dump('send limit');
}*/

// 进阶2
$res = $redis->set($key, 1, ['ex' => $expire, 'nx']);
if ($res) {
    $total = 1;
} else {
    $total = $redis->incr($key);
}
if ($total <=3 ) {
    var_dump('send success');
} else {
    var_dump('send limit');
}

// 限制一个ip地址不能1s内访问超过n次
// 限制1个人1分钟内点赞量不能超过n次
// ...