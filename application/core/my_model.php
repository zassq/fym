<?php
if(!class_exists('CI_Model')) { class CI_Model extends Model { } }

class MY_Model extends CI_Model {
    const DB_TABLE = 'abstract';
    const DB_TABLE_PK = 'abstract';
    
    /**
     * Create record.
     */
    private function insert() {
        $this->db->insert($this::DB_TABLE, $this);
        $this->{$this::DB_TABLE_PK} = $this->db->insert_id();
    }
    
    /**
     * Update record.
     */
    private function update() {
        $this->db->update($this::DB_TABLE, $this, array($this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}));
    }
    
    /**
     * Populate from an array or standard class.
     * @param mixed $row
     */
    public function populate($row) {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }
    
    /**
     * Load from the database.
     * @param int $id
     */
    public function load($id) {
        $query = $this->db->get_where($this::DB_TABLE, array(
            $this::DB_TABLE_PK => $id,
        ));
        if($query) $this->populate($query->row());
    }
    
    /**
     * Delete the current record.
     */
    public function delete() {
        $this->db->delete($this::DB_TABLE, array(
           $this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK},
        ));
        unset($this->{$this::DB_TABLE_PK});
    }
    
    /**
     * Save the record.
     */
    public function save() {
        if (isset($this->{$this::DB_TABLE_PK})) {
            $this->update();
        }
        else {
            $this->insert();
        }
    }
    
    /**
     * Get an array of Models with an optional limit, offset.
     * 
     * @param int $limit Optional.
     * @param int $offset Optional; if set, requires $limit.
     * @return array Models populated by database, keyed by PK.
     */
    public function get($limit = 0, $offset = 0, $order_by = '') {
        if(!empty($order_by)) $this->db->order_by($order_by);
        if ($limit) {
            $query = $this->db->get($this::DB_TABLE, $limit, $offset);
        }
        else {
            $query = $this->db->get($this::DB_TABLE);
        }
        $ret_val = array();
        if($query){
            $class = get_class($this);
            foreach ($query->result() as $row) {
                $model = new $class;
                $model->populate($row);
                $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
            }
        }
        return $ret_val;
    }

    public function get_by_conditions($where= array(), $limit = 0, $offset = 0, $order_by = '', $operator = 'where') {
        if(!empty($order_by)) $this->db->order_by($order_by);
        if(!empty($where)) $this->db->$operator($where);
        if ($limit) {
            $query = $this->db->get($this::DB_TABLE, $limit, $offset);
        }
        else {
            $query = $this->db->get($this::DB_TABLE);
        }
        $ret_val = array();
        if($query){
            $class = get_class($this);
            foreach ($query->result() as $row) {
                $model = new $class;
                $model->populate($row);
                $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
            }
        }
        return $ret_val;
    }

    public function get_value_pair($value,$limit = 0, $offset = 0){
        if ($limit) {
            $query = $this->db->order_by($this::DB_TABLE_PK, 'asc')->get($this::DB_TABLE, $limit, $offset);
        }
        else {
            $query = $this->db->order_by($this::DB_TABLE_PK, 'asc')->get($this::DB_TABLE);
        }
        $return = array();
        if($query){
            foreach($query->result_array() as $row)
                $return[$row[$this::DB_TABLE_PK]] = $row[$value];
        }
        return $return;
    }

    public static function count_all(){
        $cn = get_called_class();
        $a = new $cn();
        $db = $a->db;
        return $db->count_all($a::DB_TABLE);
    }
}