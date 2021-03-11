<?php

if_get('/tags', function ()
{/*{{{*/
    list(
        $inputs['group_id']
    ) = input_list(
        'group_id'
    );

    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $inputs = array_filter($inputs, 'not_null');
    $inputs['system_id'] = $system->id;

    $tags = dao('tag')->find_all_by_column($inputs);

    return [
        'code' => 0,
        'msg'  => '',
        'count' => count($tags),
        'data' => array_build($tags, function ($id, $tag) {
            return [
                null,
                [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'group_id' => $tag->group->id,
                    'group_display' => $tag->group->display_for_tags_group(),
                    'create_time' => $tag->create_time,
                    'update_time' => $tag->update_time,
                ]
            ];
        }),
    ];
});/*}}}*/

if_post('/tags/add', function ()
{/*{{{*/
    $name = input('name');
    otherwise_error_code(40001, $name);

    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $tag = tag::create(
        $system,
        $name
    );

    if ($group_id = input('group_id')) {
        $group = dao('group')->find($group_id);
        otherwise_error_code(20002, $group->is_not_null());
        otherwise_error_code(20003, $group->belongs_to_system($system), [':key' => $key]);

        $tag->group = $group;
    }

    return [
        'code' => 0,
        'msg' => '',
        'data' => [
            'id' => $tag->id,
        ],
    ];
});/*}}}*/

if_post('/tags/update/*', function ($tag_id)
{/*{{{*/
    $name = input('name');
    otherwise_error_code(40001, $name);

    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $tag = dao('tag')->find($tag_id);
    otherwise($tag->is_not_null(), 'tag 不存在');
    otherwise_error_code(40002, $tag->belongs_to_system($system), [':key' => $key]);

    if ($group_id = input('group_id')) {
        $group = dao('group')->find($group_id);
        otherwise_error_code(20002, $group->is_not_null());
        otherwise_error_code(20003, $group->belongs_to_system($system), [':key' => $key]);

        $tag->group = $group;
    }

    $tag->name = $name;

    return [
        'code' => 0,
        'msg' => '',
    ];
});/*}}}*/

if_post('/tags/delete/*', function ($tag_id)
{/*{{{*/
    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);


    $tag = dao('tag')->find($tag_id);
    otherwise($tag->is_not_null(), 'tag 不存在');
    otherwise_error_code(40002, $tag->belongs_to_system($system), [':key' => $key]);

    $tag->delete();

    return [
        'code' => 0,
        'msg' => '',
    ];
});/*}}}*/
