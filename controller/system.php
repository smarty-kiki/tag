<?php

if_get('/systems', function ()
{/*{{{*/
    $key = input('key');
    otherwise_error_code(10001, $key);

    $systems = dao('system')->find_all_by_column(['key' => $key]);
    otherwise_error_code(10002, not_empty($systems), [':key' => $key]);

    return [
        'code' => 0,
        'msg'  => '',
        'count' => count($systems),
        'data' => array_build($systems, function ($id, $system) {
            return [
                null,
                [
                    'id' => $system->id,
                    'name' => $system->name,
                    'create_time' => $system->create_time,
                    'update_time' => $system->update_time,
                ]
            ];
        }),
    ];
});/*}}}*/

if_post('/systems/add', function ()
{/*{{{*/
    $name = input('name');
    otherwise_error_code(10004, $name);

    $another_system = dao('system')->find_by_name($name);
    otherwise_error_code(10003, $another_system->is_null(), [':name' => $name]);

    $system = system::create_generate_key($name);

    return [
        'code' => 0,
        'msg' => '',
        'data' => [
            'key' => $system->key,
        ],
    ];
});/*}}}*/

if_post('/systems/update/*', function ($key)
{/*{{{*/
    $name = input('name');
    otherwise_error_code(10004, $name);

    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $another_system = dao('system')->find_by_name($name);
    otherwise_error_code(10003, ($another_system->is_null() || $another_system->id === $system->id), [':name' => $name]);

    $system->name = $name;

    return [
        'code' => 0,
        'msg' => '',
    ];
});/*}}}*/

if_post('/systems/delete/*', function ($key)
{/*{{{*/
    $system = dao('system')->find_by_key($key);
    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);

    $system->delete();

    return [
        'code' => 0,
        'msg' => '',
    ];
});/*}}}*/
