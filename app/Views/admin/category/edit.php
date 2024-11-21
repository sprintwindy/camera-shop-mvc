<?php include 'app/Views/admin/layouts/header.php'; ?>

    <h1>Sửa Danh mục</h1>
    <form action="index.php?controller=admin&action=category_edit&id=<?= $category['id'] ?>" method="POST">
        <div class="mb-3">
            <label for="categoryName" class="form-label">Tên Danh mục</label>
            <input type="text" class="form-control" id="categoryName" name="name" value="<?= $category['name'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>

<?php include 'app/Views/admin/layouts/footer.php'; ?>