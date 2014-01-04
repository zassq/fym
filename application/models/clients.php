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
    public $primary_project_year;


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

    public static function ajax_list_detail($paras, $mlClass, $pcClass){
        $c = new Clients();
        $db = $c->db;
        $aColumns = array( 'name', 'progress', 'status', 'primary_project', 'primary_project_year','level1', 'area', 'staff' );

        $return = array();
        $db->select($c::DB_TABLE.'.*');
        if ( isset( $paras['iDisplayStart'] ) && $paras['iDisplayLength'] != '-1' ){
            $db->limit(intval($paras['iDisplayLength']), intval($paras['iDisplayStart']));
        }

        if ( isset($paras['iSortCol_0'])){
            for ( $i=0 ; $i<intval( $paras['iSortingCols'] ) ; $i++ ){
                if ( $paras[ 'bSortable_'.intval($paras['iSortCol_'.$i]) ] == "true" ){
                    $db->order_by($aColumns[ intval( $paras['iSortCol_'.$i] ) ], ($paras['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'));
                }
            }
        }

        if ( isset($paras['sSearch']) && $paras['sSearch'] != "" ){
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $db->or_like($aColumns[$i], $paras['sSearch']);
            }
        }

        $db->from($c::DB_TABLE);

        /* Individual column filtering */
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                switch($aColumns[$i]){
                    case 'progress':
                        #$db->from('progress')->where(array('progress.progress' => $paras['sSearch_'.$i], 'progress.id' => $db->dbprefix($c::DB_TABLE).'.progress'), null, false);
                        $db->join('progress', 'progress.id = '.$c::DB_TABLE.'.progress'.' AND '.$db->dbprefix('progress').'.progress = "'.$paras['sSearch_'.$i].'"');
                    break;
                    case 'status':
                        $db->join('status', 'status.id = '.$c::DB_TABLE.'.status'.' AND '.$db->dbprefix('status').'.status = "'.$paras['sSearch_'.$i].'"');
                    break;
                    case 'primary_project':
                        $db->join('projects', 'projects.proj_id = '.$c::DB_TABLE.'.primary_project'.' AND '.$db->dbprefix('projects').'.proj_name = "'.$paras['sSearch_'.$i].'"');
                    break;
                    case 'level1':
                        $db->join('hightech_level', 'hightech_level.id = '.$c::DB_TABLE.'.level1'.' AND '.$db->dbprefix('hightech_level').'.hightech_name = "'.$paras['sSearch_'.$i].'"');
                    break;
                    case 'area':
                        $db->where($aColumns[$i], $paras['sSearch_'.$i]);
                    break;
                    default:
                        $db->like($aColumns[$i], $paras['sSearch_'.$i]);
                    break;
                }
            }
        }

        $query = $db->get();
        if(!$query) return $return;

        foreach ($query->result_array() as $row) {
            $return[$row['id']] = $row;
        }
        $client_ids = array_keys($return);
        $all_ml = $mlClass->get(0, 0, 'date desc');
        //$all_pc = $pcClass->get();
        foreach($all_ml as $ml){
            if(in_array($ml->cid, $client_ids)) $return[$ml->cid]['marketing_log'][] = $ml;
        }
        /*foreach($all_pc as $pc){
            if(in_array($pc->client_id, $client_ids)) $return[$pc->client_id]['pc_info'][$pc->proj_id] = $pc;
        }*/
        #echo '<pre>';var_dump($a);die();
        return $return;
    }

    public static function ajax_list_detail_header($paras){
        $c = new Clients();
        $db = $c->db;
        $aColumns = $c->config->item('clients_listing_cols');

        $return = array();

        $db->start_cache();
        /*if ( isset( $paras['iDisplayStart'] ) && $paras['iDisplayLength'] != '-1' ){
            $db->limit(intval($paras['iDisplayLength']), intval($paras['iDisplayStart']));
        }*/

        if ( isset($paras['iSortCol_0'])){
            for ( $i=0 ; $i<intval( $paras['iSortingCols'] ) ; $i++ ){
                if ( $paras[ 'bSortable_'.intval($paras['iSortCol_'.$i]) ] == "true" ){
                    $db->order_by($aColumns[ intval( $paras['iSortCol_'.$i] ) ], ($paras['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'));
                }
            }
        }

        if ( isset($paras['sSearch']) && $paras['sSearch'] != "" ){
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $db->or_like($aColumns[$i], $paras['sSearch']);
            }
        }

        /* Individual column filtering */
        /*for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                $db->like($aColumns[$i], $paras['sSearch_'.$i]);
            }
        }*/
        $db->from($c::DB_TABLE);

        $db->stop_cache();

        foreach($aColumns as $k=> $v){
            if ( isset($paras['bSearchable_'.$k]) && $paras['bSearchable_'.$k] == "true" && $paras['sSearch_'.$k] != '' ){
                switch($v){
                    case 'progress':
                        #$db->from('progress')->where(array('progress.progress' => $paras['sSearch_'.$i], 'progress.id' => $db->dbprefix($c::DB_TABLE).'.progress'), null, false);
                        $db->distinct()->select('progress.progress')->join('progress', 'progress.id = '.$c::DB_TABLE.'.progress'.' AND '.$db->dbprefix('progress').'.progress = "'.$paras['sSearch_'.$k].'"');
                        break;
                    case 'status':
                        $db->distinct()->select('status.status')->join('status', 'status.id = '.$c::DB_TABLE.'.status'.' AND '.$db->dbprefix('status').'.status = "'.$paras['sSearch_'.$k].'"');
                        break;
                    case 'primary_project':
                        $db->distinct()->select('projects.proj_name as primary_project')->join('projects', 'projects.proj_id = '.$c::DB_TABLE.'.primary_project'.' AND '.$db->dbprefix('projects').'.proj_name = "'.$paras['sSearch_'.$k].'"');
                        break;
                    case 'level1':
                        $db->distinct()->select('hightech_level.hightech_name as level1')->join('hightech_level', 'hightech_level.id = '.$c::DB_TABLE.'.level1'.' AND '.$db->dbprefix('hightech_level').'.hightech_name = "'.$paras['sSearch_'.$k].'"');
                        break;
                    default:
                        $db->distinct()->select($v)->like($v, $paras['sSearch_'.$k]);
                        break;
                }
            }else{
                switch($v){
                    case 'progress':
                        $db->distinct()->select('progress.progress')->join('progress', 'progress.id = '.$c::DB_TABLE.'.progress');
                        break;
                    case 'status':
                        $db->distinct()->select('status.status')->join('status', 'status.id = '.$c::DB_TABLE.'.status');
                        break;
                    case 'primary_project':
                        $db->distinct()->select('projects.proj_name as primary_project')->join('projects', 'projects.proj_id = '.$c::DB_TABLE.'.primary_project');
                        break;
                    case 'level1':
                        $db->distinct()->select('hightech_level.hightech_name as level1')->join('hightech_level', 'hightech_level.id = '.$c::DB_TABLE.'.level1');
                        break;
                    default:
                        $db->distinct()->select($v);
                        break;
                }
            }

            $query = $db->get();
            if($query){
                foreach($query->result_array() as $row){
                    if(!empty($row[$v])) $return[$k][] = $row[$v];
                }
            }
        }
        #$a = $db->last_query();
        #echo '<pre>';var_dump($a);die();
        return $return;
    }

    public static function ajax_list_total($paras){
        $c = new Clients();
        $db = $c->db;
        $aColumns = $c->config->item('clients_listing_cols');

        if ( isset( $paras['iDisplayStart'] ) && $paras['iDisplayLength'] != '-1' ){
            $db->limit(intval($paras['iDisplayLength']), intval($paras['iDisplayStart']));
        }

        if ( isset($paras['iSortCol_0'])){
            for ( $i=0 ; $i<intval( $paras['iSortingCols'] ) ; $i++ ){
                if ( $paras[ 'bSortable_'.intval($paras['iSortCol_'.$i]) ] == "true" ){
                    $db->order_by($aColumns[ intval( $paras['iSortCol_'.$i] ) ], ($paras['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'));
                }
            }
        }

        if ( isset($paras['sSearch']) && $paras['sSearch'] != "" ){
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $db->or_like($aColumns[$i], $paras['sSearch']);
            }
        }

        /* Individual column filtering */
        /*for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                $db->like($aColumns[$i], $paras['sSearch_'.$i]);
            }
        }*/
        $db->from($c::DB_TABLE);

        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                switch($aColumns[$i]){
                    case 'progress':
                        #$db->from('progress')->where(array('progress.progress' => $paras['sSearch_'.$i], 'progress.id' => $db->dbprefix($c::DB_TABLE).'.progress'), null, false);
                        $db->join('progress', 'progress.id = '.$c::DB_TABLE.'.progress'.' AND '.$db->dbprefix('progress').'.progress = "'.$paras['sSearch_'.$i].'"');
                        break;
                    case 'status':
                        $db->join('status', 'status.id = '.$c::DB_TABLE.'.status'.' AND '.$db->dbprefix('status').'.status = "'.$paras['sSearch_'.$i].'"');
                        break;
                    case 'primary_project':
                        $db->join('projects', 'projects.proj_id = '.$c::DB_TABLE.'.primary_project'.' AND '.$db->dbprefix('projects').'.proj_name = "'.$paras['sSearch_'.$i].'"');
                        break;
                    case 'level1':
                        $db->join('hightech_level', 'hightech_level.id = '.$c::DB_TABLE.'.level1'.' AND '.$db->dbprefix('hightech_level').'.hightech_name = "'.$paras['sSearch_'.$i].'"');
                        break;
                    case 'area':
                        $db->where($aColumns[$i], $paras['sSearch_'.$i]);
                        break;
                    default:
                        $db->like($aColumns[$i], $paras['sSearch_'.$i]);
                        break;
                }
            }
        }

        return $db->count_all_results();
    }
}

?>