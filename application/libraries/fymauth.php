<?php
 if ( ! defined("BASEPATH")) exit('No direct script access allowed.');

class Fymauth{

    private $CI;
    protected $PasswordHash;
    protected $fymauth_model;

    public function __construct(){
        if(!file_exists($path = APPPATH.'/libraries/phpass/PasswordHash.php')){
            show_error('The phpass class file was not found.');
        }
        $this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->model('fymauth_model');
        $this->fymauth_model = new Fymauth_model();
        #$this->CI->config->load('fym');

        include($path);
        $this->PasswordHash = new PasswordHash(8, $this->CI->config->item('fymauth_portable_hashes'));
    }

    public function logged_in(){
        $this->CI->load->helper('cookie');
        if(!$this->CI->session->userdata('logged_in') && $rmbme_cookie = get_cookie($this->CI->config->item('fymauth_rmb_me_cookie_name'))){
            $this->CI->load->library('encrypt');
            $this->CI->load->model('Login_sessions');
            $ls = new Login_sessions();
            $rmbme_info = unserialize($this->CI->encrypt->decode($rmbme_cookie));
            $ls->load($rmbme_info['id']);
            $ls_info = $ls;
            if($ls_info){
                if($ls_info->uname == $this->CI->encrypt->decode($rmbme_info['uname']) && $ls_info->token = $rmbme_info['token'] && $rmbme_info['date'] + 7*24*60*60 > time())
                    $this->login($ls_info->uname, NULL, TRUE);
                else
                    $ls->delete();
            }
        }
        return $this->CI->session->userdata('logged_in');
    }

    public function login($username, $password, $bypassPWCheck = FALSE, $doRMBme = FALSE){
        $user = $this->fymauth_model->get_user_by_username($username);

        if($user){
            if($this->PasswordHash->CheckPassword($password, $user->password) || $bypassPWCheck){
                unset($user->password);
                $this->CI->session->set_userdata(array(
                   'logged_in' => true,
                    'user' => $user
                ));
                if($doRMBme){
                    $this->CI->load->library(array('encrypt', 'user_agent'));
                    $this->CI->load->model('Login_sessions');
                    $this->CI->load->helper('security');
                    $ls = new Login_sessions();
                    $ls->token = do_hash(time(), 'md5');
                    $ls->uname = $username;
                    $ls->date = time();
                    $ls->key = do_hash($this->CI->agent->agent_string(), 'md5');
                    $ls->save();
                    $rmbme_info = $this->CI->encrypt->encode(serialize(array(
                       'id' => $ls->id,
                       'uname' => $this->CI->encrypt->encode($ls->uname),
                       'token' => $ls->token,
                       'date' => $ls->date,
                       'key' => $ls->key
                    )));
                    set_cookie(array(
                        'name' => $this->CI->config->item('fymauth_rmb_me_cookie_name'),
                        'value' => $rmbme_info,
                        'expire' => 604800
                    ));
                }
                $this->fymauth_model->update_user($user->id, array('last_login' => date('Y-m-d H:i:s')));
                return true;
            }
        }
        return false;
    }

    public function logout($redirect = false){
        $user = $this->CI->session->userdata('user');
        $this->CI->session->sess_destroy();
        delete_cookie($this->CI->config->item('fymauth_rmb_me_cookie_name'));
        $this->CI->load->model('Login_sessions');
        $ls = new Login_sessions();
        $ls->delete_by_uname($user->username);
        if($redirect){
            $this->CI->load->helper('url');
            redirect($redirect,'refresh');
        }
    }

    public function createUser($userdata){
        $user = $this->fymauth_model->get_user_by_username($userdata['username']);
        if($user) return false;

        $userdata['password'] = $this->PasswordHash->HashPassword($userdata['password']);
        $this->fymauth_model->create_user($userdata);
        return true;
    }

    public function updateUser($userdata){
        $this->fymauth_model->update_user($userdata['id'], $userdata);
        return true;
    }

    public function reset_password($user_id, $new_password){
        $new_password = $this->PasswordHash->HashPassword($new_password);
        $this->fymauth_model->update_user($user_id, array('password' => $new_password));
    }
}



?>