<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .cart-items {
            padding: 20px;
        }
        .cart-item {
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
            font-size: 18px;
            margin-bottom: 5px;
        }
        .item-variant {
            color: #666;
            font-size: 14px;
        }
        .item-price {
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-input {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .cart-summary {
            background: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #eee;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-bottom: 20px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .empty-cart {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        .empty-cart h3 {
            margin-bottom: 20px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .discount-section {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .discount-section h4 {
            color: #495057;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .applied-discount {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
        }
        .discount-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .discount-input {
            flex: 1;
            padding: 10px 12px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        .discount-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        .discount-btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .discount-btn:hover {
            background: #0056b3;
            transform: translateY(-1px);
        }
        .remove-discount-btn {
            padding: 6px 12px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .remove-discount-btn:hover {
            background: #c82333;
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
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Giỏ hàng của bạn</h1>
        </div>

        <div class="cart-items">
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
                <?php 
                $tongTien = 0;
                foreach ($gioHang as $item): 
                    $thanhTien = $item['gia'] * $item['so_luong'];
                    $tongTien += $thanhTien;
                ?>
                    <div class="cart-item">
                        <img src="<?php echo $item['hinh_anh']; ?>" alt="<?php echo $item['ten_san_pham']; ?>" class="item-image" 
                             onerror="this.src='hinhanh/default.jpg'">
                        
                        <div class="item-details">
                            <div class="item-name"><?php echo $item['ten_san_pham']; ?></div>
                            <div class="item-variant">
                                Màu: <?php echo $item['mau_sac']; ?> | 
                                Kích thước: <?php echo $item['kich_thuoc']; ?>
                            </div>
                            <div class="item-price"><?php echo number_format($item['gia']); ?> VNĐ</div>
                        </div>

                        <div class="quantity-controls">
                            <form method="post" action="?act=capNhatGioHang" style="display: flex; align-items: center; gap: 10px;">
                                <input type="hidden" name="id_gio_hang" value="<?php echo $item['id']; ?>">
                                <input type="number" name="so_luong" value="<?php echo $item['so_luong']; ?>" 
                                       min="1" max="<?php echo $item['ton_kho']; ?>" class="quantity-input">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>

                        <div class="item-total">
                            <strong><?php echo number_format($thanhTien); ?> VNĐ</strong>
                        </div>

                        <form method="post" action="?act=xoaKhoiGioHang" style="margin-left: 10px;">
                            <input type="hidden" name="id_gio_hang" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                Xóa
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>

                <div class="cart-summary">
                    <!-- Form nhập mã giảm giá -->
                    <div class="discount-section">
                        <h4>Mã giảm giá</h4>
                        
                        <?php if (isset($maGiamGia)): ?>
                            <div class="applied-discount">
                                <strong>Mã đã áp dụng: <?php echo $maGiamGia['ma']; ?></strong><br>
                                Giảm: <?php echo number_format($maGiamGia['so_tien_giam']); ?> VNĐ 
                                (<?php echo $maGiamGia['phan_tram']; ?>%)
                                <form method="post" action="?act=xoaMaGiamGia" style="display: inline; margin-left: 10px;">
                                    <button type="submit" class="remove-discount-btn">Xóa</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <form method="post" action="?act=apDungMaGiamGia" class="discount-form">
                                <input type="text" name="ma_giam_gia" placeholder="Nhập mã giảm giá" class="discount-input">
                                <button type="submit" class="discount-btn">Áp dụng</button>
                            </form>
                        <?php endif; ?>
                    </div>

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
                                <div class="price-discount">Giảm giá: -<?php echo number_format($soTienGiam); ?> VNĐ</div>
                            <?php endif; ?>
                            <div class="price-total">
                                Tổng thanh toán: <?php echo number_format($tongTienSauGiam); ?> VNĐ
                            </div>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="?act=hienthi" class="btn btn-primary">Tiếp tục mua sắm</a>
                        <a href="?act=dathang" class="btn btn-primary">Đặt hàng</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 