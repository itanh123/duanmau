<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm - Shop Quần Áo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="views/css/customer-style.css">
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

        .products-container {
            max-width: 1200px;
            margin: 30px auto;
            padding-top: 80px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: none;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
        }

        .variant-info {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
            padding: 5px 10px;
            background: #f8f9fa;
            border-radius: 20px;
            display: inline-block;
        }

        .stock-info {
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .stock-available {
            color: #28a745;
        }

        .stock-low {
            color: #ffc107;
        }

        .stock-out {
            color: #dc3545;
        }

        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .welcome-banner h2 {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .welcome-banner p {
            margin-bottom: 0;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="?act=/">
                <i class="bi bi-shop"></i> Shop Quần Áo
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=hienthi">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=timKiemSanPham">Tìm kiếm</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=xemGioHang">
                            <i class="bi bi-cart"></i> Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="?act=danhSachDonHang">Đơn hàng</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Xin chào, <?= htmlspecialchars($_SESSION['ten']) ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=logout">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="products-container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h2><i class="bi bi-person-check"></i> Chào mừng bạn đã đăng nhập!</h2>
            <p>Bây giờ bạn có thể xem chi tiết sản phẩm, thêm vào giỏ hàng và đặt hàng</p>
        </div>

        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($sanpham as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($item['hinh_anh']) ?>" alt="<?= htmlspecialchars($item['ten']) ?>">
                        <h5 class="product-title"><?= htmlspecialchars($item['ten']) ?></h5>
                        <div class="product-price"><?= number_format($item['gia']) ?> VNĐ</div>

                        <div class="variant-info">
                            <i class="bi bi-palette"></i> <?= htmlspecialchars($item['mau_sac']) ?> |
                            <i class="bi bi-arrows-expand"></i> <?= htmlspecialchars($item['kich_thuoc']) ?>
                        </div>

                        <div class="stock-info">
                            <?php if ($item['so_luong'] > 10): ?>
                                <span class="stock-available">
                                    <i class="bi bi-check-circle"></i> Còn lại: <?= $item['so_luong'] ?> sản phẩm
                                </span>
                            <?php elseif ($item['so_luong'] > 0): ?>
                                <span class="stock-low">
                                    <i class="bi bi-exclamation-triangle"></i> Chỉ còn: <?= $item['so_luong'] ?> sản phẩm
                                </span>
                            <?php else: ?>
                                <span class="stock-out">
                                    <i class="bi bi-x-circle"></i> Hết hàng
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="?act=xemSanPham&id=<?= $item['id_san_pham'] ?>" class="btn btn-outline-primary">
                                <i class="bi bi-eye"></i> Xem chi tiết
                            </a>
                            <?php if ($item['so_luong'] > 0): ?>
                                <form method="post" action="?act=themvaogio">
                                    <input type="hidden" name="id_bien_the" value="<?= $item['id_bien_the'] ?>">
                                    <input type="hidden" name="redirect_url" value="?act=hienthi">
                                    <input type="hidden" name="so_luong" value="1">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </form>

                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>
                                    <i class="bi bi-x-circle"></i> Hết hàng
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="?act=home" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại trang chủ
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>