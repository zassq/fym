<?php

class Upload_list_items extends MY_Model{
    const DB_TABLE = 'upload_list_items';
    const DB_TABLE_PK = 'item_id';

    public $item_id;
    public $list_id;
    public $company_name;
    public $existed_client_id;
}

?>