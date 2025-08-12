<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin/views/css/admin-style.css">
    <style>
        .sidebar {
            width: 220px;
            background-color: #343a40;
            padding: 20px;
            color: white;
            flex-shrink: 0;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 8px 0;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            text-decoration: underline;
            background-color: #495057;
            border-radius: 4px;
            padding-left: 10px;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-card h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: bold;
        }
        .stats-card p {
            margin: 0;
            opacity: 0.9;
        }
        .table-responsive {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            background: white;
            padding: 10px;
        }
        .btn-action {
            margin: 2px;
        }
        .role-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
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
        <a href="?act=ql_nguoidung" class="active">Quản lý người dùng</a>
        <a href="?act=logout">Đăng xuất</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="bi bi-people-fill"></i> Quản lý người dùng</h2>
                <p class="text-muted">Quản lý tài khoản người dùng và phân quyền hệ thống</p>
            </div>
            <div>
                <a href="?act=them_nguoi_dung" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Thêm người dùng mới
                </a>
                <a href="?act=/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <!-- Thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Thống kê -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <h3><?= $thongKe['tong_nguoi_dung'] ?? 0 ?></h3>
                    <p>Tổng người dùng</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h3><?= $thongKe['so_admin'] ?? 0 ?></h3>
                    <p>Quản trị viên</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h3><?= $thongKe['so_user'] ?? 0 ?></h3>
                    <p>Người dùng thường</p>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách người dùng -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Danh sách người dùng</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($nguoiDung)): ?>
                                <tr>
                                                                    <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Chưa có người dùng nào
                                </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($nguoiDung as $user): ?>
                                    <tr>
                                        <td><strong>#<?= $user['id'] ?></strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                    <i class="bi bi-person text-white"></i>
                                                </div>
                                                <span class="fw-medium"><?= htmlspecialchars($user['ten']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="bi bi-envelope text-muted me-1"></i>
                                            <?= htmlspecialchars($user['email']) ?>
                                        </td>
                                        <td>
                                            <?php if ($user['vai_tro'] === 'admin'): ?>
                                                <span class="badge bg-danger role-badge">
                                                    <i class="bi bi-shield-check"></i> Admin
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary role-badge">
                                                    <i class="bi bi-person"></i> User
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt"></i>
                                                <?= htmlspecialchars($user['dia_chi'] ?? 'Chưa cập nhật') ?>
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone"></i>
                                                <?= htmlspecialchars($user['so_dien_thoai'] ?? 'Chưa cập nhật') ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="?act=sua_nguoi_dung&id=<?= $user['id'] ?>" 
                                                   class="btn btn-warning btn-sm btn-action" 
                                                   title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <?php if ($user['vai_tro'] !== 'admin' || count($nguoiDung) > 1): ?>
                                                    <a href="?act=xoa_nguoi_dung&id=<?= $user['id'] ?>" 
                                                       class="btn btn-danger btn-sm btn-action" 
                                                       title="Xóa"
                                                       onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
