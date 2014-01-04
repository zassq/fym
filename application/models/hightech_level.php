<?php

class Hightech_level extends MY_Model{
    const DB_TABLE = 'hightech_level';
    const DB_TABLE_PK = 'id';

    public $id;
    public $hightech_name;
    public $level;
    public $parent_level;

    public static function get_level1(){
        $hl = new Hightech_level();
        $levels = $hl->get();
        $return = array();
        foreach($levels as $k=>$level){
            if($level->level == '1') $return[$level->id] = $level->hightech_name;
        }
        ksort($return);
        return $return;
    }
}

?>