<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .orders-container {
            max-width: 1200px;
            margin: 30px auto;
        }
        .orders-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .orders-header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .orders-list {
            padding: 20px;
        }
        .order-item {
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
            transition: box-shadow 0.2s;
        }
        .order-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .order-header {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .order-body {
            padding: 15px;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
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
        .empty-orders {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="orders-container">
        <div class="orders-card">
            <div class="orders-header">
                <h2>Danh sách đơn hàng của bạn</h2>
            </div>

            <div class="orders-list">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success']; ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (empty($danhSachDonHang)): ?>
                    <div class="empty-orders">
                        <h3>Chưa có đơn hàng nào</h3>
                        <p>Bạn chưa có đơn hàng nào trong hệ thống.</p>
                        <a href="?act=hienthi" class="btn btn-primary">Bắt đầu mua sắm</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($danhSachDonHang as $donHang): ?>
                        <div class="order-item">
                            <div class="order-header">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <strong>Đơn hàng #<?php echo $donHang['id']; ?></strong>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="status-badge status-<?php echo $donHang['trang_thai']; ?>">
                                            <?php echo ucfirst($donHang['trang_thai']); ?>
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Ngày: <?php echo date('d/m/Y H:i', strtotime($donHang['ngay'])); ?></small>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <strong><?php echo number_format($donHang['tong_tien']); ?> VNĐ</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="order-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <small>Số sản phẩm: <?php echo $donHang['so_san_pham']; ?> sản phẩm</small>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <a href="?act=xemDonHang&id=<?php echo $donHang['id']; ?>" 
                                           class="btn btn-outline-primary btn-sm">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <div class="text-center mt-4">
                    <a href="?act=hienthi" class="btn btn-primary">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 