<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm đơn hàng - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin/views/css/admin-style.css">
    <style>
        .search-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .search-form {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            backdrop-filter: blur(10px);
        }
        .result-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .result-card:hover {
            transform: translateY(-3px);
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-search text-primary"></i> Tìm kiếm đơn hàng</h2>
            <div>
                <a href="?act=ql_donhang" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <!-- Form tìm kiếm -->
        <div class="search-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-3">
                        <i class="bi bi-search"></i> 
                        Kết quả tìm kiếm cho: "<strong><?= htmlspecialchars($tuKhoa) ?></strong>"
                    </h4>
                    <p class="mb-0">Tìm thấy <strong><?= count($ketQuaTimKiem) ?></strong> đơn hàng phù hợp</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="?act=ql_donhang" class="btn btn-light">
                        <i class="bi bi-list-ul"></i> Xem tất cả đơn hàng
                    </a>
                </div>
            </div>
        </div>

        <!-- Bộ lọc bổ sung -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-funnel text-primary"></i> Bộ lọc bổ sung</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="" class="row g-3">
                    <input type="hidden" name="act" value="tim_kiem_don_hang">
                    <input type="hidden" name="tu_khoa" value="<?= htmlspecialchars($tuKhoa) ?>">
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            <?php foreach ($danhSachTrangThai as $key => $value): ?>
                                <option value="<?= $value ?>" <?= ($_GET['trang_thai'] ?? '') === $value ? 'selected' : '' ?>>
                                    <?= ucfirst($value) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Từ ngày</label>
                        <input type="date" name="ngay_bat_dau" class="form-control" value="<?= $_GET['ngay_bat_dau'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Đến ngày</label>
                        <input type="date" name="ngay_ket_thuc" class="form-control" value="<?= $_GET['ngay_ket_thuc'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                                                    <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel"></i> Lọc
                        </button>
                        <a href="?act=tim_kiem_don_hang&tu_khoa=<?= urlencode($tuKhoa) ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Xóa lọc
                        </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kết quả tìm kiếm -->
        <?php if (empty($ketQuaTimKiem)): ?>
            <div class="text-center py-5">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h4 class="text-muted">Không tìm thấy đơn hàng nào</h4>
                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
                <a href="?act=ql_donhang" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($ketQuaTimKiem as $donHang): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card result-card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="bi bi-cart text-primary"></i> 
                                    Đơn #<?= $donHang['id'] ?>
                                </h6>
                                                                 <?php
                                 $trangThaiClass = '';
                                 $trangThaiIcon = '';
                                 switch ($donHang['trang_thai']) {
                                     case 'chờ xử lý':
                                         $trangThaiClass = 'bg-warning';
                                         $trangThaiIcon = 'bi bi-clock';
                                         break;
                                     case 'đã xác nhận':
                                         $trangThaiClass = 'bg-primary';
                                         $trangThaiIcon = 'bi bi-check-circle-fill';
                                         break;
                                     case 'đang giao':
                                         $trangThaiClass = 'bg-info';
                                         $trangThaiIcon = 'bi bi-truck';
                                         break;
                                     case 'đã giao':
                                         $trangThaiClass = 'bg-success';
                                         $trangThaiIcon = 'bi bi-check-circle';
                                         break;
                                     case 'đã huỷ':
                                         $trangThaiClass = 'bg-danger';
                                         $trangThaiIcon = 'bi bi-x-circle';
                                         break;
                                 }
                                 ?>
                                <span class="badge <?= $trangThaiClass ?> status-badge">
                                    <i class="<?= $trangThaiIcon ?>"></i>
                                    <?= ucfirst($donHang['trang_thai']) ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="card-title">
                                        <i class="bi bi-person text-info"></i> 
                                        <?php 
                                        $ten = htmlspecialchars($donHang['ten_nguoi_dung']);
                                        echo str_replace($tuKhoa, '<span class="highlight">' . $tuKhoa . '</span>', $ten);
                                        ?>
                                    </h6>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            <i class="bi bi-envelope"></i> 
                                            <?php 
                                            $email = htmlspecialchars($donHang['email']);
                                            echo str_replace($tuKhoa, '<span class="highlight">' . $tuKhoa . '</span>', $email);
                                            ?>
                                        </small>
                                    </p>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            <i class="bi bi-telephone"></i> 
                                            <?= htmlspecialchars($donHang['so_dien_thoai']) ?>
                                        </small>
                                    </p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="mb-1">
                                        <strong>Ngày đặt:</strong><br>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($donHang['ngay'])) ?>
                                        </small>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Tổng tiền:</strong><br>
                                        <span class="text-success fw-bold fs-6">
                                            <?= number_format($donHang['tong_tien']) ?>đ
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-grid gap-2">
                                    <a href="?act=chi_tiet_don_hang&id=<?= $donHang['id'] ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Xem chi tiết
                                    </a>
                                    <?php if (in_array($donHang['trang_thai'], ['chờ xử lý', 'đã xác nhận', 'đang giao'])): ?>
                                        <button type="button" 
                                                class="btn btn-outline-success btn-sm"
                                                onclick="openUpdateStatusModal(<?= $donHang['id'] ?>, '<?= $donHang['trang_thai'] ?>')">
                                            <i class="bi bi-pencil"></i> Cập nhật trạng thái
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Phân trang (nếu cần) -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Phân trang kết quả tìm kiếm">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <span class="page-link">Hiển thị <?= count($ketQuaTimKiem) ?> kết quả</span>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
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
                        <input type="hidden" name="id_don_hang" id="updateOrderId">
                        <div class="mb-3">
                            <label class="form-label">Trạng thái mới</label>
                            <select name="trang_thai" class="form-select" required id="newStatusSelect">
                                <option value="">Chọn trạng thái</option>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openUpdateStatusModal(orderId, currentStatus) {
            document.getElementById('updateOrderId').value = orderId;
            
            // Cập nhật các option trạng thái có thể chọn
            updateStatusOptions(currentStatus);
            
            new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
        }
        
        function updateStatusOptions(currentStatus) {
            const select = document.getElementById('newStatusSelect');
            select.innerHTML = '<option value="">Chọn trạng thái</option>';
            
            if (currentStatus === 'chờ xử lý') {
                select.innerHTML += `
                    <option value="đã xác nhận">Đã xác nhận</option>
                    <option value="đã huỷ">Đã huỷ</option>
                `;
            } else if (currentStatus === 'đã xác nhận') {
                select.innerHTML += `
                    <option value="đang giao">Đang giao</option>
                    <option value="đã huỷ">Đã huỷ</option>
                `;
            } else if (currentStatus === 'đang giao') {
                select.innerHTML += `
                    <option value="đã giao">Đã giao</option>
                `;
            }
        }

        // Highlight từ khóa tìm kiếm trong trang
        document.addEventListener('DOMContentLoaded', function() {
            const keyword = '<?= addslashes($tuKhoa) ?>';
            if (keyword) {
                highlightKeyword(keyword);
            }
        });

        function highlightKeyword(keyword) {
            const walker = document.createTreeWalker(
                document.body,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );

            const textNodes = [];
            let node;
            while (node = walker.nextNode()) {
                textNodes.push(node);
            }

            textNodes.forEach(textNode => {
                const text = textNode.textContent;
                if (text.toLowerCase().includes(keyword.toLowerCase())) {
                    const highlightedText = text.replace(
                        new RegExp(keyword, 'gi'),
                        '<span class="highlight">$&</span>'
                    );
                    const span = document.createElement('span');
                    span.innerHTML = highlightedText;
                    textNode.parentNode.replaceChild(span, textNode);
                }
            });
        }
    </script>
</body>
</html>
