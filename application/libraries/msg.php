<?php
if ( ! defined("BASEPATH")) exit('No direct script access allowed.');

class Msg{

    private $CI;

    public function __construct(){
        $this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->library('session');
    }

    public function setMsg($type, $msg, $msg_name = 'site_message'){
        return $this->CI->session->set_flashdata($msg_name, array('type' => $type, 'msg' => $msg));
    }

    public function getMsg($msg_name = 'site_message'){
        return $this->CI->session->flashdata($msg_name);
    }
}

?>