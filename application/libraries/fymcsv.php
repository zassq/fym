<?php if ( ! defined("BASEPATH")) exit('No direct script access allowed.');

class Fymcsv{

    #private $CI;

    public function __construct(){
        #$this->CI =& get_instance();
    }

    public static function parseCSV($filename='', $delimiter=',', $do_header = FALSE){
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE){
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE){
                if(!isset($data['cols'])) $data['cols'] = count($row);
                if($do_header){
                    if(!$header)
                        $header = $row;
                    else
                        $data['data'][] = array_combine($header, $row);
                }else{
                    $data['data'][] = $row;
                }
            }
            fclose($handle);
        }
        return $data;
    }
}


?>