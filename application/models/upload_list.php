<?php

class Upload_list extends MY_Model{
    const DB_TABLE = 'upload_list';
    const DB_TABLE_PK = 'list_id';

    public $list_id;

    public $file_name;

    public $upload_date;

    public $upload_by;
}

?>