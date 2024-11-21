<?php

require_once 'app/Models/Product.php';
require_once 'app/Models/Category.php';

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index() {
        // Lấy danh sách sản phẩm từ cơ sở dữ liệu
        $products = $this->productModel->getAllProducts();

        // Gửi dữ liệu tới view để hiển thị
        require_once 'app/Views/product/index.php';
    }

    public function detail($id) {
        $product = $this->productModel->getProductById($id);
        $categoryId = $product['category_id'];
        $relatedProducts = $this->productModel->getRelatedProducts($categoryId, $id);
        $comments = $this->productModel->getCommentsByProductId($id); // Lấy bình luận

        require_once 'app/Views/product/detail.php';
    }

    public function addComment($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentContent = $_POST['comment'] ?? '';

            // Kiểm tra xem người dùng đã đăng nhập chưa
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Gọi model để thêm bình luận vào cơ sở dữ liệu
                $this->productModel->addComment($id, $userId, $commentContent);

                // Chuyển hướng lại về trang chi tiết sản phẩm sau khi thêm bình luận
                header("Location: index.php?controller=product&action=detail&id=$id");
                exit();
            } else {
                // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
                header("Location: index.php?controller=user&action=login");
                exit();
            }
        }
    }
    public function search() {
        $query = isset($_GET['query']) ? $_GET['query'] : '';
        $productModel = new Product();
        $products = $productModel->searchProductsByName($query);

        // Gửi dữ liệu tới view để hiển thị kết quả tìm kiếm
        require_once 'app/Views/product/search_results.php';
    }
    public function category($id) {
        $products = $this->productModel->getProductsByCategoryId($id);
        $category = $this->categoryModel->getCategoryById($id);

        require_once 'app/Views/product/category.php';
    }
    public function delete_comment($commentId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        $productId = $_GET['product_id'];

        // Lấy thông tin bình luận để kiểm tra quyền xóa
        $comment = $this->productModel->getCommentById($commentId);

        if ($comment && $comment['user_id'] == $_SESSION['user_id']) {
            // Xóa bình luận
            $this->productModel->deleteComment($commentId);
        }

        // Chuyển hướng lại trang chi tiết sản phẩm
        header("Location: index.php?controller=product&action=detail&id=$productId");
        exit();
    }
}