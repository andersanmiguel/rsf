<?php

class Model {

    protected $db;

    function __construct() {

        $database_string = Config::get('db');

        if(Config::get('db_type') == 'sqlite') {
            $this->db = new Db($database_string);
        } else {
            $user = Config::get('db_user');
            $pass = Config::get('db_pass');
            $this->db = new Db($database_string, $user, $pass);
        }
    }

}
