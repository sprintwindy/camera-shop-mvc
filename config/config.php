<?php

// ** Cấu hình cơ sở dữ liệu **
define('DB_HOST', 'PRO1014');           // Địa chỉ máy chủ cơ sở dữ liệu
define('DB_NAME', 'camera_store');        // Tên cơ sở dữ liệu
define('DB_USER', 'root');                // Tên người dùng cơ sở dữ liệu
define('DB_PASS', '');                    // Mật khẩu cơ sở dữ liệu
define('DB_CHARSET', 'utf8');             // Bộ mã ký tự

// ** Đường dẫn cơ bản **
define('BASE_URL', 'http://localhost/camera_store'); // Đường dẫn URL cơ bản của dự án

// ** Thông tin chung của cửa hàng **
define('STORE_NAME', 'Camera Store');              // Tên cửa hàng
define('STORE_EMAIL', 'info@camerastore.com');     // Email liên hệ
define('STORE_PHONE', '0123-456-789');             // Số điện thoại liên hệ
define('STORE_ADDRESS', '123 Camera Street, Hanoi, Vietnam'); // Địa chỉ cửa hàng

// ** Cấu hình giỏ hàng **
define('TAX_RATE', 0.1);                  // Thuế áp dụng cho sản phẩm (10%)
define('CURRENCY', 'VND');                // Đơn vị tiền tệ (VD: VND, USD, EUR)
define('SHIPPING_COST', 30000);           // Phí vận chuyển mặc định

// ** Thiết lập bảo mật **
define('SECRET_KEY', 'your-secret-key');  // Khóa bí mật cho các chức năng bảo mật (VD: token, mã hóa)

// ** Các cài đặt khác nếu cần **
define('PRODUCTS_PER_PAGE', 12);          // Số sản phẩm hiển thị trên mỗi trang
define('IMAGE_PATH', BASE_URL . '/images'); // Đường dẫn đến thư mục hình ảnh sản phẩm

?>