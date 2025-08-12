<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm sản phẩm - Shop Quần Áo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="views/css/customer-style.css">
    <style>
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
        .search-container {
            max-width: 1200px;
            margin: 30px auto;
            padding-top: 80px;
        }
        .search-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .search-form h3 {
            color: #2c3e50;
            margin-bottom: 25px;
        }
        .product-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
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
        .search-results {
            margin-top: 20px;
        }
        .filter-section {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .btn-search {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="?act=/">Shop Quần Áo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=hienthi">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="?act=timKiemSanPham">Tìm kiếm</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=xemGioHang">
                                <i class="bi bi-cart"></i> Giỏ hàng
                                <?php if (count($gioHang) > 0): ?>
                                    <span class="badge bg-danger"><?= count($gioHang) ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=danhSachDonHang">Đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=logout">Đăng xuất (<?= $_SESSION['ten'] ?? 'User' ?>)</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=dangky">Đăng ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="search-container">
        <!-- Form tìm kiếm -->
        <div class="search-form">
            <h3><i class="bi bi-search"></i> Tìm kiếm sản phẩm</h3>
            <form method="GET" action="?act=timKiemSanPham">
                <div class="row">
                    <div class="col-md-3">
                        <label for="tu_khoa" class="form-label">Từ khóa</label>
                        <input type="text" class="form-control" id="tu_khoa" name="tu_khoa" 
                               value="<?= htmlspecialchars($tuKhoa ?? '') ?>" 
                               placeholder="Tên sản phẩm, mô tả...">
                    </div>
                    <div class="col-md-2">
                        <label for="gia_min" class="form-label">Giá từ</label>
                        <input type="number" class="form-control" id="gia_min" name="gia_min" 
                               value="<?= htmlspecialchars($giaMin ?? '') ?>" 
                               placeholder="VNĐ" min="0">
                    </div>
                    <div class="col-md-2">
                        <label for="gia_max" class="form-label">Giá đến</label>
                        <input type="number" class="form-control" id="gia_max" name="gia_max" 
                               value="<?= htmlspecialchars($giaMax ?? '') ?>" 
                               placeholder="VNĐ" min="0">
                    </div>
                    <div class="col-md-2">
                        <label for="mau_sac" class="form-label">Màu sắc</label>
                        <select class="form-select" id="mau_sac" name="mau_sac">
                            <option value="">Tất cả màu</option>
                            <?php foreach ($danhSachMauSac as $mau): ?>
                                <option value="<?= htmlspecialchars($mau) ?>" 
                                        <?= ($mauSac === $mau) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($mau) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-search me-2">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                        <a href="?act=timKiemSanPham" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Làm mới
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Kết quả tìm kiếm -->
        <div class="search-results">
            <?php if (isset($tuKhoa) || isset($giaMin) || isset($giaMax) || isset($mauSac)): ?>
                <h4><i class="bi bi-list-ul"></i> Kết quả tìm kiếm</h4>
                <?php if (empty($sanpham)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Không tìm thấy sản phẩm nào phù hợp với tiêu chí tìm kiếm.
                    </div>
                <?php else: ?>
                    <p class="text-muted">Tìm thấy <?= count($sanpham) ?> sản phẩm</p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Hiển thị sản phẩm -->
            <?php if (!empty($sanpham)): ?>
                <div class="row">
                    <?php 
                    $sanPhamDaHienThi = [];
                    foreach ($sanpham as $sp): 
                        // Tránh hiển thị trùng lặp sản phẩm
                        if (in_array($sp['id_san_pham'], $sanPhamDaHienThi)) continue;
                        $sanPhamDaHienThi[] = $sp['id_san_pham'];
                    ?>
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="product-card">
                                <img src="<?= BASE_URL . '/' . $sp['hinh_anh'] ?>" 
                                     alt="<?= htmlspecialchars($sp['ten']) ?>">
                                <div class="product-title"><?= htmlspecialchars($sp['ten']) ?></div>
                                <div class="product-price"><?= number_format($sp['gia']) ?> VNĐ</div>
                                
                                <!-- Hiển thị biến thể sản phẩm -->
                                <div class="mb-3">
                                    <?php
                                    $bienTheCuaSanPham = array_filter($sanpham, function($item) use ($sp) {
                                        return $item['id_san_pham'] === $sp['id_san_pham'];
                                    });
                                    ?>
                                    <div class="d-flex flex-wrap gap-1 justify-content-center">
                                        <?php foreach ($bienTheCuaSanPham as $bt): ?>
                                            <span class="variant-info">
                                                <?= htmlspecialchars($bt['mau_sac']) ?> - <?= htmlspecialchars($bt['kich_thuoc']) ?>
                                                (<?= $bt['so_luong'] ?>)
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="?act=xemSanPham&id=<?= $sp['id_san_pham'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i> Xem chi tiết
                                    </a>
                                <?php else: ?>
                                    <a href="?act=login" class="btn btn-warning btn-sm">
                                        <i class="bi bi-box-arrow-in-right"></i> Đăng nhập để mua
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
