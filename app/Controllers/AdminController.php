<?php
require_once 'app/Models/Category.php';
require_once 'app/Models/Product.php';
require_once 'app/Models/Comment.php';
require_once 'app/Models/Order.php';
require_once 'app/Models/OrderDetail.php';
require_once 'app/Models/User.php';

class AdminController {
    public function __construct() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        // Kiểm tra xem người dùng có phải là admin không
        if ($_SESSION['role'] != 1) {
            echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location.href='index.php';</script>";
            exit();
        }
    }
    // Dashboard
    public function dashboard() {
        $productModel = new Product();
        $orderModel = new Order();

        $productCount = $productModel->getProductCount();
        $orderCount = $orderModel->getOrderCount();
        $totalRevenue = $orderModel->getTotalRevenue();

        require_once 'app/Views/admin/dashboard/index.php';
    }

    // Category Management
    public function category() {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();
        require_once 'app/Views/admin/category/index.php';
    }

    public function category_add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $categoryModel = new Category();
            $categoryModel->addCategory($name);
            header('Location: index.php?controller=admin&action=category');
        } else {
            require_once 'app/Views/admin/category/add.php';
        }
    }

    public function category_edit($id) {
        $categoryModel = new Category();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $categoryModel->updateCategory($id, $name);
            header('Location: index.php?controller=admin&action=category');
        } else {
            $category = $categoryModel->getCategoryById($id);
            require_once 'app/Views/admin/category/edit.php';
        }
    }

    public function category_delete($id) {
        $categoryModel = new Category();
        $categoryModel->deleteCategory($id);
        header('Location: index.php?controller=admin&action=category');
    }

    // Product Management
    public function product() {
        $productModel = new Product();
        $products = $productModel->getAllProducts();
        require_once 'app/Views/admin/product/index.php';
    }

    public function product_add() {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $description = $_POST['description'];

            // Handle image upload
            $image = $_FILES['image']['name'];
            $target_dir = "public/img/";
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

            $productModel = new Product();
            $productModel->addProduct($name, $price, $category_id, $image, $description);
            header('Location: index.php?controller=admin&action=product');
        } else {
            require_once 'app/Views/admin/product/add.php';
        }
    }

    public function product_edit($id) {
        $productModel = new Product();
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $description = $_POST['description'];

            // Kiểm tra xem người dùng có tải lên hình ảnh mới không
            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                $target_dir = "public/img/";
                $target_file = $target_dir . basename($image);
                move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
            } else {
                // Nếu không có hình ảnh mới, sử dụng hình ảnh hiện tại
                $image = $_POST['existing_image'];
            }

            $productModel->updateProduct($id, $name, $price, $category_id, $image, $description);
            header('Location: index.php?controller=admin&action=product');
        } else {
            $product = $productModel->getProductById($id);
            require_once 'app/Views/admin/product/edit.php';
        }
    }

    public function product_delete($id) {
        $productModel = new Product();
        $productModel->deleteProduct($id);
        header('Location: index.php?controller=admin&action=product');
    }

    // Comment Management
    public function comment() {
        $commentModel = new Comment();
        $comments = $commentModel->getAllComments();
        require_once 'app/Views/admin/comment/index.php';
    }

    public function comment_edit($id) {
        $commentModel = new Comment();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];
            $commentModel->updateComment($id, $content);
            header('Location: index.php?controller=admin&action=comment');
        } else {
            $comment = $commentModel->getCommentById($id);
            require_once 'app/Views/admin/comment/edit.php';
        }
    }

    public function comment_delete($id) {
        $commentModel = new Comment();
        $commentModel->deleteComment($id);
        header('Location: index.php?controller=admin&action=comment');
    }

    // Order Management
    public function order() {
        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();
        require_once 'app/Views/admin/order/index.php';
    }

    public function order_detail($id) {
        $orderModel = new Order();
        $orderDetailModel = new OrderDetail();

        $order = $orderModel->getOrderById($id);
        $orderDetails = $orderDetailModel->getOrderDetailsByOrderId($id);

        require_once 'app/Views/admin/order/detail.php';
    }

    public function order_delete($id) {
        $orderModel = new Order();
        $orderModel->deleteOrder($id);
        header('Location: index.php?controller=admin&action=order');
    }
    public function statistic() {
        $productModel = new Product();
        $orderModel = new Order();

        // Lấy số lượng sản phẩm, đơn hàng và doanh thu
        $productCount = $productModel->getProductCount();
        $orderCount = $orderModel->getOrderCount();
        $totalRevenue = $orderModel->getTotalRevenue();

        // Lấy thống kê danh mục sản phẩm
        $categoryStatistics = $productModel->getCategoryStatistics();

        require_once 'app/Views/admin/statistic/index.php';
    }
    public function user() {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        require_once 'app/Views/admin/user/index.php';
    }

    public function user_add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = isset($_POST['role']) ? 1 : 0;

            $userModel = new User();
            $userModel->createUser($username, $password, $email, $role);
            header('Location: index.php?controller=admin&action=user');
            exit();
        } else {
            require_once 'app/Views/admin/user/add.php';
        }
    }

    public function user_edit($id) {
        $userModel = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = isset($_POST['role']) ? 1 : 0;

            // Kiểm tra nếu người dùng không đổi mật khẩu
            if (empty($_POST['password'])) {
                $userModel->updateUserWithoutPassword($id, $username, $email, $role);
            } else {
                $password = $_POST['password'];
                $userModel->updateUser($id, $username, $password, $email, $role);
            }

            header('Location: index.php?controller=admin&action=user');
            exit();
        } else {
            $user = $userModel->getUserById($id);
            require_once 'app/Views/admin/user/edit.php';
        }
    }

    public function user_delete($id) {
        $userModel = new User();
        $userModel->deleteUser($id);
        header('Location: index.php?controller=admin&action=user');
        exit();
    }
}
