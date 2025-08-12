<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm biến thể sản phẩm - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
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
            <h2>Thêm biến thể sản phẩm mới</h2>
            <a href="?act=quan_ly_bien_the" class="btn btn-secondary">Quay lại</a>
        </div>

        <div class="form-container">
            <form method="POST" action="?act=them_bien_the">
                <div class="mb-3">
                    <label for="id_san_pham" class="form-label">Chọn sản phẩm *</label>
                    <select class="form-select" id="id_san_pham" name="id_san_pham" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        <?php foreach($sanPham as $sp): ?>
                            <option value="<?= $sp['id'] ?>"><?= $sp['ten'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="mau_sac" class="form-label">Màu sắc *</label>
                    <input type="text" class="form-control" id="mau_sac" name="mau_sac" 
                           placeholder="Ví dụ: Đỏ, Xanh, Trắng..." required>
                </div>

                <div class="mb-3">
                    <label for="kich_thuoc" class="form-label">Kích thước *</label>
                    <input type="text" class="form-control" id="kich_thuoc" name="kich_thuoc" 
                           placeholder="Ví dụ: S, M, L, XL, 40, 41, 42..." required>
                </div>

                <div class="mb-3">
                    <label for="so_luong" class="form-label">Số lượng tồn kho *</label>
                    <input type="number" class="form-control" id="so_luong" name="so_luong" 
                           min="0" value="0" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Thêm biến thể</button>
                    <a href="?act=quan_ly_bien_the" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
