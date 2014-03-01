<?php

class Upload_list_items extends MY_Model{
    const DB_TABLE = 'upload_list_items';
    const DB_TABLE_PK = 'item_id';

    public $item_id;
    public $list_id;
    public $company_name;
    public $existed_client_id;

    public function get_upload_info($_lid){
    	$_uis = $this->get_by_conditions(array('list_id' => $_lid));
    	$return = $_cids = array();
    	foreach($_uis as $_ui){
    		$_cids[] = $_ui->existed_client_id;
    	}
    	$query = $this->db->from('clients')
    					->where_in('id', $_cids)
    					->get();
		if($query){
			foreach($query->result() as $row){
				$return[] = $row;
			}
		}
		return $return;
    }
}
?>