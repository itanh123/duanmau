<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm - Admin</title>
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
        .current-image {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
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
            <h2>Sửa sản phẩm</h2>
            <a href="?act=/" class="btn btn-secondary">Quay lại</a>
        </div>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data" action="?act=sua&id=<?= $sanpham['id'] ?>">
                <div class="mb-3">
                    <label for="ten" class="form-label">Tên sản phẩm *</label>
                    <input type="text" class="form-control" id="ten" name="ten" 
                           value="<?= htmlspecialchars($sanpham['ten']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="gia" class="form-label">Giá (VND) *</label>
                    <input type="number" class="form-control" id="gia" name="gia" 
                           value="<?= htmlspecialchars($sanpham['gia']) ?>" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="mo_ta" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="4"><?= htmlspecialchars($sanpham['mo_ta']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại</label>
                    <div class="current-image">
                        <?php if (!empty($sanpham['hinh_anh_url'])): ?>
                            <img src="<?= $sanpham['hinh_anh_url'] ?>" alt="Ảnh sản phẩm" class="img-thumbnail" style="max-width: 200px;">
                        <?php else: ?>
                            <p class="text-muted">Không có ảnh.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Chọn ảnh mới (nếu muốn thay đổi)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text">Để trống nếu không muốn thay đổi ảnh</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                    <a href="?act=/" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
