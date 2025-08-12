<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo đơn hàng - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin/views/css/admin-style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .filter-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .report-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-graph-up text-primary"></i> Báo cáo đơn hàng</h2>
            <div>
                <a href="?act=ql_donhang" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="bi bi-printer"></i> In báo cáo
                </button>
            </div>
        </div>

        <!-- Bộ lọc -->
        <div class="filter-section">
            <form method="GET" action="" class="row g-3">
                <input type="hidden" name="act" value="bao_cao_don_hang">
                <div class="col-md-3">
                    <label class="form-label">Loại báo cáo</label>
                    <select name="loai_bao_cao" class="form-select">
                        <option value="ngay" <?= ($_GET['loai_bao_cao'] ?? 'ngay') === 'ngay' ? 'selected' : '' ?>>Theo ngày</option>
                        <option value="thang" <?= ($_GET['loai_bao_cao'] ?? 'ngay') === 'thang' ? 'selected' : '' ?>>Theo tháng</option>
                        <option value="nam" <?= ($_GET['loai_bao_cao'] ?? 'ngay') === 'nam' ? 'selected' : '' ?>>Theo năm</option>
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
                            <i class="bi bi-search"></i> Tạo báo cáo
                        </button>
                        <a href="?act=bao_cao_don_hang" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stats-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-bag fa-3x mb-3"></i>
                        <h4><?= number_format($thongKe['tong_don_hang'] ?? 0) ?></h4>
                        <p class="mb-0">Tổng đơn hàng</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle fa-3x mb-3"></i>
                        <h4><?= number_format($thongKe['da_giao'] ?? 0) ?></h4>
                        <p class="mb-0">Đã giao</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-clock fa-3x mb-3"></i>
                        <h4><?= number_format($thongKe['cho_xu_ly'] ?? 0) ?></h4>
                        <p class="mb-0">Chờ xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-dollar fa-3x mb-3"></i>
                        <h4><?= number_format($thongKe['tong_doanh_thu'] ?? 0) ?>đ</h4>
                        <p class="mb-0">Tổng doanh thu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="text-center mb-3">
                        <i class="bi bi-pie-chart text-primary"></i> 
                        Phân bố trạng thái đơn hàng
                    </h5>
                    <canvas id="statusChart" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="text-center mb-3">
                        <i class="bi bi-graph-up text-primary"></i> 
                        Doanh thu theo thời gian
                    </h5>
                    <canvas id="revenueChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Bảng báo cáo chi tiết -->
        <div class="report-table">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-table text-primary"></i> 
                    Báo cáo chi tiết
                    <span class="badge bg-light text-primary ms-2"><?= count($baoCao) ?> bản ghi</span>
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Thời gian</th>
                            <th>Số đơn hàng</th>
                            <th>Doanh thu</th>
                            <th>Trung bình/đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($baoCao)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="bi bi-bar-chart fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Không có dữ liệu báo cáo</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($baoCao as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($item['thoi_gian']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?= number_format($item['so_don_hang']) ?></span>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold"><?= number_format($item['doanh_thu']) ?>đ</span>
                                    </td>
                                    <td>
                                        <?php if ($item['so_don_hang'] > 0): ?>
                                            <span class="text-info"><?= number_format($item['trung_binh_don_hang']) ?>đ</span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Thống kê bổ sung -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-info-circle text-primary"></i> Thông tin bổ sung</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Đang giao:</strong> <?= number_format($thongKe['dang_giao'] ?? 0) ?></p>
                                <p><strong>Đã hủy:</strong> <?= number_format($thongKe['da_huy'] ?? 0) ?></p>
                            </div>
                            <div class="col-6">
                                <p><strong>Trung bình/đơn:</strong> <?= number_format($thongKe['trung_binh_don_hang'] ?? 0) ?>đ</p>
                                <p><strong>Tỷ lệ thành công:</strong> 
                                    <?php 
                                    $tyLeThanhCong = ($thongKe['tong_don_hang'] ?? 0) > 0 
                                        ? round((($thongKe['da_giao'] ?? 0) / ($thongKe['tong_don_hang'] ?? 1)) * 100, 1)
                                        : 0;
                                    ?>
                                    <span class="badge bg-success"><?= $tyLeThanhCong ?>%</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-lightbulb text-warning"></i> Gợi ý</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <?php if (($thongKe['cho_xu_ly'] ?? 0) > 5): ?>
                                <li><i class="bi bi-exclamation-triangle text-warning"></i> Có nhiều đơn hàng chờ xử lý</li>
                            <?php endif; ?>
                            <?php if (($thongKe['da_huy'] ?? 0) > ($thongKe['tong_don_hang'] ?? 0) * 0.1): ?>
                                <li><i class="bi bi-exclamation-triangle text-danger"></i> Tỷ lệ hủy đơn hàng cao</li>
                            <?php endif; ?>
                            <?php if (($thongKe['tong_doanh_thu'] ?? 0) > 0): ?>
                                <li><i class="bi bi-hand-thumbs-up text-success"></i> Doanh thu ổn định</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Biểu đồ trạng thái đơn hàng
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Chờ xử lý', 'Đang giao', 'Đã giao', 'Đã hủy'],
                datasets: [{
                    data: [
                        <?= $thongKe['cho_xu_ly'] ?? 0 ?>,
                        <?= $thongKe['dang_giao'] ?? 0 ?>,
                        <?= $thongKe['da_giao'] ?? 0 ?>,
                        <?= $thongKe['da_huy'] ?? 0 ?>
                    ],
                    backgroundColor: [
                        '#ffc107',
                        '#17a2b8',
                        '#28a745',
                        '#dc3545'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Biểu đồ doanh thu
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = <?= json_encode($baoCao) ?>;
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => item.thoi_gian),
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData.map(item => item.doanh_thu),
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
