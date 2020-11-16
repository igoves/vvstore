<?php
/*
=====================================================
 vvStore - by xfor.top
=====================================================
*/
if (!defined('XFOR')) die('Hacking attempt!');

class db extends SQLite3
{
    public function __construct()
    {
        $this->open(DB_DIR . '/db_ru.sqlite');
    }

    public function safesql($source)
    {
        return addslashes($source);
    }

    public function get_row($query)
    {
        return $query->fetchArray();
    }

    public function super_query($query)
    {
        return $this->querySingle($query, true);
    }

    public function num_rows($sql)
    {
        $i = 0;
        while ($res = $sql->fetchArray()) {
            $i++;
        }
        return $i;
    }

    public function insert_id()
    {
        return $this->lastInsertRowID();
    }
}

$db = new db();

if (!$db) die($db->lastErrorMsg());
