<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạng thái đơn hàng #<?php echo $donHang['id']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="views/css/customer-style.css">
    <style>
        .status-container {
            max-width: 1000px;
            margin: 30px auto;
        }
        .status-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .status-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .status-timeline {
            padding: 30px;
        }
        .timeline-item {
            position: relative;
            padding: 20px 0;
            border-left: 3px solid #e9ecef;
            margin-left: 20px;
        }
        .timeline-item:last-child {
            border-left: none;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 25px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #007bff;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #007bff;
        }
        .timeline-item.completed::before {
            background: #28a745;
            box-shadow: 0 0 0 3px #28a745;
        }
        .timeline-item.current::before {
            background: #ffc107;
            box-shadow: 0 0 0 3px #ffc107;
        }
        .timeline-item.cancelled::before {
            background: #dc3545;
            box-shadow: 0 0 0 3px #dc3545;
        }
        .timeline-content {
            margin-left: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        .timeline-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .timeline-date {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .timeline-description {
            color: #495057;
            font-size: 14px;
        }
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .status-chờxửlý {
            background: #fff3cd;
            color: #856404;
        }
        .status-đanggiao {
            background: #d1ecf1;
            color: #0c5460;
        }
        .status-đãgiao {
            background: #d4edda;
            color: #155724;
        }
        .status-đãhuỷ {
            background: #f8d7da;
            color: #721c24;
        }
        .estimated-delivery {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .estimated-delivery h6 {
            color: #0066cc;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="status-container">
        <div class="status-card">
            <div class="status-header">
                <h2><i class="bi bi-box-seam"></i> Trạng thái đơn hàng</h2>
                <h3 class="mt-2">Đơn hàng #<?php echo $donHang['id']; ?></h3>
                <span class="status-badge status-<?php echo str_replace(' ', '', $donHang['trang_thai']); ?> mt-3">
                    <?php echo ucfirst($donHang['trang_thai']); ?>
                </span>
            </div>

            <div class="status-timeline">
                <!-- Tóm tắt đơn hàng -->
                <div class="order-summary">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="bi bi-info-circle"></i> Thông tin đơn hàng</h5>
                            <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($donHang['ngay'])); ?></p>
                            <p><strong>Tổng tiền:</strong> <span class="text-primary fw-bold"><?php echo number_format($donHang['tong_tien']); ?> VNĐ</span></p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="bi bi-person"></i> Thông tin khách hàng</h5>
                            <p><strong>Tên:</strong> <?php echo htmlspecialchars($donHang['ten_nguoi_dung']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($donHang['email']); ?></p>
                            <?php if (!empty($donHang['dia_chi'])): ?>
                                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($donHang['dia_chi']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($donHang['so_dien_thoai'])): ?>
                                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($donHang['so_dien_thoai']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Dự kiến giao hàng -->
                <?php if ($donHang['trang_thai'] === 'chờ xử lý' || $donHang['trang_thai'] === 'đang giao'): ?>
                    <div class="estimated-delivery">
                        <h6><i class="bi bi-clock"></i> Dự kiến giao hàng</h6>
                        <?php if ($donHang['trang_thai'] === 'chờ xử lý'): ?>
                            <p class="mb-1">Đơn hàng của bạn đang được xử lý. Dự kiến sẽ được giao trong vòng 3-5 ngày làm việc.</p>
                        <?php elseif ($donHang['trang_thai'] === 'đang giao'): ?>
                            <p class="mb-1">Đơn hàng của bạn đang được giao. Dự kiến sẽ đến trong vòng 1-2 ngày.</p>
                        <?php endif; ?>
                        <small class="text-muted">Thời gian có thể thay đổi tùy thuộc vào địa điểm giao hàng và điều kiện thời tiết.</small>
                    </div>
                <?php endif; ?>

                <!-- Timeline trạng thái -->
                <h4 class="mb-4"><i class="bi bi-list-check"></i> Lịch sử trạng thái đơn hàng</h4>
                
                <?php if (empty($lichSuTrangThai)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-info-circle fs-1"></i>
                        <p>Chưa có thông tin cập nhật trạng thái</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($lichSuTrangThai as $index => $trangThai): ?>
                        <div class="timeline-item <?php 
                            if ($trangThai['trang_thai'] === 'đã giao') echo 'completed';
                            elseif ($trangThai['trang_thai'] === 'đã huỷ') echo 'cancelled';
                            elseif ($trangThai['trang_thai'] === $donHang['trang_thai']) echo 'current';
                        ?>">
                            <div class="timeline-content">
                                <div class="timeline-title">
                                    <?php 
                                    switch($trangThai['trang_thai']) {
                                        case 'chờ xử lý':
                                            echo '<i class="bi bi-hourglass-split text-primary"></i> Chờ xử lý';
                                            break;
                                        case 'đang giao':
                                            echo '<i class="bi bi-truck text-warning"></i> Đang giao hàng';
                                            break;
                                        case 'đã giao':
                                            echo '<i class="bi bi-check-circle text-success"></i> Đã giao hàng';
                                            break;
                                        case 'đã huỷ':
                                            echo '<i class="bi bi-x-circle text-danger"></i> Đã hủy';
                                            break;
                                        default:
                                            echo ucfirst($trangThai['trang_thai']);
                                    }
                                    ?>
                                </div>
                                <div class="timeline-date">
                                    <i class="bi bi-calendar-event"></i> 
                                    <?php echo date('d/m/Y H:i', strtotime($trangThai['ngay'])); ?>
                                </div>
                                <div class="timeline-description">
                                    <?php echo htmlspecialchars($trangThai['ghi_chu']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Nút hành động -->
                <div class="text-center mt-4">
                    <a href="?act=danhSachDonHang" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách đơn hàng
                    </a>
                    <a href="?act=xemDonHang&id=<?php echo $donHang['id']; ?>" class="btn btn-primary ms-2">
                        <i class="bi bi-eye"></i> Xem chi tiết đơn hàng
                    </a>
                    <a href="?act=hienthi" class="btn btn-success ms-2">
                        <i class="bi bi-cart-plus"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
