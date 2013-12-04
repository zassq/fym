<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    public $head_data;
    public $page_data;
    public $foot_data;

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
        $this->head_data = array(
            'logged_in' => true,
            'userinfo' => $this->userinfo,
            'here' => ''
        );
        $this->page_data = array(
            'userinfo' => $this->userinfo,
            'access' => $this->config->item('access'),
            'usertype' => $this->config->item('usertype')
        );

        $site_message = $this->msg->getMsg();
        if($site_message){
            $this->foot_data['site_message'] = $site_message;
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

        $this->page_data['users'] = $users->get();

        $this->head_data['here'] = 'users';
        $this->load->view('common/head', $this->head_data);
        $this->load->view('users', $this->page_data);
        $this->load->view('common/foot', $this->foot_data);
    }

    public function addUser(){
        if(!$this->fymauth->logged_in()) redirect('users/login');
        $this->load->helper('form');
        if($this->input->post('saveUser')){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">&gt;&gt; ', '</div>');
            $this->page_data['error'] = '';

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
                    $this->page_data['error'] = $this->lang->line('error_add_user');
                }
            }
        }

        # get rid of 'admin' users if not admin
        if($this->userinfo->usertype != 'A'){
            foreach($this->page_data['usertype'] as $k => $v){
                if($k == 'A') unset($this->page_data['usertype'][$k]);
            }
            foreach($this->page_data['access'] as $k => $v){
                if($k == 'fullaccess') unset($this->page_data['access'][$k]);
            }
        }

        if(!isset($this->page_data['error'])) $this->page_data['error'] ='';
        $this->head_data['here'] = 'users';

        $this->load->view('common/head', $this->head_data);
        $this->load->view('addUser', $this->page_data);
        $this->load->view('common/foot');
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
        $this->page_data['staff'] = $staff;

        if('S' == $this->userinfo->usertype && 'A' == $staff->usertype){
            $this->msg->setMsg('W', $this->lang->line('no_permission'));
            redirect('users');
        }

        if($this->input->post('saveUser')){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">&gt;&gt; ', '</div>');
            $this->page_data['error'] = '';

            #$this->form_validation->set_rules('username', 'lang:username', 'required|alpha|is_unique['. $this->config->item('fymauth_users_table') .'.username]');
            $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
            $this->form_validation->set_rules('name', 'lang:name', 'required');

            if($this->form_validation->run()){
                $userdata = array(
                    'id' => $this->page_data['staff']->id,
                    'name' => set_value('name'),
                    'email' => set_value('email'),
                    'usertype' => $this->input->post('usertype'),
                    'access' => $this->input->post('access'),
                    'note' => $this->input->post('note')
                );
                if($this->fymauth->updateUser($userdata)){
                    redirect('users');
                }else{
                    $this->page_data['error'] = 'error';
                }
            }
        }

        if(!isset($this->page_data['error'])) $this->page_data['error'] ='';
        $this->head_data['here'] = 'users';

        $this->load->helper('form');
        $this->load->view('common/head', $this->head_data);
        $this->load->view('updateUser', $this->page_data);
        $this->load->view('common/foot');

    }

    public function login(){
        if($this->fymauth->logged_in()) redirect('users/dash');
        if($this->input->post('login')){

            $this->load->library('form_validation');
            $this->load->helper('form');
            $this->page_data['error'] = '';

            $this->form_validation->set_rules('username', 'lang:username', 'required');
            $this->form_validation->set_rules('password', 'lang:password', 'required');

            if($this->form_validation->run()){
                if($this->fymauth->login(set_value('username'), set_value('password'), FALSE, ($this->input->post('rmbme') ? TRUE : FALSE))){
                    // Redirect to your logged in landing page here
                    redirect('users/dash');
                } else {
                    $this->page_data['error'] = $this->lang->line('wrong_password');
                }
            }
        }

        if(!isset($this->page_data['error'])) $this->page_data['error'] ='';
        $this->load->helper('form');
        $this->load->view('common/head_middle');
        $this->load->view('login', $this->page_data);
        $this->load->view('common/foot');

    }

    public function logout(){
        if(!$this->fymauth->logged_in()) redirect('users/login');

        // Redirect to your logged out landing page here
        $this->fymauth->logout('users/login');
    }

    public function dash(){
        if(!$this->fymauth->logged_in()) redirect('users/login');

        $this->head_data['here'] = 'dash';

        $this->load->view('common/head', $this->head_data);
        $this->load->view('dash', $this->page_data);
        $this->load->view('common/foot', $this->foot_data);
    }
}