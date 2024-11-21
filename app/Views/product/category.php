<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="public/css/styles.css">

</head>
<body>
<?php include 'app/Views/layouts/header.php'; ?>

    <div class="container mt-5">
        <h1>Danh mục: <?= $category['name'] ?></h1>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php foreach ($products as $product): ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="public/img/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?= $product['name'] ?></h5>
                                        <!-- Product price-->
                                        <span><?= number_format($product['price'], 0, ',', '.') ?> VND</span>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="index.php?controller=product&action=detail&id=<?= $product['id'] ?>">Xem chi tiết</a></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'app/Views/layouts/footer.php'; ?>
</body>
</html>
