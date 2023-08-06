<?php

namespace Models;

require('config/config.php');

class Database
{

    protected $bdd;

    public function __construct()
    {
        try {
            $this->bdd = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\PDOException $e) {
            echo 'error at connection to DDB   ' . $e->getMessage();
        }
    }
}
