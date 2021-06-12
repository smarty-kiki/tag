# up
create table if not exists `group` (
    `id` bigint(20) unsigned not null,
    `version` int(11) not null,
    `create_time` datetime default null,
    `update_time` datetime default null,
    `delete_time` datetime default null,
    `name` varchar(30) default null,
    `extends_info` varchar(200) default null,
    `system_id` bigint(20) unsigned not null,
    `parent_group_id` bigint(20) unsigned not null,
    key `fk_system_idx` (`system_id`, `delete_time`),
    key `fk_parent_group_group_idx` (`parent_group_id`, `delete_time`),
    primary key (`id`)
) engine=innodb default charset=utf8;

# down
drop table `group`;
