<?php

if_get('/groups', function ()
{/*{{{*/
    $inputs = [];
    $inputs['parent_group_id'] = input('parent_group_id');

    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $inputs = array_filter($inputs, 'not_null');
    $inputs['system_id'] = $system->id;

    $groups = dao('group')->find_all_by_column($inputs);

    return [
        'code' => 0,
        'msg'  => '',
        'count' => count($groups),
        'data' => array_build($groups, function ($id, $group) {
            return [
                null,
                [
                    'id' => $group->id,
                    'name' => $group->name,
                    'parent_group_id' => $group->parent_group->id,
                    'parent_group_display' => $group->parent_group->display_for_groups_parent_group(),
                    'create_time' => $group->create_time,
                    'update_time' => $group->update_time,
                ]
            ];
        }),
    ];
});/*}}}*/

if_post('/groups/add', function ()
{/*{{{*/
    $name = input('name');
    otherwise_error_code(20001, $name);

    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $extends_info = input('extends_info', '');

    $group = group::create(
        $system,
        $name
    );

    $group->extends_info = $extends_info;

    if ($parent_group_id = input('parent_group_id')) {
        $parent_group = dao('group')->find($parent_group_id);
        otherwise_error_code(20002, $parent_group->is_not_null());
        otherwise_error_code(20003, $parent_group->belongs_to_system($system), [':key' => $key]);

        $group->parent_group = $parent_group;
    }

    return [
        'code' => 0,
        'msg' => '',
        'data' => [
            'id' => $group->id,
        ],
    ];
});/*}}}*/

if_post('/groups/update/*', function ($group_id)
{/*{{{*/
    $name = input('name');
    otherwise_error_code(20001, $name);

    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $group = dao('group')->find($group_id);
    otherwise($group->is_not_null(), 'group 不存在');
    otherwise_error_code(20003, $group->belongs_to_system($system), [':key' => $key]);

    if ($parent_group_id = input('parent_group_id')) {
        $parent_group = dao('group')->find($parent_group_id);
        otherwise_error_code(20002, $parent_group->is_not_null());
        otherwise_error_code(20003, $parent_group->belongs_to_system($system), [':key' => $key]);

        $group->parent_group = $parent_group;
    }

    $group->name = $name;

    $extends_info = input('extends_info', null);
    if (not_null($extends_info)) {
        $group->extends_info = $extends_info;
    }

    return [
        'code' => 0,
        'msg' => '',
    ];
});/*}}}*/

if_post('/groups/delete/*', function ($group_id)
{/*{{{*/
    $key = input('key');
    otherwise_error_code(10001, $key);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $group = dao('group')->find($group_id);
    otherwise($group->is_not_null(), '标签组不存在');
    otherwise_error_code(20003, $group->belongs_to_system($system), [':key' => $key]);

    $group->delete();

    return [
        'code' => 0,
        'msg' => '',
    ];
});/*}}}*/
