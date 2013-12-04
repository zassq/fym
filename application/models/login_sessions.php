<?php

class Login_sessions extends MY_Model{
    const DB_TABLE = 'login_sessions';
    const DB_TABLE_PK = 'id';

    public $id;
    public $token;
    public $date;
    public $uname;
    public $key;

    public function delete_by_uname($uname){
        $ids = $this->get_ids_by_uname($uname);
        if($ids){
            $ids = implode(',', $ids);
            $this->db->query("DELETE FROM ".$this->db->dbprefix($this::DB_TABLE)." WHERE id IN (".$ids.")");
        }
    }

    /**
     * @param $uname
     * return array
     */
    public function get_ids_by_uname($uname){
        $this->load->library('user_agent');
        $this->load->helper('security');
        $return = false;
        $query = $this->db->select('id')->where(array('uname'=> $uname, 'key' => do_hash($this->agent->agent_string(), 'md5')))->get($this::DB_TABLE);
        if($query){
            foreach ($query->result_array() as $row){
                $return = $row;
            }
        }
        return $return;
    }
}

?>