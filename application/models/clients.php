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

	public $is_soft_comp;

	public $soft_comp_cert_id;
    public $staff_id;
    public $staff;
    public $marketing_log;

    public static function get_all_clients($mlClass){
        $c = new Clients();
        $all = $c->get();
        $all_ml = $mlClass->get(0, 0, 'date desc');
        foreach($all_ml as $ml){
            $all[$ml->cid]->marketing_log[] = $ml;
        }
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
}

?>