<?php

class tag_target_dao extends dao
{
    protected $table_name = 'tag_target';
    protected $db_config_key = 'default';

    /* generated code start */
    /* generated code end */

    public function find_all_by_tag_and_class_and_class_id(tag $tag, $class, array $class_ids)
    {/*{{{*/
        return $this->find_all_by_column([
            'tag_id'   => $tag->id,
            'class'    => $class,
            'class_id' => $class_ids,
        ]);
    }/*}}}*/
}
