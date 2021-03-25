<?php

function tag_target_query_ids(system $system, $class, $ast, $start_class_id = 0, $limit = 1000)
{/*{{{*/
    $key = tag_target_query_operation($system, $class, $ast);

    $ids = [];

    $position = $start_class_id;

    do {

        $res = cache_bitpos($key, 1, $position);
        if ($res > 0) {
            $position = $res / 8;
            $ids[] = $position;
            $position++;
            $limit--;
        }
    } while ($res > 0 && $limit > 0);

    cache_delete($key);

    return $ids;
}/*}}}*/

function tag_target_query_map(system $system, $class, $ast, closure $closure, $start_class_id = 0, $limit = 1000)
{/*{{{*/
    $key = tag_target_query_operation($system, $class, $ast);

    $position = $start_class_id;

    do {

        $res = cache_bitpos($key, 1, $position);
        if ($res > 0) {
            $position = $res / 8;
            call_user_func($closure, $position);
            $position++;
            $limit--;
        }
    } while ($res > 0 && $limit > 0);

    cache_delete($key);
}/*}}}*/

function tag_target_query_count(system $system, $class, $ast)
{/*{{{*/
    $key = tag_target_query_operation($system, $class, $ast);

    $count = cache_bitcount($key);

    cache_delete($key);

    return $count;
}/*}}}*/

function tag_target_query_operation(system $system, $class, $ast)
{/*{{{*/
    $tmp_key = 'TAG_TMP_'.md5(time().rand(0, 10000));

    otherwise(isset($ast['operation']),  'ast 的节点数据必须拥有 operation 字段');
    otherwise(isset($ast['children']),   'ast 的节点数据必须拥有 children  字段');
    otherwise(isset($ast['tags']),       'ast 的节点数据必须拥有 tags 字段');

    $keys = [];
    $tmp_keys = [];

    foreach ($ast['tags'] as $key => $tag_id) {
        $keys[] = tag_target::REDIS_KEY_PREFIX.$system->id.'_'.$class.'_'.$tag_id;
    }

    foreach ($ast['children'] as $children_ast) {
        $tmp_keys[] = $keys[] = tag_target_query_operation($system, $class, $children_ast);
    }

    cache_bitop($tmp_key, $ast['operation'], $keys);
    cache_multi_delete($tmp_keys);

    return $tmp_key;
}/*}}}*/
