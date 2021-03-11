<?php

class group extends entity
{
    /* generated code start */
    public $structs = [
        'system_id' => 0,
        'parent_group_id' => 0,
        'name' => '',
    ];

    public static $struct_data_types = [
        'system_id' => 'number',
        'parent_group_id' => 'number',
        'name' => 'string',
    ];

    public static $struct_display_names = [
        'system_id' => '系统ID',
        'parent_group_id' => '分组ID',
        'name' => '名称',
    ];


    public static $struct_is_required = [
        'system_id' => true,
        'parent_group_id' => false,
        'name' => true,
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('system');
        $this->has_many('groups', 'group', 'parent_group_id');
        $this->belongs_to('parent_group', 'group', 'parent_group_id');
        $this->has_many('tags', 'tag');
    }/*}}}*/

    public static function create(system $system, $name)
    {/*{{{*/
        $group = parent::init();

        $group->system = $system;
        $group->name = $name;

        return $group;
    }/*}}}*/

    public static function struct_formaters($property)
    {/*{{{*/
        $formaters = [
            'name' => [
                [
                    'function' => function ($value) {
                        return mb_strlen($value) <= 30;
                    },
                    'failed_message' => '不能超过 30 字',
                ],
            ],
        ];

        return $formaters[$property] ?? false;
    }/*}}}*/

    public function belongs_to_system(system $system)
    {/*{{{*/
        return $this->system_id == $system->id;
    }/*}}}*/

    public function belongs_to_parent_group(group $parent_group)
    {/*{{{*/
        return $this->parent_group_id == $parent_group->id;
    }/*}}}*/

    public function delete()
    {/*{{{*/
        foreach ($this->groups as $group) {
            if ($group->parent_group_id === $this->id) {
                $group->parent_group_id = 0;
            }
        }
        foreach ($this->tags as $tag) {
            if ($tag->group_id === $this->id) {
                $tag->group_id = 0;
            }
        }

        parent::delete();
    }/*}}}*/

    public function display_for_system_groups()
    {/*{{{*/
        return $this->id;
    }/*}}}*/

    public function display_for_groups_parent_group()
    {/*{{{*/
        return $this->name;
    }/*}}}*/

    public function display_for_parent_group_groups()
    {/*{{{*/
        return $this->id;
    }/*}}}*/

    public function display_for_tags_group()
    {/*{{{*/
        return $this->id;
    }/*}}}*/
    /* generated code end */
}
