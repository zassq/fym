<?php

class Certs extends MY_Model{
	const DB_TABLE = 'certs';
	const DB_TABLE_PK = 'cert_id';

	public $cert_id;

	public $cert_type;

	public $cert_code;

	public $cert_date;

	public $cert_expiry;
}

?>