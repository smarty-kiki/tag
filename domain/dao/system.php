<?php

class system_dao extends dao
{
    protected $table_name = 'system';
    protected $db_config_key = 'default';

    /* generated code start */
    public function find_by_name($name)
    {/*{{{*/
        return $this->find_by_column([
            'name' => $name,
        ]);
    }/*}}}*/
    /* generated code end */

    public function find_by_key($key)
    {/*{{{*/
        return $this->find_by_column([
            'key' => $key,
        ]);
    }/*}}}*/
}
