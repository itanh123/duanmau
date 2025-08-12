<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="views/css/customer-style.css">
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
                        <a href="?act=hienthi" class="btn btn-primary">
                            <i class="bi bi-cart-plus"></i> Bắt đầu mua sắm
                        </a>
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
                                            <i class="bi bi-eye"></i> Xem chi tiết
                                        </a>
                                        <a href="?act=xemTrangThaiDonHang&id=<?php echo $donHang['id']; ?>" 
                                           class="btn btn-outline-info btn-sm ms-2">
                                            <i class="bi bi-info-circle"></i> Trạng thái
                                        </a>
                                        <?php if ($donHang['trang_thai'] === 'chờ xử lý' || $donHang['trang_thai'] === 'đang giao'): ?>
                                            <button type="button" class="btn btn-outline-danger btn-sm ms-2" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#huyDonHangModal<?php echo $donHang['id']; ?>">
                                                <i class="bi bi-x-circle"></i> Hủy đơn hàng
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <div class="text-center mt-4">
                    <a href="?act=hienthi" class="btn btn-primary">
                        <i class="bi bi-cart-plus"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal hủy đơn hàng -->
    <?php foreach ($danhSachDonHang as $donHang): ?>
        <?php if ($donHang['trang_thai'] === 'chờ xử lý' || $donHang['trang_thai'] === 'đang giao'): ?>
            <div class="modal fade" id="huyDonHangModal<?php echo $donHang['id']; ?>" tabindex="-1" aria-labelledby="huyDonHangModalLabel<?php echo $donHang['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="huyDonHangModalLabel<?php echo $donHang['id']; ?>">
                                Xác nhận hủy đơn hàng #<?php echo $donHang['id']; ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="?act=huyDonHang">
                            <div class="modal-body">
                                <input type="hidden" name="id_don_hang" value="<?php echo $donHang['id']; ?>">
                                
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <strong>Lưu ý:</strong> Bạn có chắc chắn muốn hủy đơn hàng này không? 
                                    Hành động này không thể hoàn tác.
                                </div>
                                
                                <div class="mb-3">
                                    <label for="ly_do_huy<?php echo $donHang['id']; ?>" class="form-label">Lý do hủy đơn hàng:</label>
                                    <textarea class="form-control" id="ly_do_huy<?php echo $donHang['id']; ?>" 
                                              name="ly_do_huy" rows="3" 
                                              placeholder="Vui lòng cho biết lý do hủy đơn hàng..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                <button type="submit" class="btn btn-danger">Xác nhận hủy đơn hàng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 