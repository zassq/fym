<?php

class Category extends MY_Model{
    const DB_TABLE = 'category';
    const DB_TABLE_PK = 'cat_id';

    public $cat_id;

    public $cat_name;
}

?>