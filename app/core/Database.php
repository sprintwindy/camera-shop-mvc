<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'database_name';
    private $username = 'root';
    private $password = '';
    private $conn;

    // Kết nối cơ sở dữ liệu
    public function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }

    // Ngắt kết nối cơ sở dữ liệu
    public function disconnect() {
        $this->conn = null;
    }

    // Chuẩn bị và thực thi truy vấn với tham số
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Lấy một dòng kết quả
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    // Lấy tất cả các kết quả
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    // Thực hiện truy vấn thêm, sửa, xóa
    public function execute($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    // Lấy ID của bản ghi vừa thêm
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}