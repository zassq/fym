<?php

class Project_client extends MY_Model{
    const DB_TABLE = 'project_client';
    const DB_TABLE_PK = 'id';

    public $id;
    public $proj_id;
    public $client_id;
    public $proj_year;
}

?>