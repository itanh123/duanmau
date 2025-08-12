<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .search-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .product-card {
            transition: transform 0.2s;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        .price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.2em;
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
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="?act=home">Shop MVC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=home">Trang chủ</a>
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
                                <i class="fas fa-shopping-cart"></i> Giỏ hàng
                                <?php if (count($gioHang) > 0): ?>
                                    <span class="badge bg-danger"><?= count($gioHang) ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=danhSachDonHang">Đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?act=logout">Đăng xuất (<?= $_SESSION['ten'] ?>)</a>
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

    <div class="container mt-4">
        <!-- Form tìm kiếm -->
        <div class="search-form">
            <h3 class="mb-3"><i class="fas fa-search"></i> Tìm kiếm sản phẩm</h3>
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
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <a href="?act=timKiemSanPham" class="btn btn-secondary">
                            <i class="fas fa-refresh"></i> Làm mới
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Kết quả tìm kiếm -->
        <div class="search-results">
            <?php if (isset($tuKhoa) || isset($giaMin) || isset($giaMax) || isset($mauSac)): ?>
                <h4>Kết quả tìm kiếm</h4>
                <?php if (empty($sanpham)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Không tìm thấy sản phẩm nào phù hợp với tiêu chí tìm kiếm.
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
                            <div class="card product-card h-100">
                                <img src="<?= BASE_URL . '/' . $sp['hinh_anh'] ?>" 
                                     class="card-img-top product-image" 
                                     alt="<?= htmlspecialchars($sp['ten']) ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($sp['ten']) ?></h5>
                                    <p class="card-text text-muted"><?= htmlspecialchars($sp['mo_ta']) ?></p>
                                    <div class="mt-auto">
                                        <p class="price"><?= number_format($sp['gia']) ?> VNĐ</p>
                                        
                                        <!-- Hiển thị biến thể sản phẩm -->
                                        <div class="mb-3">
                                            <small class="text-muted">Màu sắc và kích thước:</small>
                                            <?php
                                            $bienTheCuaSanPham = array_filter($sanpham, function($item) use ($sp) {
                                                return $item['id_san_pham'] === $sp['id_san_pham'];
                                            });
                                            ?>
                                            <div class="d-flex flex-wrap gap-1 mt-1">
                                                <?php foreach ($bienTheCuaSanPham as $bt): ?>
                                                    <span class="badge bg-light text-dark">
                                                        <?= htmlspecialchars($bt['mau_sac']) ?> - <?= htmlspecialchars($bt['kich_thuoc']) ?>
                                                        (<?= $bt['so_luong'] ?>)
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <a href="?act=xemSanPham&id=<?= $sp['id_san_pham'] ?>" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </a>
                                        <?php else: ?>
                                            <a href="?act=login" class="btn btn-warning btn-sm">
                                                <i class="fas fa-sign-in-alt"></i> Đăng nhập để mua
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
