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

    private function _build_paging($paras){
        $sLimit = "";
        if ( isset( $paras['iDisplayStart'] ) && $paras['iDisplayLength'] != '-1' ){
            $sLimit = "LIMIT ".intval( $paras['iDisplayStart'] ).", ".intval( $paras['iDisplayLength'] );
        }
        return $sLimit;
    }

    private function _build_ordering($paras){
        $aColumns = $this->config->item('clients_listing_cols');
        $sOrder = "";
        if(!isset($paras['sSearch'])){
            if ( isset( $paras['iSortCol_0'] ) ){
                $sOrder = "ORDER BY  ";
                for ( $i=0 ; $i<intval( $paras['iSortingCols'] ) ; $i++ ){
                    if ( $paras[ 'bSortable_'.intval($paras['iSortCol_'.$i]) ] == "true" ){
                        $sOrder .= "`".$aColumns[ intval( $paras['iSortCol_'.$i] ) ]."` ".($paras['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
                    }
                }

                $sOrder = substr_replace( $sOrder, "", -2 );
                if ( $sOrder == "ORDER BY" ){
                    $sOrder = "";
                }
            }
        }
        return $sOrder;
    }

    private function _build_filtering($paras, $aColumns, $aTables, $aFields, $_client_table){
        $_sWhere_ele = array();
        $sFrom = array();
        $return = array();
        if(isset($paras['sSearch']) && '' != $paras['sSearch']){
            foreach($aColumns as $k => $ac){
                $_aTable = $this->db->protect_identifiers($aTables[$k], true);
                #if(!in_array($_aTable, $sFrom)) $sFrom[] = $_aTable;
                switch($ac){
                    case 'name':
                    case 'primary_project_year':
                    case 'area':
                    case 'staff':
                    default:
                        #$_sWhere_ele[] = $_aTable.".".$aFields[$k]." LIKE '%".$this->db->escape_like_str($paras['sSearch'])."%'";
                        $_sWhere_ele[] = $_client_table.".".$ac." LIKE '%".$this->db->escape_like_str($paras['sSearch'])."%'";
                        break;
                    /*case 'progress':
                    case 'status':
                        #if ( isset($paras['bSearchable_'.$k]) && $paras['bSearchable_'.$k] == "true" && $paras['sSearch_'.$k] != '' && ($paras['sSearch_'.$k] == 'progress' || $paras['sSearch_'.$k] == 'status' )) break;
                        $_sWhere_ele[] = "(".$_aTable.".id = ".$_client_table.".".$aFields[$k]." AND ".$_aTable.".".$aFields[$k]." LIKE '%".$this->db->escape_like_str($paras['sSearch'])."%')";
                        break;
                    case 'level1':
                        $_sWhere_ele[] = "(".$_aTable.".id = ".$_client_table.".level1 AND ".$_aTable.".".$aFields[$k]." LIKE '%".$this->db->escape_like_str($paras['sSearch'])."%')";
                        break;
                    case 'primary_project':
                        $_sWhere_ele[] = "(".$_aTable.".proj_id = ".$_client_table.".primary_project AND ".$_aTable.".".$aFields[$k]." LIKE '%".$this->db->escape_like_str($paras['sSearch'])."%')";
                        break;*/
                }
            }
            // For marketing_log
            /*$ml_table = $this->db->protect_identifiers("marketing_log", true);
            $sFrom[] = $ml_table;
            $_sWhere_ele[] = "(".$ml_table.".cid = ".$_client_table.".id AND ".$ml_table.".detail LIKE '%".$this->db->escape_like_str($paras['sSearch'])."%')";*/
        }
        $return[] = $_sWhere_ele;
        $return[] = $sFrom;
        return $return;
    }

    public function _build_individual_filter($paras, $aColumns, $aTables, $aFields, $_client_table){
        $_sWhere_ele = array();
        $sFrom = array();
        $return = array();
        for($i=0;$i<count($aColumns);$i++){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                $_aTable = $this->db->protect_identifiers($aTables[$i], true);
                if(!in_array($_aTable, $sFrom)) $sFrom[] = $_aTable;
                switch($aColumns[$i]){
                    case 'progress':
                    case 'status':
                        $_sWhere_ele[] = "(".$_aTable.".id = ".$_client_table.".".$aFields[$i]." AND ".$_aTable.".".$aFields[$i]." = ".$this->db->escape($paras['sSearch_'.$i]).")";
                        break;
                    case 'primary_project':
                        $_sWhere_ele[] = "(".$_aTable.".proj_id = ".$_client_table.".primary_project AND ".$_aTable.".".$aFields[$i]." = ".$this->db->escape($paras['sSearch_'.$i]).")";
                        break;
                    case 'level1':
                        $_sWhere_ele[] = "(".$_aTable.".id = ".$_client_table.".level1 AND ".$_aTable.".".$aFields[$i]." = ".$this->db->escape($paras['sSearch_'.$i]).")";
                        break;
                    case 'area':
                        $_sWhere_ele[] = $_aTable.".".$aFields[$i]." = ".$this->db->escape($paras['sSearch_'.$i])."";
                        break;
                    default:
                        $_sWhere_ele[] = $_aTable.".".$aFields[$i]." LIKE '%".$this->db->escape_like_str($paras['sSearch_'.$i])."%'";
                        break;
                }
            }
        }
        $return[] = $_sWhere_ele;
        $return[] = $sFrom;
        return $return;
    }

    public function _build_ajax_listing_details_sql($paras, $forHeader = false){
        $aColumns = $this->config->item('clients_listing_cols');
        $aTables = $this->config->item('clients_listing_tables');
        $aFields = $this->config->item('clients_listing_fields');
        $_client_table = $this->db->protect_identifiers($this::DB_TABLE, true);
        $sFrom = array();
        $sFrom[] = $_client_table;
        $sWhere = 'WHERE ';

        // Paging
        $sLimit = $this->_build_paging($paras);

        // Ordering
        $sOrder = $this->_build_ordering($paras);

        // Filtering
        $_filter = $this->_build_filtering($paras, $aColumns, $aTables, $aFields, $_client_table);
        list($_sWhere_ele, $_sFrom) = $_filter;
        $sFrom = array_unique(array_merge($_sFrom, $sFrom));

        if(count($_sWhere_ele)>0) $sWhere .= "(".implode(" OR ", $_sWhere_ele).")";
        unset($_sWhere_ele);

        // Individual column filtering
        $_individual_filter= $this->_build_individual_filter($paras, $aColumns, $aTables, $aFields, $_client_table);
        list($_sWhere_ele, $_sFrom) = $_individual_filter;
        $sFrom = array_unique(array_merge($_sFrom, $sFrom));

        if(count($_sWhere_ele)>0) $sWhere .= (($sWhere == 'WHERE ')? '' : " AND").implode(" AND ", $_sWhere_ele);

        if(isset($paras['staff_id'])) $sWhere .= (($sWhere == 'WHERE ')? '' : " AND").' '.$_client_table.'.staff_id = '.$paras['staff_id'];

        if($sWhere == 'WHERE ') $sWhere = '';
        $sql = "SELECT SQL_CALC_FOUND_ROWS ".$_client_table.".* FROM ".implode(', ', $sFrom)." ".$sWhere." GROUP BY ".$_client_table.".id ".$sOrder." ".$sLimit;
        #echo '<pre>';var_dump($sql);die();
        if($forHeader){
            $return = array($_client_table, $sFrom, $sWhere, $sLimit);
            return $return;
        }
        return $sql;
    }

    public static function ajax_list_detail($paras, $mlClass){
        $c = new Clients();
        $db = $c->db;
        $sql = $c->_build_ajax_listing_details_sql($paras);

        $return = array();
        $query = $db->query($sql);
        if(!$query) return $return;

        $total_query = $db->query("SELECT FOUND_ROWS() AS total");
        if(!$total_query) return $return;
        $_total = $total_query->first_row('array');

        foreach ($query->result_array() as $row) {
            $return[$row['id']] = $row;
        }
        $client_ids = array_keys($return);
        $all_ml = $mlClass->get(0, 0, 'date desc');
        foreach($all_ml as $ml){
            if(in_array($ml->cid, $client_ids)) $return[$ml->cid]['marketing_log'][] = $ml;
        }

        $return['iTotalDisplayRecords'] = $_total['total'];
        return $return;
    }

    public static function ajax_list_detail_header($paras){
        $c = new Clients();
        $db = $c->db;
        $aColumns = $c->config->item('clients_listing_cols');
        $aTables = $c->config->item('clients_listing_tables');
        $aFields = $c->config->item('clients_listing_fields');
        $_sql = $c->_build_ajax_listing_details_sql($paras, true);
        list($_client_table, $sFrom, $sWhere, $sLimit) = $_sql;
        $return = array();

        foreach($aColumns as $k=> $v){
            $_aTable = $db->protect_identifiers($aTables[$k], true);
            $sql = '';
            if(!in_array($_aTable, $sFrom)) $sFrom[] = $_aTable;
            switch($v){
                case 'progress':
                case 'status':
                    $sql .= "SELECT DISTINCT ".$_aTable.".".$aFields[$k].
                           " FROM ".implode(', ', $sFrom).
                           $sWhere.(( '' == $sWhere ) ? ' WHERE ' : ' AND ').$_aTable.".id = ".$_client_table.".".$aFields[$k]
                           #." ".$sLimit
                    ;
                    break;
                case 'primary_project':
                    $sql .= "SELECT DISTINCT ".$_aTable.".".$aFields[$k]." AS primary_project".
                        " FROM ".implode(', ', $sFrom).
                        $sWhere.(( '' == $sWhere ) ? ' WHERE ' : ' AND ').$_aTable.".proj_id = ".$_client_table.".primary_project"
                        #." ".$sLimit
                    ;
                    break;
                case 'level1':
                    $sql .= "SELECT DISTINCT ".$_aTable.".".$aFields[$k]." AS level1".
                        " FROM ".implode(', ', $sFrom).
                        $sWhere.(( '' == $sWhere ) ? ' WHERE ' : ' AND ').$_aTable.".id = ".$_client_table.".level1"
                        #." ".$sLimit
                    ;
                    break;
                default:
                    $sql .= "SELECT DISTINCT ".$_client_table.".".$v.
                        " FROM ".implode(', ', $sFrom).
                        $sWhere
                        #." ".$sLimit
                    ;
                    break;
            }

            $query = $db->query($sql);
            if($query){
                foreach($query->result_array() as $row){
                    if(!empty($row[$v])) $return[$k][] = $row[$v];
                }
            }
        }

        return $return;
    }

    public static function _ajax_list_detail_header($paras){
        $c = new Clients();
        $db = $c->db;
        $aColumns = $c->config->item('clients_listing_cols');
        $aTables = $c->config->item('clients_listing_tables');
        $aFields = $c->config->item('clients_listing_fields');

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
            $db = $c::_process_search_keyword($db, $paras);
        }

        /* Individual column filtering */
        /*for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                $db->like($aColumns[$i], $paras['sSearch_'.$i]);
            }
        }*/
        $db->from($c::DB_TABLE);

        $db = $c::_process_column_filtering($db, $aColumns, $paras);

        $db->stop_cache();
        foreach($aColumns as $k=> $v){
            switch($v){
                case 'progress':
                    #$db->distinct()->select('progress.progress')->join('progress', 'progress.id = '.$c::DB_TABLE.'.progress');
                    $db->distinct()->select('progress.progress')->from('progress')->where('progress.id = '.$db->dbprefix($c::DB_TABLE).'.progress');
                    break;
                case 'status':
                    $db->distinct()->select('status.status')->from('status')->where('status.id = '.$db->dbprefix($c::DB_TABLE).'.status');
                    break;
                case 'primary_project':
                    $db->distinct()->select('projects.proj_name as primary_project')->from('projects')->where('projects.proj_id = '.$db->dbprefix($c::DB_TABLE).'.primary_project');
                    break;
                case 'level1':
                    $db->distinct()->select('hightech_level.hightech_name as level1')->from('hightech_level')->where('hightech_level.id = '.$db->dbprefix($c::DB_TABLE).'.level1');
                    break;
                default:
                    $db->distinct()->select($v);
                    break;
            }

            $query = $db->get();
            if($query){
                foreach($query->result_array() as $row){
                    if(!empty($row[$v])) $return[$k][] = $row[$v];
                }
            }
        }
        return $return;
    }

    public static function _ajax_list_total($paras){
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
            /*for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $db->or_like($aColumns[$i], $paras['sSearch']);
            }*/
            $db = $c::_process_search_keyword($db, $paras);
        }

        /* Individual column filtering */
        /*for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                $db->like($aColumns[$i], $paras['sSearch_'.$i]);
            }
        }*/
        $db->from($c::DB_TABLE);

        $db = $c::_process_column_filtering($db, $aColumns, $paras);

        #$return = $db->count_all_results();
        $return = count($db->get()->result_array());

        #$a = $db->last_query();
        #echo '<pre>';var_dump($return);die();
        return $return;
    }

    private static function _process_column_filtering($db, $aColumns, $paras){
        $c = new Clients();
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($paras['bSearchable_'.$i]) && $paras['bSearchable_'.$i] == "true" && $paras['sSearch_'.$i] != '' ){
                switch($aColumns[$i]){
                    case 'progress':
                        $db->from('progress')->where('progress.progress = "'.$paras['sSearch_'.$i].'"')->where('progress.id = '.$db->dbprefix($c::DB_TABLE).'.progress');
                        break;
                    case 'status':
                        $db->from('status')->where("status.status = ".$db->escape($paras['sSearch_'.$i]))->where('status.id = '.$db->dbprefix($c::DB_TABLE).'.status');
                        break;
                    case 'primary_project':
                        $db->from('projects')->where('projects.proj_name = "'.$paras['sSearch_'.$i].'"')->where('projects.proj_id = '.$db->dbprefix($c::DB_TABLE).'.primary_project');
                        break;
                    case 'level1':
                        $db->from('hightech_level')->where('hightech_level.hightech_name = "'.$paras['sSearch_'.$i].'"')->where('hightech_level.id = '.$db->dbprefix($c::DB_TABLE).'.level1');
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
        return $db;
    }

    private static function _process_search_keyword($db, $paras){
        $c = new Clients();
        $aColumns = $c->config->item('clients_listing_cols');
        $aTables = $c->config->item('clients_listing_tables');
        $aFields = $c->config->item('clients_listing_fields');

        foreach($aColumns as $i => $av){
            switch($av){
                case 'name':
                case 'area':
                case 'staff':
                    $db->or_like($aTables[$i].'.'.$aFields[$i], $paras['sSearch']);
                    break;
                case 'progress':
                    $db->from($aTables[$i])->where('progress.id = '.$db->dbprefix($c::DB_TABLE).'.progress')->or_like($aTables[$i].'.'.$aFields[$i], $paras['sSearch']);
                    break;
                case 'status':
                    $db->from($aTables[$i])->where('status.id = '.$db->dbprefix($c::DB_TABLE).'.status')->or_like($aTables[$i].'.'.$aFields[$i], $paras['sSearch']);
                    break;
                case 'primary_project':
                    $db->from($aTables[$i])->where('projects.proj_id = '.$db->dbprefix($c::DB_TABLE).'.primary_project')->or_like($aTables[$i].'.'.$aFields[$i], $paras['sSearch']);
                    break;
                case 'primary_project_year':
                    $db->or_where($aTables[$i].'.'.$aFields[$i], $paras['sSearch']);
                    break;
                case 'level1':
                    $db->from('hightech_level')->where('hightech_level.id = '.$db->dbprefix($c::DB_TABLE).'.level1')->or_like($aTables[$i].'.'.$aFields[$i], $paras['sSearch']);
                    break;
            }
        }

        return $db;
    }

    public static function count_all(){
        $cn = get_called_class();
        $a = new $cn();
        $db = $a->db;
        return $db->count_all($a::DB_TABLE);
    }
}

?>