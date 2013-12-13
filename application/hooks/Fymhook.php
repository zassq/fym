<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FymHook{
    private $CI;
    function __construct()
    {
        $this->CI =& get_instance();
    }

    function ConfigHook(){
        /*echo '<pre>';var_dump($this->CI->config);die();
        foreach($this->CI->config->config as $config_key => $config_item){
            if(is_array($config_item)){
                foreach($config_item as $k => $c){
                    $c_with_lang = $this->CI->lang->line($c);
                    if($c_with_lang) $this->CI->config->config[$config_key][$k] = $c_with_lang;
                }
            }else{
                $c_with_lang = $this->CI->lang->line($config_item);
                if($c_with_lang) $this->CI->config->config[$config_key] = $c_with_lang;
            }
        }*/
    }
}