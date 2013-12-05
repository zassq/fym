<?php

class Staff_log extends MY_Model{
    const DB_TABLE = 'staff_log';
    const DB_TABLE_PK = 'id';

    public $id;
    public $date;
    public $cid;
    public $detail;
    public $sid;
    public $action;
}

?>