<?php

require_once 'app/Models/Database.php';

class Product {
    private $conn;

    public function __construct() {
        // Sử dụng phương thức getInstance để lấy kết nối cơ sở dữ liệu
        $this->conn = Database::getInstance();
    }

    public function getAllProducts() {
        $query = "SELECT products.*, categories.name as category_name FROM products 
                  LEFT JOIN categories ON products.category_id = categories.id";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedProducts($categoryId, $excludeProductId) {
        $query = "SELECT * FROM products WHERE category_id = :category_id AND id != :excludeProductId LIMIT 4";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':excludeProductId', $excludeProductId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment($productId, $userId, $commentContent) {
        $query = "INSERT INTO comments (product_id, user_id, content, created_at) VALUES (:product_id, :user_id, :content, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId); // Sửa lại thành $productId
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $commentContent);
        $stmt->execute();
    }

    public function getCommentsByProductId($productId) {
        $query = "SELECT comments.content, comments.created_at, users.username FROM comments 
                  INNER JOIN users ON comments.user_id = users.id 
                  WHERE comments.product_id = :product_id 
                  ORDER BY comments.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $price, $category_id, $image, $description) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, price, category_id, image, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $category_id, $image, $description]);
    }

    public function updateProduct($id, $name, $price, $category_id, $image, $description) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, price = ?, category_id = ?, image = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $price, $category_id, $image, $description, $id]);
    }

    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getProductCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM products");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
    public function getCategoryStatistics() {
        $query = "
        SELECT c.name AS category_name, COUNT(p.id) AS product_count 
        FROM categories c 
        LEFT JOIN products p ON c.id = p.category_id 
        GROUP BY c.name";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchProductsByName($query) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE name LIKE ?");
        $stmt->execute(['%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductsByCategoryId($categoryId) {
        $query = "SELECT * FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCommentById($id) {
        $query = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteComment($id) {
        $query = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}