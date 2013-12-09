<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    public $data;

    public function __construct(){
        parent::__construct();

        if (defined('ENVIRONMENT') && 'development' == ENVIRONMENT && false)
        {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => TRUE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }
        #$this->load->helper('url');
        $this->load->library(array('fymauth', 'msg'));

        #if(!$this->fymauth->logged_in()) redirect('users/login');
        $this->userinfo = $this->session->userdata('user');
        $this->data = array(
            'logged_in' => true,
            'userinfo' => $this->userinfo,
            'access' => $this->config->item('access'),
            'usertype' => $this->config->item('usertype')
        );

        $site_message = $this->msg->getMsg();
        if($site_message){
            $this->data['site_message'] = $site_message;
            unset($site_message);
        }
    }

    public function index(){
        if(!$this->fymauth->logged_in()) redirect('users/login');
        if('A' != $this->userinfo->usertype && 'manager' != $this->userinfo->access){
            $this->msg->setMsg('W', $this->lang->line('no_permission'));
            redirect('users/dash');
        }

        $this->load->model('staff');
        $users = new Staff();

        $this->data['users'] = $users->get();

        $this->data['here'] = 'users';
        $this->load->view('common/head', $this->data);
        $this->load->view('users', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function addUser(){
        if(!$this->fymauth->logged_in()) redirect('users/login');
        $this->load->helper('form');
        if($this->input->post('saveUser')){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">&gt;&gt; ', '</div>');
            $this->data['error'] = '';

            $this->form_validation->set_rules('username', 'lang:username', 'required|alpha|is_unique['. $this->config->item('fymauth_users_table') .'.username]');
            $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length['. $this->config->item('fymauth_password_min_length') .']');
            $this->form_validation->set_rules('password2', 'lang:confirm_password', 'required|matches[password]');

            if($this->form_validation->run()){
                $userdata = array(
                    'username' => set_value('username'),
                    'password' => set_value('password'),
                    'name' => set_value('name'),
                    'email' => set_value('email'),
                    'usertype' => $this->input->post('usertype'),
                    'access' => $this->input->post('access'),
                    'note' => $this->input->post('note')
                );
                if($this->fymauth->createUser($userdata)){
                    #$this->fymauth->login(set_value('username'), set_value('password'));
                    redirect('users');
                }else{
                    $this->data['error'] = $this->lang->line('error_add_user');
                }
            }
        }

        # get rid of 'admin' users if not admin
        if($this->userinfo->usertype != 'A'){
            foreach($this->data['usertype'] as $k => $v){
                if($k == 'A') unset($this->data['usertype'][$k]);
            }
            foreach($this->data['access'] as $k => $v){
                if($k == 'fullaccess') unset($this->data['access'][$k]);
            }
        }

        if(!isset($this->data['error'])) $this->data['error'] ='';
        $this->data['here'] = 'users';

        $this->load->view('common/head', $this->data);
        $this->load->view('addUser', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function view_profile(){
        if(!$this->fymauth->logged_in()) redirect('users/login');

        $this->data['error'] = '';
        if($this->input->post('saveUser')){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">&gt;&gt; ', '</div>');
            $this->data['error'] = '';

            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length['. $this->config->item('fymauth_password_min_length') .']');
            $this->form_validation->set_rules('password2', 'lang:confirm_password', 'required|matches[password]');

            if($this->form_validation->run()){
                $new_password = set_value('password');
                $this->fymauth->reset_password($this->userinfo->id, $new_password);
                $this->msg->setMsg('I', $this->lang->line('success_update_password'));
                redirect('users/dash');
            }
        }

        $this->data['here'] = 'users';
        $this->load->helper('form');
        $this->load->view('common/head', $this->data);
        $this->load->view('user_view_profile', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function user_delete($uid){
        if(!$this->fymauth->logged_in()) redirect('users/login');
        if('fullaccess' != $this->userinfo->access && 'manager' != $this->userinfo->access){
            $this->msg->setMsg('W', $this->lang->line('no_permission'));
            redirect('users/dash');
        }
        $this->load->model('staff');
        $staff = new Staff();
        $staff->load($uid);
        $name = $staff->name;
        $staff->delete();
        $this->msg->setMsg('I', sprintf($this->lang->line('success_delete_user'), $name));
        redirect('users');
    }

    public function user_update($uid){
        if(!$this->fymauth->logged_in()) redirect('users/login');
        if('fullaccess' != $this->userinfo->access && 'manager' != $this->userinfo->access){
            $this->msg->setMsg('W', $this->lang->line('no_permission'));
            redirect('users/dash');
        }

        $this->load->model('staff');
        $staff = new Staff();
        $staff->load($uid);
        unset($staff->password);
        $this->data['staff'] = $staff;

        if('S' == $this->userinfo->usertype && 'A' == $staff->usertype){
            $this->msg->setMsg('W', $this->lang->line('no_permission'));
            redirect('users');
        }

        if($this->input->post('saveUser')){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">&gt;&gt; ', '</div>');
            $this->data['error'] = '';

            #$this->form_validation->set_rules('username', 'lang:username', 'required|alpha|is_unique['. $this->config->item('fymauth_users_table') .'.username]');
            $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
            $this->form_validation->set_rules('name', 'lang:name', 'required');

            if($this->form_validation->run()){
                $userdata = array(
                    'id' => $this->data['staff']->id,
                    'name' => set_value('name'),
                    'email' => set_value('email'),
                    'usertype' => $this->input->post('usertype'),
                    'access' => $this->input->post('access'),
                    'note' => $this->input->post('note')
                );
                if($this->fymauth->updateUser($userdata)){
                    redirect('users');
                }else{
                    $this->data['error'] = 'error';
                }
            }
        }

        if(!isset($this->data['error'])) $this->data['error'] ='';
        $this->data['here'] = 'users';

        $this->load->helper('form');
        $this->load->view('common/head', $this->data);
        $this->load->view('updateUser', $this->data);
        $this->load->view('common/foot', $this->data);

    }

    public function login(){
        if($this->fymauth->logged_in()) redirect('users/dash');
        if($this->input->post('login')){

            $this->load->library('form_validation');
            $this->load->helper('form');
            $this->data['error'] = '';

            $this->form_validation->set_rules('username', 'lang:username', 'required');
            $this->form_validation->set_rules('password', 'lang:password', 'required');

            if($this->form_validation->run()){
                if($this->fymauth->login(set_value('username'), set_value('password'), FALSE, ($this->input->post('rmbme') ? TRUE : FALSE))){
                    // Redirect to your logged in landing page here
                    redirect('users/dash');
                } else {
                    $this->data['error'] = $this->lang->line('wrong_password');
                }
            }
        }

        if(!isset($this->data['error'])) $this->data['error'] ='';
        $this->load->helper('form');
        $this->load->view('common/head_middle');
        $this->load->view('login', $this->data);
        $this->load->view('common/foot', $this->data);

    }

    public function logout(){
        if(!$this->fymauth->logged_in()) redirect('users/login');

        // Redirect to your logged out landing page here
        $this->fymauth->logout('users/login');
    }

    public function dash(){
        if(!$this->fymauth->logged_in()) redirect('users/login');

        $this->data['here'] = 'dash';

        $this->data['load_extra'] = array('dash');
        $this->load->view('common/head', $this->data);
        $this->load->view('dash', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function user_get_client(){
        if(!$this->fymauth->logged_in()){
            echo json_encode(array('type' => 'error', 'msg' => 'need_login'));
        }else{
            $this->load->model(array( 'clients', 'progress', 'status'));
            $all_progress = $this->progress->get_value_pair('progress');
            $all_status = $this->status->get_value_pair('status');
            $clients = $this->clients->get_clients_by_staff_id($this->userinfo->id);
            foreach($clients as $k=>$v){
                $clients[$k]->progress_detail = $all_progress[$v->progress];
                $clients[$k]->status_detail = $all_status[$v->status];
            }
            echo json_encode(array('type' => 'success', 'msg' => count($clients), 'clients' => $clients));
        }
    }

    public function user_get_history(){
        if(!$this->fymauth->logged_in()){
            echo json_encode(array('type' => 'error', 'msg' => 'need_login'));
        }else{
            $this->load->model(array( 'staff_log'));
            $logs = $this->staff_log->get_by_conditions(array('sid' => $this->userinfo->id), 5, 0, 'date desc');
            foreach($logs as $k=>$v){
                $logs[$k]->date = date($this->lang->line('date_format'), strtotime($v->date));
            }
            echo json_encode(array('type' => 'success', 'msg' => count($logs), 'histories' => $logs));
        }
    }
}