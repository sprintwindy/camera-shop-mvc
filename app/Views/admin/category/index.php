<?php include 'app/Views/admin/layouts/header.php'; ?>

    <h1>Quản lý Danh mục</h1>
    <a href="index.php?controller=admin&action=category_add" class="btn btn-primary mb-3">Thêm danh mục</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td><?= $category['name'] ?></td>
                <td>
                    <a href="index.php?controller=admin&action=category_edit&id=<?= $category['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="index.php?controller=admin&action=category_delete&id=<?= $category['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php include 'app/Views/admin/layouts/footer.php'; ?>