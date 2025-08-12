<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?= $donHang['id'] ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .order-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }
        .product-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .status-badge {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }
        .customer-info {
            background: #e3f2fd;
            border-radius: 8px;
            padding: 20px;
        }
        .order-summary {
            background: #f3e5f5;
            border-radius: 8px;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-file-invoice text-primary"></i> 
                Chi tiết đơn hàng #<?= $donHang['id'] ?>
            </h2>
            <div>
                <a href="?act=ql_donhang" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="fas fa-print"></i> In đơn hàng
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Thông tin đơn hàng -->
            <div class="col-md-8">
                <div class="order-info mb-4">
                    <h5><i class="fas fa-info-circle text-primary"></i> Thông tin đơn hàng</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn hàng:</strong> #<?= $donHang['id'] ?></p>
                            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($donHang['ngay'])) ?></p>
                            <p><strong>Trạng thái:</strong> 
                                <?php
                                $trangThaiClass = '';
                                $trangThaiIcon = '';
                                switch ($donHang['trang_thai']) {
                                    case 'chờ xử lý':
                                        $trangThaiClass = 'bg-warning';
                                        $trangThaiIcon = 'fas fa-clock';
                                        break;
                                    case 'đang giao':
                                        $trangThaiClass = 'bg-info';
                                        $trangThaiIcon = 'fas fa-truck';
                                        break;
                                    case 'đã giao':
                                        $trangThaiClass = 'bg-success';
                                        $trangThaiIcon = 'fas fa-check-circle';
                                        break;
                                    case 'đã huỷ':
                                        $trangThaiClass = 'bg-danger';
                                        $trangThaiIcon = 'fas fa-times-circle';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $trangThaiClass ?> status-badge">
                                    <i class="<?= $trangThaiIcon ?>"></i>
                                    <?= ucfirst($donHang['trang_thai']) ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tổng tiền:</strong> 
                                <span class="text-success fw-bold fs-5"><?= number_format($donHang['tong_tien']) ?>đ</span>
                            </p>
                            <?php if ($donHang['ngay_cap_nhat']): ?>
                                <p><strong>Ngày cập nhật:</strong> <?= date('d/m/Y', strtotime($donHang['ngay_cap_nhat'])) ?></p>
                            <?php endif; ?>
                            <?php if ($donHang['ghi_chu']): ?>
                                <p><strong>Ghi chú:</strong> <?= htmlspecialchars($donHang['ghi_chu']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-boxes text-primary"></i> 
                            Sản phẩm trong đơn hàng
                            <span class="badge bg-primary ms-2"><?= count($donHang['chi_tiet']) ?> sản phẩm</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($donHang['chi_tiet'])): ?>
                            <p class="text-muted text-center">Không có sản phẩm nào</p>
                        <?php else: ?>
                            <?php foreach ($donHang['chi_tiet'] as $item): ?>
                                <div class="product-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <?php if ($item['hinh_anh']): ?>
                                                <img src="<?= BASE_URL . $item['hinh_anh'] ?>" 
                                                     alt="<?= htmlspecialchars($item['ten_san_pham']) ?>" 
                                                     class="product-image">
                                            <?php else: ?>
                                                <div class="product-image bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-white"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-1"><?= htmlspecialchars($item['ten_san_pham']) ?></h6>
                                            <p class="mb-1 text-muted">
                                                <small>
                                                    Màu: <span class="badge bg-light text-dark"><?= htmlspecialchars($item['mau_sac']) ?></span>
                                                    Kích thước: <span class="badge bg-light text-dark"><?= htmlspecialchars($item['kich_thuoc']) ?></span>
                                                </small>
                                            </p>
                                            <p class="mb-0">
                                                <strong>Số lượng:</strong> <?= $item['so_luong'] ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <p class="mb-0">
                                                <strong>Đơn giá:</strong> <?= number_format($item['gia']) ?>đ
                                            </p>
                                            <p class="mb-0">
                                                <strong>Thành tiền:</strong> 
                                                <span class="text-success fw-bold"><?= number_format($item['gia'] * $item['so_luong']) ?>đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Thông tin khách hàng -->
                <div class="customer-info mb-4">
                    <h5><i class="fas fa-user text-primary"></i> Thông tin khách hàng</h5>
                    <p><strong>Họ tên:</strong> <?= htmlspecialchars($donHang['ten_nguoi_dung']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($donHang['email']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($donHang['so_dien_thoai']) ?></p>
                    <?php if ($donHang['dia_chi']): ?>
                        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($donHang['dia_chi']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Tóm tắt đơn hàng -->
                <div class="order-summary mb-4">
                    <h5><i class="fas fa-calculator text-primary"></i> Tóm tắt đơn hàng</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tổng tiền hàng:</span>
                        <span><?= number_format($donHang['tong_tien']) ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span>0đ</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Tổng cộng:</span>
                        <span class="text-success"><?= number_format($donHang['tong_tien']) ?>đ</span>
                    </div>
                </div>

                <!-- Thao tác -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-tools text-primary"></i> Thao tác</h6>
                    </div>
                    <div class="card-body">
                        <?php if ($donHang['trang_thai'] === 'chờ xử lý'): ?>
                            <button type="button" class="btn btn-success w-100 mb-2" 
                                    onclick="openUpdateStatusModal(<?= $donHang['id'] ?>)">
                                <i class="fas fa-edit"></i> Cập nhật trạng thái
                            </button>
                        <?php endif; ?>
                        
                        <?php if (in_array($donHang['trang_thai'], ['chờ xử lý', 'đang giao'])): ?>
                            <button type="button" class="btn btn-danger w-100 mb-2" 
                                    onclick="openCancelOrderModal(<?= $donHang['id'] ?>)">
                                <i class="fas fa-times"></i> Hủy đơn hàng
                            </button>
                        <?php endif; ?>
                        
                        <a href="?act=ql_donhang" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật trạng thái -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="?act=cap_nhat_trang_thai_don_hang" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_don_hang" value="<?= $donHang['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Trạng thái mới</label>
                            <select name="trang_thai" class="form-select" required>
                                <option value="">Chọn trạng thái</option>
                                <option value="đang giao">Đang giao</option>
                                <option value="đã giao">Đã giao</option>
                                <option value="đã huỷ">Đã huỷ</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="ghi_chu" class="form-control" rows="3" placeholder="Ghi chú (không bắt buộc)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal hủy đơn hàng -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hủy đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="?act=huy_don_hang" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_don_hang" value="<?= $donHang['id'] ?>">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Lưu ý:</strong> Khi hủy đơn hàng, số lượng sản phẩm sẽ được hoàn trả về kho.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lý do hủy</label>
                            <textarea name="ly_do_huy" class="form-control" rows="3" placeholder="Nhập lý do hủy đơn hàng" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openUpdateStatusModal(orderId) {
            new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
        }

        function openCancelOrderModal(orderId) {
            new bootstrap.Modal(document.getElementById('cancelOrderModal')).show();
        }
    </script>
</body>
</html>
