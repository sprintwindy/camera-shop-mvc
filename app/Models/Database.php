<?php

class Database {
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $db_name = 'duannhom3';
    private $username = 'root';
    private $password = '';

    private function __construct() {
        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance->connection;
    }
}