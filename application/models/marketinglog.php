<?php

class Marketinglog extends MY_Model{
	const DB_TABLE = 'marketing_log';
	const DB_TABLE_PK = 'id';

	public $id;

	public $cid;

	public $date;

	public $detail;

	public $sid;

	public $staff;

    public static function getAllLog(){
        $ml = new Marketinglog();
        $rawData = $ml->get();
        $return = array();
        foreach($rawData as $row){
            $return[$row->cid][] = $row;
        }
        return $return;
    }

    public function load_by_cid($cid){
        $query = $this->db->get_where($this::DB_TABLE, array(
            'cid' => $cid,
        ));
        if($query) $this->populate($query->row());
    }
}

?>