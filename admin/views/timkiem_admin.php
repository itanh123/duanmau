<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm sản phẩm - Admin</title>
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
            height: 150px;
            object-fit: cover;
        }
        .price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.1em;
        }
        .search-results {
            margin-top: 20px;
        }
        .admin-actions {
            margin-top: 10px;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="?act=home">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=quanLyBienThe">Quản lý biến thể</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=quanLyDonHang">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=quanLyNguoiDung">Quản lý người dùng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="?act=timKiemSanPham">Tìm kiếm</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/?act=logout">Đăng xuất</a>
                    </li>
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

            <!-- Hiển thị sản phẩm dạng bảng cho admin -->
            <?php if (!empty($sanpham)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Biến thể</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sanPhamDaHienThi = [];
                            foreach ($sanpham as $sp): 
                                // Tránh hiển thị trùng lặp sản phẩm
                                if (in_array($sp['id'], $sanPhamDaHienThi)) continue;
                                $sanPhamDaHienThi[] = $sp['id'];
                            ?>
                                <tr>
                                    <td><?= $sp['id'] ?></td>
                                    <td>
                                        <?php if (!empty($sp['hinh_anh'])): ?>
                                            <img src="<?= BASE_URL . '/' . $sp['hinh_anh'] ?>" 
                                                 class="product-image" 
                                                 alt="<?= htmlspecialchars($sp['ten']) ?>"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light text-center p-2" style="width: 80px; height: 80px; line-height: 76px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($sp['ten']) ?></strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= htmlspecialchars(substr($sp['mo_ta'], 0, 100)) ?>
                                            <?= strlen($sp['mo_ta']) > 100 ? '...' : '' ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="price"><?= number_format($sp['gia']) ?> VNĐ</span>
                                    </td>
                                    <td>
                                        <?php
                                        $bienTheCuaSanPham = array_filter($sanpham, function($item) use ($sp) {
                                            return $item['id'] === $sp['id'];
                                        });
                                        ?>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php foreach ($bienTheCuaSanPham as $bt): ?>
                                                <span class="badge bg-info">
                                                    <?= htmlspecialchars($bt['mau_sac']) ?> - <?= htmlspecialchars($bt['kich_thuoc']) ?>
                                                    (<?= $bt['so_luong'] ?>)
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="?act=sua&id=<?= $sp['id'] ?>" 
                                               class="btn btn-warning btn-sm mb-1">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="?act=quanLyBienThe" 
                                               class="btn btn-info btn-sm mb-1">
                                                <i class="fas fa-cogs"></i> Biến thể
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm mb-1"
                                                    onclick="confirmDelete(<?= $sp['id'] ?>)">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                window.location.href = '?act=xoa&id=' + id;
            }
        }
    </script>
</body>
</html>
