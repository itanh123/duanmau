<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin/views/css/admin-style.css">
    <style>
        .product-image {
            max-width: 80px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .page-header h2 {
            color: white;
            margin-bottom: 0;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <!-- Sidebar menu -->
    <div class="sidebar">
        <h4><i class="bi bi-gear-fill"></i> Admin Panel</h4>
        <a href="?act=home" class="active">
            <i class="bi bi-house-door"></i> Trang chủ
        </a>
        <a href="?act=them">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
        </a>
        <a href="?act=quan_ly_bien_the">
            <i class="bi bi-collection"></i> Quản lý biến thể
        </a>
        <a href="?act=ql_donhang">
            <i class="bi bi-cart-check"></i> Quản lý đơn hàng
        </a>
        <a href="?act=ql_nguoidung">
            <i class="bi bi-people"></i> Quản lý người dùng
        </a>
        <a href="?act=timKiemSanPham">
            <i class="bi bi-search"></i> Tìm kiếm
        </a>
        <a href="?act=logout">
            <i class="bi bi-box-arrow-right"></i> Đăng xuất
        </a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="bi bi-box-seam"></i> Quản lý sản phẩm</h2>
                <a href="?act=them" class="btn btn-light">
                    <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
                </a>
            </div>
        </div>

        <!-- Products Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="bi bi-hash"></i> ID</th>
                            <th><i class="bi bi-tag"></i> Tên sản phẩm</th>
                            <th><i class="bi bi-text-paragraph"></i> Mô tả</th>
                            <th><i class="bi bi-currency-dollar"></i> Giá</th>
                            <th><i class="bi bi-image"></i> Hình ảnh</th>
                            <th><i class="bi bi-collection"></i> Biến thể</th>
                            <th><i class="bi bi-gear"></i> Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sanpham as $item): ?>
                        <tr>
                            <td><span class="badge bg-secondary">#<?= $item['id'] ?></span></td>
                            <td>
                                <strong><?= htmlspecialchars($item['ten']) ?></strong>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?= htmlspecialchars(substr($item['mo_ta'], 0, 100)) ?>
                                    <?= strlen($item['mo_ta']) > 100 ? '...' : '' ?>
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <?= number_format($item['gia']) ?> VND
                                </span>
                            </td>
                            <td>
                                <img src="<?= $item["hinh_anh"] ?>" alt="Ảnh sản phẩm" class="product-image">
                            </td>
                            <td>
                                <a href="?act=quan_ly_bien_the&san_pham_id=<?= $item['id'] ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="bi bi-collection"></i> Xem biến thể
                                </a>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?act=sua&id=<?= $item['id'] ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <a href="?act=xoa&id=<?= $item['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (empty($sanpham)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="text-muted mt-3">Chưa có sản phẩm nào</h4>
                <p class="text-muted">Hãy thêm sản phẩm đầu tiên để bắt đầu</p>
                <a href="?act=them" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
