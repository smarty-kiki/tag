# up
create table if not exists `system` (
    `id` bigint(20) unsigned not null,
    `version` int(11) not null,
    `create_time` datetime default null,
    `update_time` datetime default null,
    `delete_time` datetime default null,
    `name` varchar(30) default null,
    `key` varchar(50) default null,
    key `idx_name` (`name`, `delete_time`),
    primary key (`id`)
) engine=innodb default charset=utf8;

# down
drop table `system`;
