<?php

class Certs extends MY_Model{
	const DB_TABLE = 'certs';
	const DB_TABLE_PK = 'cert_id';

	public $cert_id;

	public $cert_type;

	public $cert_code;

	public $cert_date;

	public $cert_expiry;

    public static function get_certs_by_id($cert_id){
        $cert = new Certs();
        $cert->load($cert_id);
        return array($cert->cert_type => $cert);
    }
}

?>