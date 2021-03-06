<?php

class tag_target extends entity
{
    const REDIS_KEY_PREFIX = 'TAG_TARGET_';

    /* generated code start */
    public $structs = [
        'system_id' => 0,
        'tag_id' => 0,
        'class' => '',
        'class_id' => 0,
        'description' => '',
    ];

    public static $struct_data_types = [
        'system_id' => 'number',
        'tag_id' => 'number',
        'class' => 'string',
        'class_id' => 'number',
        'description' => 'string',
    ];

    public static $struct_display_names = [
        'system_id' => '系统ID',
        'tag_id' => '标签ID',
        'class' => '目标类型',
        'class_id' => '目标ID',
        'description' => '描述',
    ];


    public static $struct_is_required = [
        'system_id' => true,
        'tag_id' => true,
        'class' => true,
        'class_id' => true,
        'description' => false,
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('system');
        $this->belongs_to('tag');
    }/*}}}*/

    public static function create(system $system, tag $tag, $class, $class_id)
    {/*{{{*/
        $tag_target = parent::init();

        $tag_target->system = $system;
        $tag_target->tag = $tag;
        $tag_target->class = $class;
        $tag_target->class_id = $class_id;

        cache_setbit(self::REDIS_KEY_PREFIX.$system->id.'_'.$class.'_'.$tag->id, $class_id, 1);

        return $tag_target;
    }/*}}}*/

    public static function struct_formaters($property)
    {/*{{{*/
        $formaters = [
            'class' => [
                [
                    'function' => function ($value) {
                        return mb_strlen($value) <= 30;
                    },
                    'failed_message' => '不能超过 30 字',
                ],
            ],
            'class_id' => [
                [
                    'function' => function ($value) {
                        return mb_strlen($value) <= 11;
                    },
                    'failed_message' => '不能超过 11 位',
                ],
                [
                    'function' => function ($value) {
                        return is_numeric($value);
                    },
                    'failed_message' => '必须为整数',
                ],
            ],
            'description' => [
                [
                    'function' => function ($value) {
                        return mb_strlen($value) <= 200;
                    },
                    'failed_message' => '不能超过 200 个字',
                ],
            ],
        ];

        return $formaters[$property] ?? false;
    }/*}}}*/

    public function belongs_to_system(system $system)
    {/*{{{*/
        return $this->system_id == $system->id;
    }/*}}}*/

    public function belongs_to_tag(tag $tag)
    {/*{{{*/
        return $this->tag_id == $tag->id;
    }/*}}}*/

    public function display_for_system_tag_targets()
    {/*{{{*/
        return $this->id;
    }/*}}}*/

    public function display_for_tag_tag_targets()
    {/*{{{*/
        return $this->id;
    }/*}}}*/
    /* generated code end */

    public function delete()
    {/*{{{*/
        cache_setbit(self::REDIS_KEY_PREFIX.$this->system_id.'_'.$this->class.'_'.$this->tag->id, $this->class_id, 0);

        parent::delete();
    }/*}}}*/
}
