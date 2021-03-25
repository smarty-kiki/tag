# up
create table if not exists `tag_target` (
    `id` bigint(20) unsigned not null,
    `version` int(11) not null,
    `create_time` datetime default null,
    `update_time` datetime default null,
    `delete_time` datetime default null,
    `class` varchar(30) default null,
    `class_id` int(11) not null default 0,
    `description` varchar(200) default null,
    `system_id` bigint(20) unsigned not null,
    `tag_id` bigint(20) unsigned not null,
    key `fk_system_idx` (`system_id`, `delete_time`),
    key `fk_tag_idx` (`tag_id`, `delete_time`),
    primary key (`id`)
) engine=innodb default charset=utf8;

# down
drop table `tag_target`;
