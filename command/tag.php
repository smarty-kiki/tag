<?php

command('tag:rebuild-query-booster', '重新生成 tag 的查询加速', function ()
{/*{{{*/
    $start_tag_target_id = 0;

    $key_infos = [];

    echo "开始基于 tag_target 构造新 key:\n";
    do {
        echo "start: ".$start_tag_target_id." limit: 1000\n";

        $tag_target_infos = db_simple_query('tag_target', [
            'delete_time' => null,
            'id > ' => $start_tag_target_id,
        ], 'order by id limit 1000');

        foreach ($tag_target_infos as $tt) {
            $key = tag_target::REDIS_KEY_PREFIX.$tt['system_id'].'_'.$tt['class'].'_'.$tt['class_id'];
            $tmp_key = 'REBUILD_'.$key;
            $key_infos[$tmp_key] = $key;

            cache_setbit($tmp_key, $tt['class_id'], 1);

            $start_tag_target_id = $tt['id'];
        }

    } while (count($tag_target_infos) === 1000);

    echo "开始重命名新 key:\n";
    foreach ($key_infos as $old => $new) {
        cache_rename($old, $new);
        echo $old." -> ".$new."\n";
    }
});/*}}}*/

command('tag:init-data-for-test', '生成测试数据', function ()
{/*{{{*/
    $system = dao('system')->find(1);

    $tags = unit_of_work(function () use ($system) {
        $tags = [];
        for ($i = 0; $i < 1000; $i ++) {
            $tag = tag::create($system, '测试标签-'.$i);
            $tags[$tag->id] = $tag;
        }
        return $tags;
    });

    $customer_count = 1000;
    for ($i = 1; $i < (1 + $customer_count); $i ++) {
        echo "初始化 customer $i 标签\n";
        $tag_ids = array_rand($tags, 200);
        unit_of_work(function () use ($tag_ids, $tags, $system, $i) {
            foreach ($tag_ids as $tag_id) {
                tag_target::create($system, $tags[$tag_id], 'customer', $i);
            }
        });
    }

});/*}}}*/
