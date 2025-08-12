<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="views/css/customer-style.css">
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
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
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
        .total {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
            margin-bottom: 20px;
        }
        .total .price-breakdown {
            text-align: left;
        }
        .btn-order {
            background: #28a745;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
        }
        .btn-order:hover {
            background: #218838;
        }
        .empty-cart {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        .alert {
            margin-bottom: 20px;
        }
        .price-breakdown {
            text-align: left;
            margin-bottom: 20px;
        }
        .price-item {
            margin-bottom: 8px;
            font-size: 16px;
            color: #495057;
        }
        .price-discount {
            margin-bottom: 8px;
            color: #28a745;
            font-size: 16px;
            font-weight: 500;
        }
        .price-total {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <div class="order-card">
            <div class="order-header">
                <h2>Đặt hàng</h2>
            </div>

            <div class="order-items">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($gioHang)): ?>
                    <div class="empty-cart">
                        <h3>Giỏ hàng trống</h3>
                        <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                        <a href="?act=hienthi" class="btn btn-primary">Tiếp tục mua sắm</a>
                    </div>
                <?php else: ?>
                    <h4 class="mb-3">Chi tiết đơn hàng</h4>
                    
                    <?php 
                    $tongTien = 0;
                    foreach ($gioHang as $item): 
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
                        <div class="total">
                            <?php 
                            $tongTienGoc = $tongTien;
                            $soTienGiam = 0;
                            $tongTienSauGiam = $tongTien;
                            
                            if (isset($maGiamGia)) {
                                $soTienGiam = $maGiamGia['so_tien_giam'];
                                $tongTienSauGiam = $tongTien - $soTienGiam;
                            }
                            ?>
                            
                            <div class="price-breakdown">
                                <div class="price-item">Tổng tiền hàng: <?php echo number_format($tongTienGoc); ?> VNĐ</div>
                                <?php if ($soTienGiam > 0): ?>
                                    <div class="price-discount">
                                        Giảm giá: -<?php echo number_format($soTienGiam); ?> VNĐ 
                                        (<?php echo $maGiamGia['phan_tram']; ?>%)
                                    </div>
                                <?php endif; ?>
                                <div class="price-total">
                                    Tổng thanh toán: <?php echo number_format($tongTienSauGiam); ?> VNĐ
                                </div>
                            </div>
                        </div>
                        
                        <form method="POST">
                            <button type="submit" class="btn-order" 
                                    onclick="return confirm('Bạn có chắc muốn đặt hàng?')">
                                Xác nhận đặt hàng
                            </button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="?act=xemGioHang" class="btn btn-outline-secondary">Quay lại giỏ hàng</a>
                            <a href="?act=hienthi" class="btn btn-outline-primary">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
