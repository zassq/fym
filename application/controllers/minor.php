<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Minor extends CI_Controller{

    public function __construct(){
        parent::__construct();

        #echo '<pre>';var_dump(Progress::get());die();
        if (defined('ENVIRONMENT') && 'development' == ENVIRONMENT && false){
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => TRUE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }
        $this->load->library(array('fymauth', 'msg'));
        #$this->load->model(array('progress', 'status', 'clients', 'marketinglog', 'staff', 'staff_log', 'hightech_level', 'certs'));
        #$progress = new Progress();
        #$status = new Status();

        if(!$this->fymauth->logged_in()) redirect('users/login');

        $this->userinfo = $this->session->userdata('user');
        $this->data = array(
            'logged_in' => true,
            'userinfo' => $this->userinfo,
            'here' => '',
            #'access' => $this->config->item('access'),
            #'usertype' => $this->config->item('usertype'),
            #'progress' => $progress->get_value_pair('progress'),
            #'status' => $status->get_value_pair('status'),
            #'error' => ''
        );

        $site_message = $this->msg->getMsg();
        if($site_message){
            $this->data['site_message'] = $site_message;
            unset($site_message);
        }
    }

    public function export_from_upload(){
        $data = $this->input->post('export');
        if(!isset($data)){
            echo json_encode(array('msg' => 'error'));
            exit;
        }else{
            $this->load->library('excel');
            $this->load->model(array('clients', 'upload_list_items'));
            $array = array();
            foreach($data as $v){
                $items = new Upload_list_items();
                $items->load($v);
                $array[][$this->lang->line('company_name')] = $items->company_name;
            }
            $this->excel->to_excel($array, $this->lang->line('export_name_list'));
        }
    }
}



?>