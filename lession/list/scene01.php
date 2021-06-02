<?php
/**
 * 获取内容列表
 *
 * @package    scene01.php
 * @author     fushengwushi<fushengwushi@126.com>
 */
require_once '../../CacheRedis.php';

$server = '127.0.0.1:6379';
$redis = CacheRedis::getInstance($server);

// 获取用户发布的文章列表
$user_id = 12;
$key = 'user:art:list:' . $user_id;
$article_ids = [1,2,3,4,5,6,7,8,9,10];

// 模拟用户发布文章流程
foreach ($article_ids as $article_id) {
    // lpush: 我们想要展示顺序是优先展示最新文章
    $res = $redis->lPush($key, $article_id);

    // expire: 业务场景中代表，长期未发布新文章的时间 >= expire时间时，列表key过期
    $res = $redis->expire($key, 5);
}

// 模拟用户访问文章列表
$page = 0;
$page_count = 2;
do {
    // 业务场景代码 - start
    $start = $page * $page_count;
    $end = $start + $page_count - 1;

    // 要注意, end是结束为止的下标，]
    if (!$redis->exists($key)) {
        // 从db获取文章列表
        // 种缓存
    }
    $list = $redis->lRange($key, $start, $end);

    // 业务场景代码 - end

    if (empty($list)) {
        break;
    }
    $page++;

    var_dump($list);

    // 对list中的文章id, 从文章信息缓存中获取每个id对应的文章具体内容

} while(true);

// ps: 列表表一般只存id, 具体内容，通过id再去查string, hash等，尽量保证数据缓存的唯一性，避免修改清缓存时需要清多处缓存

// 清缓存
$res = $redis->del($key);


