<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .order-container {
            max-width: 1000px;
            margin: 30px auto;
        }
        .order-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .order-header {
            background: #28a745;
            color: white;
            padding: 20px;
        }
        .order-info {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        .order-items {
            padding: 20px;
        }
        .order-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            gap: 15px;
        }
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .item-variant {
            color: #666;
            font-size: 14px;
        }
        .item-price {
            font-weight: bold;
            color: #007bff;
        }
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #eee;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-shipping {
            background: #d1ecf1;
            color: #0c5460;
        }
        .status-delivered {
            background: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            gap: 5px;
        }
        .rating-input input[type="radio"] {
            display: none;
        }
        .rating-input label {
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating-input label:hover,
        .rating-input label:hover ~ label,
        .rating-input input[type="radio"]:checked ~ label {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <div class="order-card">
            <div class="order-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Đơn hàng #<?php echo $donHang['id']; ?></h2>
                    <span class="status-badge status-<?php echo str_replace(' ', '', $donHang['trang_thai']); ?>">
                        <?php echo ucfirst($donHang['trang_thai']); ?>
                    </span>
                </div>
            </div>

            <div class="order-info">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Thông tin khách hàng</h5>
                        <p><strong>Tên:</strong> <?php echo $donHang['ten_nguoi_dung']; ?></p>
                        <p><strong>Email:</strong> <?php echo $donHang['email']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Thông tin đơn hàng</h5>
                        <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($donHang['ngay'])); ?></p>
                        <p><strong>Mã đơn hàng:</strong> #<?php echo $donHang['id']; ?></p>
                    </div>
                </div>
            </div>

            <div class="order-items">
                <h4 class="mb-3">Chi tiết sản phẩm</h4>
                
                <?php 
                $tongTien = 0;
                foreach ($chiTietDonHang as $item): 
                    $thanhTien = $item['gia'] * $item['so_luong'];
                    $tongTien += $thanhTien;
                ?>
                    <div class="order-item">
                        <img src="<?php echo $item['hinh_anh']; ?>" alt="<?php echo $item['ten_san_pham']; ?>" 
                             class="item-image" onerror="this.src='hinhanh/default.jpg'">
                        
                        <div class="item-details">
                            <div class="item-name"><?php echo $item['ten_san_pham']; ?></div>
                            <div class="item-variant">
                                Màu: <?php echo $item['mau_sac']; ?> | 
                                Kích thước: <?php echo $item['kich_thuoc']; ?>
                            </div>
                            <div class="item-price"><?php echo number_format($item['gia']); ?> VNĐ</div>
                        </div>

                        <div class="item-quantity">
                            <strong>Số lượng: <?php echo $item['so_luong']; ?></strong>
                        </div>

                        <div class="item-total">
                            <strong><?php echo number_format($thanhTien); ?> VNĐ</strong>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="order-summary">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Tổng cộng</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <h4 class="text-primary"><?php echo number_format($tongTien); ?> VNĐ</h4>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="?act=danhSachDonHang" class="btn btn-outline-secondary">Quay lại danh sách đơn hàng</a>
                        <a href="?act=hienthi" class="btn btn-primary">Tiếp tục mua sắm</a>
                    </div>

                    <?php if ($donHang['trang_thai'] === 'đã giao'): ?>
                        <?php 
                        // Kiểm tra xem đã có phản hồi chưa
                        $phanHoi = $this->example->layPhanHoiDonHang($donHang['id']);
                        $coThePhanHoi = $this->example->coThePhanHoi($donHang['id'], $_SESSION['user_id']);
                        ?>
                        
                        <?php if ($phanHoi): ?>
                            <!-- Hiển thị phản hồi đã có -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6>Phản hồi của bạn:</h6>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="text-warning"><?= $i <= $phanHoi['diem_danh_gia'] ? '★' : '☆' ?></span>
                                        <?php endfor; ?>
                                    </div>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($phanHoi['ngay_tao'])) ?></small>
                                </div>
                                <p class="mb-0"><?= htmlspecialchars($phanHoi['noi_dung']) ?></p>
                            </div>
                        <?php elseif ($coThePhanHoi): ?>
                            <!-- Form phản hồi -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6>Đánh giá đơn hàng</h6>
                                <form method="POST" action="?act=themPhanHoi">
                                    <input type="hidden" name="id_don_hang" value="<?= $donHang['id'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Điểm đánh giá:</label>
                                        <div class="rating-input">
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                                <input type="radio" name="diem_danh_gia" value="<?= $i ?>" id="star<?= $i ?>" <?= $i == 5 ? 'checked' : '' ?>>
                                                <label for="star<?= $i ?>" class="text-warning fs-4">★</label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="noi_dung" class="form-label">Nội dung phản hồi:</label>
                                        <textarea class="form-control" name="noi_dung" id="noi_dung" rows="3" 
                                                  placeholder="Hãy chia sẻ trải nghiệm của bạn về đơn hàng này..." required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success">Gửi phản hồi</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 