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
        $rawData = $ml->get(0, 0, 'date desc');
        $return = array();
        foreach($rawData as $row){
            $return[$row->cid][] = $row;
        }
        return $return;
    }

    public function load_by_cid($cid){
        $query = $this->db->order_by('date', 'desc')->get_where($this::DB_TABLE, array(
            'cid' => $cid,
        ));
        $return = array();
        if($query){
            foreach($query->result() as $row){
                $return[] = $row;
            }
        }
        return $return;
    }
}

?>