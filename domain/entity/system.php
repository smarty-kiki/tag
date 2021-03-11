<?php

class system extends entity
{
    /* generated code start */
    public $structs = [
        'name' => '',
        'key' => '',
    ];

    public static $struct_data_types = [
        'name' => 'string',
        'key' => 'string',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'key' => '密钥',
    ];


    public static $struct_is_required = [
        'name' => true,
        'key' => true,
    ];

    public function __construct()
    {/*{{{*/
        $this->has_many('groups', 'group');
        $this->has_many('tags', 'tag');
        $this->has_many('tag_targets', 'tag_target');
    }/*}}}*/

    public static function create($name, $key)
    {/*{{{*/
        $system = parent::init();

        $system->name = $name;
        $system->key = $key;

        return $system;
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
            'key' => [
                [
                    'function' => function ($value) {
                        return mb_strlen($value) <= 50;
                    },
                    'failed_message' => '不能超过 50 个字符',
                ],
            ],
        ];

        return $formaters[$property] ?? false;
    }/*}}}*/

    public function delete()
    {/*{{{*/
        foreach ($this->groups as $group) {
            if ($group->system_id === $this->id) {
                $group->delete();
            }
        }
        foreach ($this->tags as $tag) {
            if ($tag->system_id === $this->id) {
                $tag->delete();
            }
        }
        foreach ($this->tag_targets as $tag_target) {
            if ($tag_target->system_id === $this->id) {
                $tag_target->delete();
            }
        }

        parent::delete();
    }/*}}}*/

    public function display_for_groups_system()
    {/*{{{*/
        return $this->name;
    }/*}}}*/

    public function display_for_tags_system()
    {/*{{{*/
        return $this->id;
    }/*}}}*/

    public function display_for_tag_targets_system()
    {/*{{{*/
        return $this->name;
    }/*}}}*/
    /* generated code end */

    public static function create_generate_key($name)
    {/*{{{*/
        return self::create($name, md5(datetime()));
    }/*}}}*/
}
