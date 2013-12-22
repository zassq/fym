<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ml_action extends CI_Controller {

    public $data;
    public $ml;
    public $staff_log;

    public function __construct(){
        parent::__construct();

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
        if(!$this->fymauth->logged_in()) redirect('users/login');

        //$this->load->model(array('progress', 'status', 'clients', 'marketinglog', 'staff', 'staff_log', 'hightech_level', 'certs', 'projects', 'project_client'));
        $this->load->model(array('marketinglog', 'staff_log', 'clients'));
        $this->ml = new Marketinglog();
        $this->staff_log = new Staff_log();

        $this->userinfo = $this->session->userdata('user');
        $this->data = array(
            'logged_in' => true,
            'userinfo' => $this->userinfo,
            'here' => 'clients',
            'error' => ''
        );

        $site_message = $this->msg->getMsg();
        if($site_message){
            $this->data['site_message'] = $site_message;
            unset($site_message);
        }
    }

    public function ml_edit($ml_id){
        if($this->input->post('ml_submit')){
            $this->ml->load($ml_id);
            $this->ml->date = $this->input->post('ml_date');
            $this->ml->detail = $this->input->post('ml_log');
            $this->ml->save();
            # save staff_log
            $this->staff_log->cid = $this->ml->cid;
            $this->staff_log->sid = $this->ml->sid;
            $this->staff_log->date = date('Y-m-d H:i:s', time());
            $this->staff_log->action = $this->lang->line('marketing_log_edit');
            $this->staff_log->detail = sprintf($this->lang->line('marketing_log_edit_log'), '<a href="'.site_url('client/'.$this->ml->cid).'">'.Clients::get_client_name_by_id($this->ml->cid).'</a>');
            $this->staff_log->save();
            $this->msg->setMsg('I', $this->lang->line('successful_edit_marketing_log'));
            redirect('client/'.$this->ml->cid);
        }
        $this->ml->load($ml_id);
        $this->data['ml_item'] = $this->ml;

        $this->load->helper('form');
        $this->data['load_extra'] = array('datatimepicker');
        $this->load->view('common/head', $this->data);
        $this->load->view('ml_edit', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function ml_delete($ml_id){
        $this->ml->load($ml_id);
        $cid = $this->ml->cid;
        $this->ml->delete();
        # save staff_log
        $this->staff_log->cid = $this->ml->cid;
        $this->staff_log->sid = $this->ml->sid;
        $this->staff_log->date = date('Y-m-d H:i:s', time());
        $this->staff_log->action = $this->lang->line('marketing_log_delete');
        $this->staff_log->detail = sprintf($this->lang->line('marketing_log_delete_log'), '<a href="'.site_url('client/'.$this->ml->cid).'">'.Clients::get_client_name_by_id($this->ml->cid).'</a>');
        $this->staff_log->save();
        $this->msg->setMsg('I', $this->lang->line('successful_delete_marketing_log'));
        redirect('client/'.$cid);
    }
}