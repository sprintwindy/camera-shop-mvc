<?php
class HomeController {
    public function index() {
        require_once 'app/Models/Product.php';
        $productModel = new Product();
        $products = $productModel->getAllProducts();
        require_once 'app/Views/home/index.php';
    }
}
