<?php

class tag extends entity
{
    /* generated code start */
    public $structs = [
        'system_id' => 0,
        'group_id' => 0,
        'name' => '',
    ];

    public static $struct_data_types = [
        'system_id' => 'number',
        'group_id' => 'number',
        'name' => 'string',
    ];

    public static $struct_display_names = [
        'system_id' => '系统ID',
        'group_id' => '分组ID',
        'name' => '名称',
    ];


    public static $struct_is_required = [
        'system_id' => true,
        'group_id' => false,
        'name' => true,
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('system');
        $this->belongs_to('group');
        $this->has_many('tag_targets', 'tag_target');
    }/*}}}*/

    public static function create(system $system, $name)
    {/*{{{*/
        $tag = parent::init();

        $tag->system = $system;
        $tag->name = $name;

        return $tag;
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

    public function belongs_to_group(group $group)
    {/*{{{*/
        return $this->group_id == $group->id;
    }/*}}}*/

    public function delete()
    {/*{{{*/
        foreach ($this->tag_targets as $tag_target) {
            if ($tag_target->tag_id === $this->id) {
                $tag_target->delete();
            }
        }

        parent::delete();
    }/*}}}*/

    public function display_for_system_tags()
    {/*{{{*/
        return $this->id;
    }/*}}}*/

    public function display_for_group_tags()
    {/*{{{*/
        return $this->id;
    }/*}}}*/

    public function display_for_tag_targets_tag()
    {/*{{{*/
        return $this->id;
    }/*}}}*/
    /* generated code end */
}
