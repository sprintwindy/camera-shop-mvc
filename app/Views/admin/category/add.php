<?php include 'app/Views/admin/layouts/header.php'; ?>

    <h1>Thêm Danh mục</h1>
    <form action="index.php?controller=admin&action=category_add" method="POST">
        <div class="mb-3">
            <label for="categoryName" class="form-label">Tên Danh mục</label>
            <input type="text" class="form-control" id="categoryName" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm mới</button>
    </form>

<?php include 'app/Views/admin/layouts/footer.php'; ?>