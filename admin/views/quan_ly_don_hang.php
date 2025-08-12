<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        .card-stats {
            transition: transform 0.2s;
        }
        .card-stats:hover {
            transform: translateY(-2px);
        }
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        .btn-action {
            margin: 0 2px;
        }
        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-shopping-cart text-primary"></i> Quản lý đơn hàng</h2>
            <div>
                <a href="?act=bao_cao_don_hang" class="btn btn-info">
                    <i class="fas fa-chart-bar"></i> Báo cáo
                </a>
                <a href="?act=home" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-stats bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Tổng đơn hàng</h6>
                                <h3><?= number_format($thongKe['tong_don_hang'] ?? 0) ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shopping-bag fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Chờ xử lý</h6>
                                <h3><?= number_format($thongKe['cho_xu_ly'] ?? 0) ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Đã giao</h6>
                                <h3><?= number_format($thongKe['da_giao'] ?? 0) ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Doanh thu</h6>
                                <h3><?= number_format($thongKe['tong_doanh_thu'] ?? 0) ?>đ</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-money-bill-wave fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bộ lọc -->
        <div class="filter-section">
            <form method="GET" action="" class="row g-3">
                <input type="hidden" name="act" value="ql_donhang">
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="trang_thai" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <?php foreach ($danhSachTrangThai as $key => $value): ?>
                            <option value="<?= $value ?>" <?= ($_GET['trang_thai'] ?? '') === $value ? 'selected' : '' ?>>
                                <?= ucfirst($value) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="ngay_bat_dau" class="form-control" value="<?= $_GET['ngay_bat_dau'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="ngay_ket_thuc" class="form-control" value="<?= $_GET['ngay_ket_thuc'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Lọc
                        </button>
                        <a href="?act=ql_donhang" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bảng đơn hàng -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Danh sách đơn hàng
                    <span class="badge bg-primary ms-2"><?= count($danhSachDonHang) ?> đơn hàng</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($danhSachDonHang)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Không có đơn hàng nào</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($danhSachDonHang as $donHang): ?>
                                    <tr>
                                        <td>
                                            <strong>#<?= $donHang['id'] ?></strong>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($donHang['ten_nguoi_dung']) ?></strong><br>
                                                <small class="text-muted"><?= htmlspecialchars($donHang['email']) ?></small><br>
                                                <small class="text-muted"><?= htmlspecialchars($donHang['so_dien_thoai']) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y H:i', strtotime($donHang['ngay'])) ?>
                                        </td>
                                        <td>
                                            <strong class="text-success"><?= number_format($donHang['tong_tien']) ?>đ</strong>
                                        </td>
                                        <td>
                                            <?php
                                            $trangThaiClass = '';
                                            $trangThaiIcon = '';
                                            switch ($donHang['trang_thai']) {
                                                case 'chờ xử lý':
                                                    $trangThaiClass = 'bg-warning';
                                                    $trangThaiIcon = 'fas fa-clock';
                                                    break;
                                                case 'đang giao':
                                                    $trangThaiClass = 'bg-info';
                                                    $trangThaiIcon = 'fas fa-truck';
                                                    break;
                                                case 'đã giao':
                                                    $trangThaiClass = 'bg-success';
                                                    $trangThaiIcon = 'fas fa-check-circle';
                                                    break;
                                                case 'đã huỷ':
                                                    $trangThaiClass = 'bg-danger';
                                                    $trangThaiIcon = 'fas fa-times-circle';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $trangThaiClass ?> status-badge">
                                                <i class="<?= $trangThaiIcon ?>"></i>
                                                <?= ucfirst($donHang['trang_thai']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="?act=chi_tiet_don_hang&id=<?= $donHang['id'] ?>" 
                                                   class="btn btn-sm btn-outline-primary btn-action" 
                                                   title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($donHang['trang_thai'] === 'chờ xử lý'): ?>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-success btn-action" 
                                                            title="Cập nhật trạng thái"
                                                            onclick="openUpdateStatusModal(<?= $donHang['id'] ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <?php if (in_array($donHang['trang_thai'], ['chờ xử lý', 'đang giao'])): ?>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger btn-action" 
                                                            title="Hủy đơn hàng"
                                                            onclick="openCancelOrderModal(<?= $donHang['id'] ?>)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
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

    <!-- Modal cập nhật trạng thái -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="?act=cap_nhat_trang_thai_don_hang" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_don_hang" id="updateOrderId">
                        <div class="mb-3">
                            <label class="form-label">Trạng thái mới</label>
                            <select name="trang_thai" class="form-select" required>
                                <option value="">Chọn trạng thái</option>
                                <option value="đang giao">Đang giao</option>
                                <option value="đã giao">Đã giao</option>
                                <option value="đã huỷ">Đã huỷ</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="ghi_chu" class="form-control" rows="3" placeholder="Ghi chú (không bắt buộc)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal hủy đơn hàng -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hủy đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="?act=huy_don_hang" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_don_hang" id="cancelOrderId">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Lưu ý:</strong> Khi hủy đơn hàng, số lượng sản phẩm sẽ được hoàn trả về kho.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lý do hủy</label>
                            <textarea name="ly_do_huy" class="form-control" rows="3" placeholder="Nhập lý do hủy đơn hàng" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openUpdateStatusModal(orderId) {
            document.getElementById('updateOrderId').value = orderId;
            new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
        }

        function openCancelOrderModal(orderId) {
            document.getElementById('cancelOrderId').value = orderId;
            new bootstrap.Modal(document.getElementById('cancelOrderModal')).show();
        }

        // Hiển thị thông báo
        <?php if (isset($_SESSION['success'])): ?>
            alert('<?= $_SESSION['success'] ?>');
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            alert('<?= $_SESSION['error'] ?>');
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
