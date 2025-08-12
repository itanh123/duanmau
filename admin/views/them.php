<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            padding: 30px;
        }
        .form-container {
            max-width: 650px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label {
            font-weight: 500;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .form-text {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <!-- Sidebar menu -->
    <div class="sidebar">
        <h4>Admin Menu</h4>
        <a href="?act=home">Trang chủ</a>
        <a href="?act=them">Thêm sản phẩm</a>
        <a href="?act=quan_ly_bien_the">Quản lý biến thể</a>
        <a href="?act=ql_donhang">Quản lý đơn hàng</a>
        <a href="?act=ql_nguoidung">Quản lý người dùng</a>
        <a href="?act=logout">Đăng xuất</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Thêm sản phẩm mới</h2>
            <a href="?act=/" class="btn btn-secondary">⬅ Quay lại</a>
        </div>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data" action="?act=them">
                <div class="mb-3">
                    <label for="ten" class="form-label">Tên sản phẩm *</label>
                    <input type="text" class="form-control" id="ten" name="ten" 
                           placeholder="Nhập tên sản phẩm..." required>
                </div>

                <div class="mb-3">
                    <label for="gia" class="form-label">Giá (VND) *</label>
                    <input type="number" class="form-control" id="gia" name="gia" 
                           min="0" placeholder="Nhập giá sản phẩm..." required>
                </div>

                <div class="mb-3">
                    <label for="mo_ta" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="4" 
                              placeholder="Nhập mô tả sản phẩm..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="hinh_anh" class="form-label">Hình ảnh sản phẩm *</label>
                    <input type="file" class="form-control" id="hinh_anh" name="hinh_anh" 
                           accept="image/*" required>
                    <div class="form-text">Chọn file ảnh (JPG, PNG, GIF...)</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Thêm sản phẩm</button>
                    <a href="?act=/" class="btn btn-secondary">❌ Hủy</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
