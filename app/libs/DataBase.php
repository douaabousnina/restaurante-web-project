<?php

class DataBase
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "restaurante";

    public function dataBaseConnetion()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
            return $pdo;
        } catch (PDOException $e) {
            die('Database connection error: '. $e->getMessage());
        }
    }
}
