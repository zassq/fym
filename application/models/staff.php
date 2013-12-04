<?php

class Staff extends MY_Model{
	const DB_TABLE = 'staff';
	const DB_TABLE_PK = 'id';

	public $id;
	public $name;
	public $usertype;
	public $access;
    public $username;
	public $password;
    public $email;
	public $note;
    public $last_login;
    public $created;

    public static function get_staff($include_admin = FALSE){
        $s = new Staff;
        $all = $s->get();
        $return = array();
        if($all){
            foreach($all as $k=>$v){
                if(!$include_admin && $v->usertype == 'A') continue;
                $return[$v->id] = $v->name;
            }
        }
        return $return;
    }
}

?>