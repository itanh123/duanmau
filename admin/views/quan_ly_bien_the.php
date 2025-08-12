<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý biến thể sản phẩm - Admin</title>
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
        .action-buttons {
            display: flex;
            gap: 5px;
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
            <h2>Quản lý biến thể sản phẩm</h2>
            <a href="?act=them_bien_the" class="btn btn-success">Thêm biến thể mới</a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Màu sắc</th>
                        <th>Kích thước</th>
                        <th>Số lượng tồn kho</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bienThe)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Chưa có biến thể nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($bienThe as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['ten_san_pham'] ?></td>
                            <td>
                                <span class="badge bg-primary"><?= $item['mau_sac'] ?></span>
                            </td>
                            <td><?= $item['kich_thuoc'] ?></td>
                            <td>
                                <span class="badge <?= $item['so_luong'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $item['so_luong'] ?>
                                </span>
                            </td>
                            <td class="action-buttons">
                                <a href="?act=sua_bien_the&id=<?= $item['id'] ?>" 
                                   class="btn btn-warning btn-sm">Sửa</a>
                                <a href="?act=xoa_bien_the&id=<?= $item['id'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc muốn xóa biến thể này?')">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
