<?php

if_get('/tag_targets', function ()
{/*{{{*/
    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $inputs = [
        'system_id' => $system->id,
    ];

    if ($tag_ids = input('tag_ids')) {
        $inputs['tag_id'] = $tag_ids;
    }

    if ($class = input('class')) {
        $inputs['class'] = $class;
    }

    if ($class_ids = input('class_ids')) {
        $inputs['class_id'] = $class_ids;
    }

    $tag_targets = dao('tag_target')->find_all_by_column($inputs);

    return [
        'code' => 0,
        'msg'  => '',
        'count' => count($tag_targets),
        'data' => array_build($tag_targets, function ($id, $tag_target) {
            return [
                null,
                [
                    'id' => $tag_target->id,
                    'class' => $tag_target->class,
                    'class_id' => $tag_target->class_id,
                    'tag_id' => $tag_target->tag_id,
                    'tag_display' => $tag_target->tag->display_for_tag_targets_tag(),
                    'description' => $tag_target->description,
                    'create_time' => $tag_target->create_time,
                    'update_time' => $tag_target->update_time,
                ]
            ];
        }),
    ];
});/*}}}*/

if_post('/tags_bind_targets', function ()
{/*{{{*/
    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $tag_id = input('tag_id');
    otherwise_error_code(30003, $tag_id);

    $class = input('class');
    otherwise_error_code(30001, $class);

    $class_ids = input('class_ids');
    otherwise_error_code(30002, not_empty($class_ids));

    $tag = dao('tag')->find($tag_id);
    otherwise($tag->is_not_null(), '无效的 tag');
    otherwise_error_code(40002, $tag->belongs_to_system($system), [':key' => $key]);

    $tag_targets = dao('tag_target')->find_all_by_tag_and_class_and_class_id($tag, $class, $class_ids);

    $tag_target_infos = [];
    foreach ($tag_targets as $tag_target) {
        $tag_target_infos[$tag_target->class_id] = $tag_target;
    }

    $count = 0;
    foreach ($class_ids as $class_id) {
        if (isset($tag_target_infos[$class_id])) {
            continue;
        }
        $tag_target = tag_target::create($system, $tag, $class, $class_id);
        $count ++;
    }

    return [
        'code' => 0,
        'msg' => '',
        'data' => [
            'count' => $count,
        ],
    ];
});/*}}}*/

if_post('/query_tag_targets_count', function ()
{/*{{{*/
    $key = input_json('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $class = input_json('class');
    otherwise_error_code(30001, $class);

    $query_ast = input_json('query_ast_json');
    otherwise_error_code(30004, not_empty($query_ast));

    $count = tag_target_query_count($system, $class, $query_ast, 0, 1000);

    return [
        'code' => 0,
        'msg' => '',
        'data' => [
            'count' => $count,
        ],
    ];
});/*}}}*/
