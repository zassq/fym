<?php

class Sessions extends MY_Model{
	const DB_TABLE = 'sessions';
	const DB_TABLE_PK = 'session_id';

	public $session_id;

	public $ip_address;

	public $user_agent;

	public $last_activity;

	public $user_data;
}

?>