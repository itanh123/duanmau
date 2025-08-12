<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa biến thể sản phẩm - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin/views/css/admin-style.css">
    <style>
        .sidebar {
            width: 220px;
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 8px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
        }
        .product-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar menu -->
    <div class="sidebar">
        <h4>Admin Menu</h4>
        <a href="?act=/">Trang chủ</a>
        <a href="?act=them">Thêm sản phẩm</a>
        <a href="?act=quan_ly_bien_the">Quản lý biến thể</a>
        <a href="?act=ql_donhang">Quản lý đơn hàng</a>
        <a href="?act=ql_nguoidung">Quản lý người dùng</a>
        <a href="?act=logout">Đăng xuất</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Sửa biến thể sản phẩm</h2>
            <a href="?act=quan_ly_bien_the" class="btn btn-secondary">Quay lại</a>
        </div>

        <?php if (isset($bienThe)): ?>
            <div class="product-info">
                <h5>Thông tin sản phẩm:</h5>
                <p><strong>Tên sản phẩm:</strong> <?= $bienThe['ten_san_pham'] ?></p>
                <p><strong>ID biến thể:</strong> <?= $bienThe['id'] ?></p>
            </div>

            <div class="form-container">
                <form method="POST" action="?act=sua_bien_the&id=<?= $bienThe['id'] ?>">
                    <div class="mb-3">
                        <label for="mau_sac" class="form-label">Màu sắc *</label>
                        <input type="text" class="form-control" id="mau_sac" name="mau_sac" 
                               value="<?= htmlspecialchars($bienThe['mau_sac']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="kich_thuoc" class="form-label">Kích thước *</label>
                        <input type="text" class="form-control" id="kich_thuoc" name="kich_thuoc" 
                               value="<?= htmlspecialchars($bienThe['kich_thuoc']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="so_luong" class="form-label">Số lượng tồn kho *</label>
                        <input type="number" class="form-control" id="so_luong" name="so_luong" 
                               min="0" value="<?= $bienThe['so_luong'] ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Cập nhật biến thể</button>
                        <a href="?act=quan_ly_bien_the" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Không tìm thấy biến thể cần sửa!
            </div>
            <a href="?act=quan_ly_bien_the" class="btn btn-primary">Quay lại danh sách</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
