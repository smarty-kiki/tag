<?php

function tag_target_query_ids(system $system, $class, $ast, $start_class_id = 0, $limit = 1000)
{/*{{{*/
    $key = tag_target_query_operation($system, $class, $ast);

    $bitmap = unpack('C*', cache_get($key));

    $ids = [];

    $start_byte_offset = intval($start_class_id / 8);

    foreach ($bitmap as $offset => $byte) {

        if ($offset < $start_byte_offset || $byte == 0) {
            continue;
        }

        $start = ($offset - 1) * 8;

        for ($i = 0; $i < 8; $i ++) {
            if (($byte & 128) == 128) {
                $class_id = $start + $i;
                if ($class_id >= $start_class_id) {
                    $ids[] = $class_id;
                    $limit--;
                    if ($limit == 0) {
                        break(2);
                    }
                }
            }
            $byte = $byte << 1;
        }
    }

    cache_delete($key);

    return $ids;
}/*}}}*/

function tag_target_query_map(system $system, $class, $ast, closure $closure, $start_class_id = 0, $limit = 1000)
{/*{{{*/
    $key = tag_target_query_operation($system, $class, $ast);

    $bitmap = unpack('C*', cache_get($key));

    $start_byte_offset = intval($start_class_id / 8);

    foreach ($bitmap as $offset => $byte) {

        if ($offset < $start_byte_offset || $byte == 0) {
            continue;
        }

        $start = ($offset - 1) * 8;

        for ($i = 0; $i < 8; $i ++) {
            if (($byte & 128) == 128) {
                $class_id = $start + $i;
                if ($class_id >= $start_class_id) {
                    call_user_func($closure, $class_id);
                    $limit--;
                    if ($limit == 0) {
                        break(2);
                    }
                }
            }
            $byte = $byte << 1;
        }
    }

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
