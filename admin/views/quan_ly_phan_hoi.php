<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phản hồi - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
            font-size: 1.5rem;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: #fff;
            transform: translateX(5px);
        }
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
            border-left-color: #fff;
        }
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card h3 {
            font-size: 2rem;
            margin: 0;
            color: #667eea;
        }
        .stat-card p {
            margin: 10px 0 0 0;
            color: #666;
            font-weight: 500;
        }
        .feedback-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .feedback-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
        }
        .feedback-body {
            padding: 20px;
        }
        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .btn-action {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <a href="?act=home">Trang chủ</a>
            <a href="?act=them">Thêm sản phẩm</a>
            <a href="?act=quan_ly_bien_the">Quản lý biến thể</a>
            <a href="?act=ql_donhang">Quản lý đơn hàng</a>
            <a href="?act=ql_nguoidung">Quản lý người dùng</a>
            <a href="?act=timKiemSanPham">Tìm kiếm</a>
            <a href="?act=quan_ly_phan_hoi" class="active">Quản lý phản hồi</a>
            <a href="?act=logout">Đăng xuất</a>
        </div>

        <!-- Main content -->
        <div class="main-content">
            <h2 class="mb-4">Quản lý phản hồi đơn hàng</h2>

            <!-- Thống kê -->
            <div class="stats-cards">
                <div class="stat-card">
                    <h3><?= $thongKePhanHoi['tong_phan_hoi'] ?? 0 ?></h3>
                    <p>Tổng phản hồi</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <h3><?= $thongKePhanHoi['cho_duyet'] ?? 0 ?></h3>
                    <p>Chờ duyệt</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                    <h3><?= $thongKePhanHoi['da_duyet'] ?? 0 ?></h3>
                    <p>Đã duyệt</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                    <h3><?= $thongKePhanHoi['tu_choi'] ?? 0 ?></h3>
                    <p>Từ chối</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);">
                    <h3><?= number_format($thongKePhanHoi['diem_trung_binh'] ?? 0, 1) ?></h3>
                    <p>Điểm TB</p>
                </div>
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

            <!-- Danh sách phản hồi -->
            <div class="feedback-list">
                <?php if (empty($danhSachPhanHoi)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-chat-dots fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Chưa có phản hồi nào</h5>
                    </div>
                <?php else: ?>
                    <?php foreach ($danhSachPhanHoi as $phanHoi): ?>
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($phanHoi['ten_nguoi_dung']) ?></strong>
                                        <small class="text-muted ms-2"><?= $phanHoi['email'] ?></small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="rating-stars me-3">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?= $i <= $phanHoi['diem_danh_gia'] ? '★' : '☆' ?>
                                            <?php endfor; ?>
                                        </span>
                                        <span class="status-badge status-<?= str_replace(' ', '', $phanHoi['trang_thai']) ?>">
                                            <?= ucfirst($phanHoi['trang_thai']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="feedback-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="mb-2"><strong>Nội dung:</strong></p>
                                        <p class="mb-3"><?= htmlspecialchars($phanHoi['noi_dung']) ?></p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3"></i>
                                            Đơn hàng #<?= $phanHoi['id_don_hang'] ?> - 
                                            <?= date('d/m/Y H:i', strtotime($phanHoi['ngay_tao'])) ?>
                                        </small>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <?php if ($phanHoi['trang_thai'] === 'chờ duyệt'): ?>
                                            <button class="btn btn-success btn-sm btn-action" 
                                                    onclick="capNhatTrangThai(<?= $phanHoi['id'] ?>, 'đã duyệt')">
                                                <i class="bi bi-check-circle"></i> Duyệt
                                            </button>
                                            <button class="btn btn-danger btn-sm btn-action" 
                                                    onclick="capNhatTrangThai(<?= $phanHoi['id'] ?>, 'từ chối')">
                                                <i class="bi bi-x-circle"></i> Từ chối
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button class="btn btn-outline-danger btn-sm btn-action" 
                                                onclick="xoaPhanHoi(<?= $phanHoi['id'] ?>)">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function capNhatTrangThai(idPhanHoi, trangThai) {
            if (confirm('Bạn có chắc chắn muốn ' + (trangThai === 'đã duyệt' ? 'duyệt' : 'từ chối') + ' phản hồi này?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '?act=cap_nhat_trang_thai_phan_hoi';
                
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id_phan_hoi';
                inputId.value = idPhanHoi;
                
                const inputTrangThai = document.createElement('input');
                inputTrangThai.type = 'hidden';
                inputTrangThai.name = 'trang_thai';
                inputTrangThai.value = trangThai;
                
                form.appendChild(inputId);
                form.appendChild(inputTrangThai);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function xoaPhanHoi(idPhanHoi) {
            if (confirm('Bạn có chắc chắn muốn xóa phản hồi này?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '?act=xoa_phan_hoi';
                
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id_phan_hoi';
                inputId.value = idPhanHoi;
                
                form.appendChild(inputId);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
