<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $product['description'] ?>">
    <meta name="author" content="Shop Name">
    <title><?= $product['name'] ?> - Chi tiết sản phẩm</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="public/css/styles.css" rel="stylesheet" />
</head>
<body>
<!-- Navigation-->
<?php include 'app/Views/layouts/header.php'; ?>

<!-- Product section-->
<section class="py-1">
    <div class="container px-1 px-lg-5 my-1">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="public/img/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" /></div>
            <div class="col-md-6">
                <div class="small mb-1">Danh mục: <?= $category['name'] ?? 'N/A' ?></div>
                <h1 class="display-5 fw-bolder"><?= $product['name'] ?></h1>
                <div class="fs-5 mb-5">
                    <?php if (!empty($product['original_price'])): ?>
                        <span class="text-decoration-line-through"><?= number_format($product['original_price'], 0, ',', '.') ?> VND</span>
                    <?php endif; ?>
                    <span><?= number_format($product['price'], 0, ',', '.') ?> VND</span>
                </div>
                <p class="lead"><?= $product['description'] ?></p>
                <div class="d-flex">
                    <div class="input-group me-3" style="max-width: 120px;">
                        <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                        <input type="number" class="form-control text-center" id="inputQuantity" value="1" min="1" aria-label="Số lượng">
                        <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                    </div>
                    <form action="index.php?controller=cart&action=add&id=<?= $product['id'] ?>" method="post">
                        <input type="hidden" name="quantity" id="quantityInput" value="1"> <!-- Thêm input ẩn để gửi số lượng -->
                        <button type="submit" class="btn btn-outline-dark flex-shrink-0">
                            <i class="bi-cart-fill me-1"></i>
                            Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Comment section -->
<section class="py-1">
    <div class="container">
        <h3 class="fw-bolder mb-4">Bình luận</h3>

        <!-- Comment form -->
        <form action="index.php?controller=product&action=addComment&id=<?= $product['id'] ?>" method="post">
            <div class="mb-3">
                <label for="commentContent" class="form-label">Nội dung bình luận</label>
                <textarea class="form-control" id="commentContent" name="comment" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
        </form>

        <!-- Comments list -->
        <div class="mt-5">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="mb-3">
                        <h6><strong><?= htmlspecialchars($comment['username']) ?></strong> <small class="text-muted"><?= $comment['created_at'] ?></small></h6>
                        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có bình luận nào.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Related items section-->
<section class="py-1 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Sản phẩm liên quan</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php if (!empty($relatedProducts)): ?>
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <img class="card-img-top" src="public/img/<?= $relatedProduct['image'] ?>" alt="<?= $relatedProduct['name'] ?>" />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?= $relatedProduct['name'] ?></h5>
                                    <?php if (!empty($relatedProduct['original_price'])): ?>
                                        <span class="text-decoration-line-through"><?= number_format($relatedProduct['original_price'], 0, ',', '.') ?> VND</span>
                                    <?php endif; ?>
                                    <span><?= number_format($relatedProduct['price'], 0, ',', '.') ?> VND</span>
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="index.php?controller=product&action=detail&id=<?= $relatedProduct['id'] ?>">Xem chi tiết</a></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm liên quan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer-->
<?php include 'app/Views/layouts/footer.php'; ?>
<script>
    document.getElementById('button-minus').addEventListener('click', function() {
        var inputQuantity = document.getElementById('inputQuantity');
        var currentValue = parseInt(inputQuantity.value);
        if (currentValue > 1) {
            inputQuantity.value = currentValue - 1;
            document.getElementById('quantityInput').value = currentValue - 1; // Cập nhật giá trị trong input ẩn
        }
    });

    document.getElementById('button-plus').addEventListener('click', function() {
        var inputQuantity = document.getElementById('inputQuantity');
        var currentValue = parseInt(inputQuantity.value);
        inputQuantity.value = currentValue + 1;
        document.getElementById('quantityInput').value = currentValue + 1; // Cập nhật giá trị trong input ẩn
    });
</script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
</body>
</html>