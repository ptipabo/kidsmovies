<?php

namespace Database;

use PDO;

class ServerConnection {

    private $host;
    private $username;
    private $password;
    private $dbname;
    private $pdo;

    public function __construct(string $host, string $username, string $password, string $dbname = null){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function getConnection():PDO{
        if($this->dbname !== null){
            return $this->pdo ?? $this->pdo = new PDO("mysql:dbname={$this->dbname};host={$this->host}",$this->username,$this->password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8'
            ));
        }
        else{
            return $this->pdo ?? $this->pdo = new PDO("mysql:host={$this->host}",$this->username,$this->password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8'
            ));
        }
    }

}