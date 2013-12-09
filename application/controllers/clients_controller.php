<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients_controller extends CI_Controller {

    public $data;

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
        $this->load->model(array('progress', 'status', 'clients', 'marketinglog', 'staff', 'staff_log', 'hightech_level', 'certs'));
        $progress = new Progress();
        $status = new Status();

        if(!$this->fymauth->logged_in()) redirect('users/login');

        $this->userinfo = $this->session->userdata('user');
        $this->data = array(
            'logged_in' => true,
            'userinfo' => $this->userinfo,
            'here' => '',
            'access' => $this->config->item('access'),
            'usertype' => $this->config->item('usertype'),
            'progress' => $progress->get_value_pair('progress'),
            'status' => $status->get_value_pair('status'),
            'error' => ''
        );

        $site_message = $this->msg->getMsg();
        if($site_message){
            $this->data['site_message'] = $site_message;
            unset($site_message);
        }
    }

    public function index(){
        redirect('users/dash');
    }

    public function add(){
        # post first
        if($this->input->post('save_client')){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">&gt;&gt; ', '</div>');

            $this->form_validation->set_rules('name', 'lang:company_name', 'required');

            if($this->form_validation->run()){
                $new_client = new Clients();
                $new_client->populate($this->input->post());
                unset($new_client->high_tech_cert_code);
                unset($new_client->soft_comp_cert_code);
                unset($new_client->save_client);
                unset($new_client->ml_log);
                unset($new_client->ml_staff_id);
                unset($new_client->ml_staff_name);
                unset($new_client->ml_date);
                unset($new_client->marketing_log);
                # high tect cert
                if($this->input->post('is_hightech') == 'Y' && $this->input->post('high_tech_cert_code') != ''){
                    $hightechcert = new Certs();
                    $hightechcert->cert_type = 'H';
                    $hightechcert->cert_code = $this->input->post('high_tech_cert_code');
                    $hightechcert->save();
                    $new_client->hightech_cert_id = $hightechcert->cert_id;
                }
                # soft comp cert
                if($this->input->post('is_soft_comp') == 'Y' && $this->input->post('soft_comp_cert_code') != ''){
                    $softcompcert = new Certs();
                    $softcompcert->cert_type = 'S';
                    $softcompcert->cert_code = $this->input->post('soft_comp_cert_code');
                    $softcompcert->save();
                    $new_client->soft_comp_cert_id = $softcompcert->cert_id;
                }
                $new_client->created = date('Y-m-d H:i:s', time());
                $new_client->save();
                $ml_date = $this->input->post('ml_date');
                if(count($ml_date)> 0){
                    $ml_log = $this->input->post('ml_log');
                    $ml_staff_id = $this->input->post('ml_staff_id');
                    $ml_staff_name = $this->input->post('ml_staff_name');
                    foreach($ml_date as $k => $v){
                        if(empty($v) || $v == '' || empty($ml_staff_id[$k])) continue;
                        $ml = new Marketinglog();
                        $ml->cid = $new_client->id;
                        $ml->date = $v;
                        $ml->sid = $ml_staff_id[$k];
                        $ml->staff = $ml_staff_name[$k];
                        $ml->detail = $ml_log[$k];
                        $ml->save();
                    }
                }
                $slog = new Staff_log();
                $slog->date = date('Y-m-d H:i:s', time());
                $slog->action = $this->lang->line('add_client');
                $slog->sid = $this->userinfo->id;
                $slog->cid = $new_client->id;
                $slog->detail = sprintf($this->lang->line('add_new_client_log'), '<a href="'.site_url('client/'.$new_client->id).'">'.Clients::get_client_name_by_id($new_client->id).'</a>');
                $slog->save();
                $this->msg->setMsg('I', sprintf($this->lang->line('successful_add_new_client'), $new_client->name));
                redirect('clients/listing');
            }
        }

        $this->load->helper('form');
        $this->data['marketing_log'] = Marketinglog::getAllLog();
        $this->data['staff'] = Staff::get_staff();
        $this->data['level1'] = Hightech_level::get_level1();

        $this->data['here'] = 'clients';
        $this->data['load_extra'] = array('datatimepicker');
        $this->load->view('common/head', $this->data);
        $this->load->view('clients_add', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function listing(){
        $ml = new Marketinglog();

        $this->data['clients'] = Clients::get_all_clients($ml);
        $this->data['level1'] = Hightech_level::get_level1();
        $this->data['certs'] = $this->certs->get();

        $this->data['here'] = 'clients';
        $this->data['load_extra'] = array('dataTables');
        $this->load->view('common/head', $this->data);
        $this->load->view('clients_list', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function view($cid){
        $client = new Clients();
        $ml = new Marketinglog();
        $client->load($cid);
        $ml_items = $ml->load_by_cid($cid);
        $this->data['certs'] = array();
        if(isset($client->hightech_cert_id)) $this->data['certs'] = array_merge($this->data['certs'], Certs::get_certs_by_id($client->hightech_cert_id));
        if(isset($client->soft_comp_cert_id)) $this->data['certs'] = array_merge($this->data['certs'], Certs::get_certs_by_id($client->soft_comp_cert_id));

        $this->data['client'] = $client;
        $this->data['ml_items'] = $ml_items;
        $this->data['level1'] = Hightech_level::get_level1();
        $this->data['staff'] = Staff::get_staff($this->userinfo->usertype == 'A' ? true: false);

        $this->data['here'] = 'clients';
        $this->data['load_extra'] = array('dataTables','datatimepicker');
        $this->load->helper('form');
        $this->load->view('common/head', $this->data);
        $this->load->view('clients_view', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function client_filter(){
        $this->data['load_extra'] = array('clients_filter');
        $this->load->view('common/head', $this->data);
        $this->load->view('clients_filter', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    public function client_filter_upload(){
        $upload_path_url = base_url() . 'assets'.DC.'uploads'.DC;
        $clist = 'clist';

        $upload_config['upload_path'] = FCPATH . 'assets'.DC.'uploads'.DC;
        $upload_config['allowed_types'] = 'csv';
        $upload_config['max_size'] = '50000';
        $this->load->library('upload', $upload_config);

        if($this->upload->do_upload($clist)){
            $data = $this->upload->data();
            $this->load->library('fymcsv');
            $csv = new Fymcsv();
            $csv_content = $csv->parseCSV($data['full_path']);

            if($csv_content['cols'] > 1){
                unlink($data['full_path']);
                echo json_encode(array('error' => 'error_cols'));
                exit();
            }

            $return_json = array();
            $this->load->model(array('upload_list', 'upload_list_items'));
            $ul = new Upload_list();
            $ul->file_name = $data['full_path'];
            $ul->upload_by = $this->userinfo->name;
            $ul->upload_date = date('Y-m-d H:i:s', time());
            $ul->save();
            $ml = new Marketinglog();
            $all_ml = $ml->get();

            foreach($csv_content['data'] as $new_client){
                $tmp_client = new Clients();
                $new_client_name = $new_client[0];
                if (preg_match("/[\x7f-\xff]/", $new_client_name))
                    $new_client_name = iconv('gb2312', 'utf-8', $new_client_name);
                $find = $tmp_client->findClientByName($new_client_name);
                $ul_items = new Upload_list_items();
                $ul_items->company_name = $new_client_name;
                $ul_items->list_id = $ul->list_id;
                $ul_items->existed_client_id = $find ? $tmp_client->id : 0;
                $ul_items->save();

                $tmp_return = new stdClass();
                $tmp_return->item_id = $ul_items->item_id;
                $tmp_return->company_name = $ul_items->company_name;
                $tmp_return->list_id = $ul_items->list_id;
                $tmp_return->existed_client = $find ? true : false;
                if($find){
                    foreach($all_ml as $c_ml){
                        if($c_ml->cid == $ul_items->existed_client_id) $tmp_return->marketing_log[] = $c_ml;
                    }
                    $tmp_return->client_id = $ul_items->existed_client_id;
                    $tmp_return->is_hightech = $tmp_client->is_hightech;
                    $tmp_return->hightech_cert_code = !empty($tmp_client->hightech_cert_id) ? Certs::get_certs_by_id($tmp_client->hightech_cert_id) : NULL;
                    $tmp_return->is_soft_comp = $tmp_client->is_soft_comp;
                    $tmp_return->soft_comp_cert_code = !empty($tmp_client->soft_comp_cert_id) ? Certs::get_certs_by_id($tmp_client->soft_comp_cert_id) : NULL;
                }
                $return_json[] = $tmp_return;
                unset($tmp_client);
                unset($ul_items);
                unset($tmp_return);
            }
            echo json_encode(array("files" => $return_json));
            exit();
        }else{
            echo $this->upload->display_errors();exit;
        }


    }

    public function client_add_ml(){
        if($this->input->post('save_ml')){
            $cid = $this->input->post('cid');
            $ml_date = $this->input->post('ml_date');
            if(count($ml_date)> 0){
                $ml_log = $this->input->post('ml_log');
                $ml_staff_id = $this->input->post('ml_staff_id');
                $ml_staff_name = $this->input->post('ml_staff_name');
                foreach($ml_date as $k => $v){
                    if(empty($v) || $v == '') continue;
                    $ml = new Marketinglog();
                    $ml->cid = $cid;
                    $ml->date = $v;
                    $ml->sid = $ml_staff_id[$k];
                    $ml->staff = $ml_staff_name[$k];
                    $ml->detail = $ml_log[$k];
                    $ml->save();
                }
                $slog = new Staff_log();
                $slog->date = date('Y-m-d H:i:s', time());
                $slog->action = $this->lang->line('add_ml');
                $slog->sid = $this->userinfo->id;
                $slog->cid = $cid;
                $slog->detail = sprintf($this->lang->line('add_new_ml_log'), '<a href="'.site_url('client/'.$cid).'">'.Clients::get_client_name_by_id($cid).'</a>', count($ml_date));
                $slog->save();
            }
            redirect('client/'.$cid);
        }else{
            redirect(site_url('users/dash'));
        }
    }

    public function client_update($cid){
        $old_client = new Clients();
        $old_client->load($cid);
        $this->data['client'] = $old_client;
        $this->data['certs'] = array();
        if(isset($old_client->hightech_cert_id)) $this->data['certs'] = array_merge($this->data['certs'], Certs::get_certs_by_id($old_client->hightech_cert_id));
        if(isset($old_client->soft_comp_cert_id)) $this->data['certs'] = array_merge($this->data['certs'], Certs::get_certs_by_id($old_client->soft_comp_cert_id));

        if($this->input->post('save_client')){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">&gt;&gt; ', '</div>');

            $this->form_validation->set_rules('name', 'lang:company_name', 'required');
            $new_client = new Clients();
            $new_client->id = $cid;

            if($this->form_validation->run()){
                $new_client->populate($this->input->post());
                unset($new_client->high_tech_cert_code);
                unset($new_client->soft_comp_cert_code);
                unset($new_client->save_client);
                unset($new_client->ml_log);
                unset($new_client->ml_staff_id);
                unset($new_client->ml_staff_name);
                unset($new_client->ml_date);
                unset($new_client->marketing_log);
                # high tect cert
                if($this->input->post('is_hightech') == 'Y' && $this->input->post('high_tech_cert_code') != ''){
                    $hightechcert = new Certs();
                    $hightechcert->cert_id = $old_client->hightech_cert_id;
                    $hightechcert->cert_type = 'H';
                    $hightechcert->cert_code = $this->input->post('high_tech_cert_code');
                    $hightechcert->save();
                    $new_client->hightech_cert_id = $hightechcert->cert_id;
                }elseif(!empty($old_client->hightech_cert_id)){
                    $hightechcert = new Certs();
                    $hightechcert->cert_id = $old_client->hightech_cert_id;
                    $hightechcert->delete();
                }
                # soft comp cert
                if($this->input->post('is_soft_comp') == 'Y' && $this->input->post('soft_comp_cert_code') != ''){
                    $softcompcert = new Certs();
                    $softcompcert->cert_id = $old_client->soft_comp_cert_id;
                    $softcompcert->cert_type = 'S';
                    $softcompcert->cert_code = $this->input->post('soft_comp_cert_code');
                    $softcompcert->save();
                    $new_client->soft_comp_cert_id = $softcompcert->cert_id;
                }elseif(!empty($old_client->soft_comp_cert_id)){
                    $softcompcert = new Certs();
                    $softcompcert->cert_id = $old_client->soft_comp_cert_id;
                    $softcompcert->delete();
                }
                $new_client->save();

                $slog = new Staff_log();
                $slog->date = date('Y-m-d H:i:s', time());
                $slog->action = $this->lang->line('update_client');
                $slog->sid = $this->userinfo->id;
                $slog->cid = $new_client->id;
                $slog->detail = sprintf($this->lang->line('update_client_log'), '<a href="'.site_url('client/'.$new_client->id).'">'.Clients::get_client_name_by_id($new_client->id).'</a>');
                $slog->save();
                $this->msg->setMsg('I', $this->lang->line('successful_update_client'));
                redirect('client/'.$cid);
            }
        }

        $this->load->helper('form');
        $this->data['marketing_log'] = Marketinglog::getAllLog();
        $this->data['staff'] = Staff::get_staff();
        $this->data['level1'] = Hightech_level::get_level1();

        $this->data['here'] = 'clients';
        $this->data['load_extra'] = array('datatimepicker');
        $this->load->view('common/head', $this->data);
        $this->load->view('client_update', $this->data);
        $this->load->view('common/foot', $this->data);
    }

    function add_to_my_client(){
        echo 'success';
    }
}