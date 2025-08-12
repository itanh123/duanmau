<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #333 !important;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #007bff !important;
        }

        .product-container {
            max-width: 1200px;
            margin: 30px auto;
            padding-top: 80px;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .product-header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .product-content {
            padding: 30px;
        }

        .product-image {
            max-width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            padding: 20px;
        }

        .product-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .product-price {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .product-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .variants-section {
            margin-bottom: 30px;
        }

        .variant-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background: #f8f9fa;
        }

        .variant-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .stock-info {
            font-size: 14px;
            color: #28a745;
            font-weight: bold;
        }

        .out-of-stock {
            color: #dc3545;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-input {
            width: 80px;
            text-align: center;
        }

        .alert {
            margin-bottom: 20px;
        }

        .back-link {
            margin-top: 20px;
        }

        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="?act=home">
                <i class="bi bi-shop"></i> Shop Quần Áo
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=hienthi">Sản phẩm</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=hienthi">
                                <i class="bi bi-grid"></i> Xem sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=xemGioHang">
                                <i class="bi bi-cart"></i> Giỏ hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Xin chào, <?= htmlspecialchars($_SESSION['ten']) ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=logout">Đăng xuất</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=login">
                                <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-register text-white" href="?act=dangky">
                                <i class="bi bi-person-plus"></i> Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="product-container">
        <div class="product-card">
            <div class="product-header">
                <h2>Chi tiết sản phẩm</h2>
            </div>

            <div class="product-content">
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

                <?php if ($sanpham && count($sanpham) > 0): ?>
                    <?php
                    $product = $sanpham[0]; // Lấy thông tin sản phẩm từ phần tử đầu tiên
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <img src="<?= htmlspecialchars($product['hinh_anh']) ?>" alt="<?= htmlspecialchars($product['ten']) ?>" class="product-image">
                        </div>
                        <div class="col-md-6">
                            <div class="product-info">
                                <h1 class="product-title"><?= htmlspecialchars($product['ten']) ?></h1>
                                <div class="product-price"><?= number_format($product['gia']) ?> VNĐ</div>
                                <div class="product-description"><?= htmlspecialchars($product['mo_ta']) ?></div>

                                <div class="variants-section">
                                    <h4>Biến thể sản phẩm</h4>
                                    <?php foreach ($sanpham as $variant): ?>
                                        <div class="variant-item">
                                            <div class="variant-info">
                                                <div>
                                                    <strong>Màu:</strong> <?= htmlspecialchars($variant['mau_sac']) ?> |
                                                    <strong>Kích thước:</strong> <?= htmlspecialchars($variant['kich_thuoc']) ?>
                                                </div>
                                                <div class="stock-info <?= $variant['so_luong'] <= 0 ? 'out-of-stock' : '' ?>">
                                                    <?= $variant['so_luong'] > 0 ? 'Còn lại: ' . $variant['so_luong'] . ' sản phẩm' : 'Hết hàng' ?>
                                                </div>
                                            </div>

                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <?php if ($variant['so_luong'] > 0): ?>
                                                    <form method="post" action="?act=themvaogio" class="quantity-controls">
                                                        <input type="hidden" name="id_bien_the" value="<?= $variant['id'] ?>">
                                                        <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                        <label>Số lượng:</label>
                                                        <input type="number" name="so_luong" value="1" min="1" max="<?= $variant['so_luong'] ?>"
                                                            class="form-control quantity-input">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="btn btn-secondary" disabled>Hết hàng</button>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="d-grid gap-2">
                                                    <a href="?act=login" class="btn btn-outline-primary">
                                                        <i class="bi bi-box-arrow-in-right"></i> Đăng nhập để mua
                                                    </a>
                                                    <a href="?act=dangky" class="btn btn-register text-white">
                                                        <i class="bi bi-person-plus"></i> Đăng ký tài khoản
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center">
                        <h3>Sản phẩm không tồn tại</h3>
                        <p>Không tìm thấy thông tin sản phẩm.</p>
                    </div>
                <?php endif; ?>

                <div class="back-link text-center">
                    <a href="?act=/" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>