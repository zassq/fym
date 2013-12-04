<?php

class Fymauth_model extends CI_Model{

    public $users_table;

    public function __construct(){
        parent::__construct();
        #$this->config->load('fym');

        $this->users_table = $this->config->item('fymauth_users_table');
        if(!$this->db->table_exists($this->users_table)) $this->create_users_table();
    }

    public function get_user_by_username($username){
        $query = $this->db->get_where($this->users_table, array('username' => $username));
        if($query->num_rows()) return $query->row();
        return false;
    }

    public function create_user($userdata){
        $userdata['email'] = filter_var($userdata['email'], FILTER_SANITIZE_EMAIL);
        $userdata['created'] = date('Y-m-d H:i:s');
        $this->db->insert($this->users_table, $userdata);
        return $this->db->insert_id();
    }

    public function update_user($user_id, $data){
        $this->db->where('id', $user_id);
        $this->db->update($this->users_table, $data);
    }

    private function create_users_table(){
        $this->load->dbforge();
        $this->dbforge->add_field('id INT(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field('name VARCHAR(200) NOT NULL');
        $this->dbforge->add_field('usertype CHAR(1) NOT NULL');
        $this->dbforge->add_field('access VARCHAR(16) NOT NULL');
        $this->dbforge->add_field('username VARCHAR(200) NOT NULL');
        $this->dbforge->add_field('password VARCHAR(255) NOT NULL');
        $this->dbforge->add_field('email VARCHAR(128) NOT NULL');
        $this->dbforge->add_field('note TEXT NOT NULL');
        $this->dbforge->add_field('created DATETIME NOT NULL');
        $this->dbforge->add_field('last_login DATETIME NOT NULL');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('name');
        $this->dbforge->add_key('usertype');
        $this->dbforge->add_key('username');
        $this->dbforge->add_key('email');
        $this->dbforge->create_table($this->users_table);
    }
}

?>