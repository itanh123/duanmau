<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Quần Áo - Trang chủ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
            margin-bottom: 50px;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
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
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
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
        .features-section {
            padding: 60px 0;
            background: white;
            margin: 50px 0;
        }
        .feature-card {
            text-align: center;
            padding: 30px 20px;
        }
        .feature-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 20px;
        }
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: #333;
            font-weight: bold;
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
                    <a class="nav-link" href="?act=hienthi">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?act=timKiemSanPham">Tìm kiếm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#lien-he">Liên hệ</a>
                </li>
            </ul>
            <ul class="navbar-nav">
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
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1>Chào mừng đến với Shop Quần Áo</h1>
        <p>Khám phá bộ sưu tập thời trang mới nhất với chất lượng cao và giá cả hợp lý</p>
        <a href="?act=dangky" class="btn btn-light btn-lg">
            <i class="bi bi-person-plus"></i> Đăng ký ngay
        </a>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <h2 class="section-title">Tại sao chọn chúng tôi?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4>Chất lượng cao</h4>
                    <p>Sản phẩm được làm từ chất liệu tốt nhất, đảm bảo độ bền và thoải mái</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4>Giao hàng nhanh</h4>
                    <p>Giao hàng toàn quốc với thời gian nhanh chóng và dịch vụ chăm sóc khách hàng tốt</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>Bảo hành uy tín</h4>
                    <p>Chính sách bảo hành và đổi trả rõ ràng, đảm bảo quyền lợi của khách hàng</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="san-pham" class="py-5">
    <div class="container">
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <div class="row">
            <?php foreach($sanpham as $item): ?>
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
                        <a href="?act=login" class="btn btn-outline-secondary">
                            <i class="bi bi-cart-plus"></i> Đăng nhập để mua
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Call to Action -->
        <div class="text-center mt-5">
            <h3>Bạn muốn mua sắm?</h3>
            <p class="text-muted">Đăng ký tài khoản để có thể thêm sản phẩm vào giỏ hàng và đặt hàng</p>
            <a href="?act=dangky" class="btn btn-register btn-lg text-white">
                <i class="bi bi-person-plus"></i> Đăng ký tài khoản ngay
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="lien-he" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Liên hệ với chúng tôi</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <p class="text-muted mb-4">Có câu hỏi? Hãy liên hệ với chúng tôi để được hỗ trợ tốt nhất</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <h5>Điện thoại</h5>
                            <p>0123 456 789</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <h5>Email</h5>
                            <p>info@shopquanao.com</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h5>Địa chỉ</h5>
                            <p>123 Đường ABC, Quận XYZ, TP.HCM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p>&copy; 2024 Shop Quần Áo. Tất cả quyền được bảo lưu.</p>
        <p>
            <a href="?act=dangky" class="text-white text-decoration-none">Đăng ký</a> | 
            <a href="?act=login" class="text-white text-decoration-none">Đăng nhập</a>
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
