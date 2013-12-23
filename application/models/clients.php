<?php

class Clients extends MY_Model{
	const DB_TABLE = 'clients';
	const DB_TABLE_PK = 'id';

	/**
	 * client ID
	 * @var int
	 */
	public $id;

	/**
	 * client's name
	 * @var string
	 */
	public $name;

	/**
	 * client's address
	 * @var string
	 */
	public $address;

	/**
	 * client's contact name
	 * @var string
	 */
	public $contact;

	/**
	 * client's phone number 1
	 * @var string
	 */
	public $phone1;

	/**
	 * client's phone number 2
	 * @var string
	 */
	public $phone2;

	/**
	 * client's phone number 3
	 * @var string
	 */
	public $phone3;

	/**
	 * progress id
	 * @var int
	 */
	public $progress;

	public $status;

	public $area;

	public $note;

	public $level1;

	public $level2;

	public $level3;

	public $level4;

	public $level5;

	public $is_hightech;

	public $hightech_cert_id;
    public $hightech_year;
	public $is_soft_comp;

	public $soft_comp_cert_id;
    public $staff_id;
    public $staff;
    public $created;
    public $primary_project;


    public $marketing_log;
    public $pc_info;

    public static function get_all_clients($mlClass, $pcClass){
        $c = new Clients();
        $all = $c->get();
        if(!empty($all)){
            $client_ids = array_keys($all);
            $all_ml = $mlClass->get(0, 0, 'date desc');
            $all_pc = $pcClass->get();
            foreach($all_ml as $ml){
                if(in_array($ml->cid, $client_ids)) $all[$ml->cid]->marketing_log[] = $ml;
            }
            foreach($all_pc as $pc){
                if(in_array($pc->client_id, $client_ids)) $all[$pc->client_id]->pc_info[$pc->proj_id] = $pc;
            }
        }
        #echo '<pre>';var_dump($all);die();
        return $all;
    }
    public function findClientByName($client_name){
        $query = $this->db->get_where($this::DB_TABLE, array(
            'name' => $client_name
        ));
        if($query){
            $row = $query->row();
            if(!empty($row)){
                $this->populate($row);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    public static function get_client_name_by_id($cid){
        $c = new Clients();
        $c->load($cid);
        return $c->name;
    }

    public function get_clients_by_staff_id($sid){
        $query = $this->db->order_by('created desc')->get_where($this::DB_TABLE, array(
            'staff_id' => $sid
        ), 5, 0);
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