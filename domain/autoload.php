<?php

spl_autoload_register(function ($class_name) {

    $class_maps = [
        'group_dao' => 'dao/group.php',
        'system_dao' => 'dao/system.php',
        'tag_dao' => 'dao/tag.php',
        'tag_target_dao' => 'dao/tag_target.php',
        'group' => 'entity/group.php',
        'system' => 'entity/system.php',
        'tag' => 'entity/tag.php',
        'tag_target' => 'entity/tag_target.php',
    ];

    if (isset($class_maps[$class_name])) {
        include __DIR__.'/'.$class_maps[$class_name];
    }
});
