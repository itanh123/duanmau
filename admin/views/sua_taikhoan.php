<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa tài khoản - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin/views/css/admin-style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-card {
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            border: none;
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 25px;
        }
        .form-body {
            padding: 30px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .user-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .password-section {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            background: #f8f9fa;
        }
        .password-section h6 {
            color: #6c757d;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="form-container">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2><i class="bi bi-person-gear"></i> Sửa tài khoản người dùng</h2>
                <p class="text-muted">Cập nhật thông tin tài khoản và phân quyền</p>
            </div>

            <!-- Thông tin người dùng hiện tại -->
            <div class="user-info">
                <h6><i class="bi bi-info-circle"></i> Thông tin hiện tại:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tên:</strong> <?= htmlspecialchars($nguoidung['ten'] ?? '') ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong> <?= htmlspecialchars($nguoidung['email'] ?? '') ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong>Vai trò:</strong> 
                        <span class="badge <?= ($nguoidung['vai_tro'] ?? '') === 'admin' ? 'bg-danger' : 'bg-secondary' ?>">
                            <?= ($nguoidung['vai_tro'] ?? '') === 'admin' ? 'Admin' : 'User' ?>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>ID:</strong> #<?= $nguoidung['id'] ?? '' ?>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="card form-card">
                <div class="form-header text-center">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Cập nhật thông tin</h4>
                </div>
                <div class="form-body">
                    <form method="POST" id="editUserForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ten" class="form-label">
                                    <i class="bi bi-person"></i> Họ và tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="ten" 
                                       name="ten" 
                                       required 
                                       placeholder="Nhập họ và tên"
                                       value="<?= htmlspecialchars($nguoidung['ten'] ?? '') ?>">
                                <div class="form-text">Tên hiển thị của người dùng</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       required 
                                       placeholder="example@email.com"
                                       value="<?= htmlspecialchars($nguoidung['email'] ?? '') ?>">
                                <div class="form-text">Email đăng nhập của người dùng</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vai_tro" class="form-label">
                                    <i class="bi bi-shield-check"></i> Vai trò <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="vai_tro" name="vai_tro" required>
                                    <option value="user" <?= ($nguoidung['vai_tro'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= ($nguoidung['vai_tro'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                                <div class="form-text">Phân quyền truy cập hệ thống</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="trang_thai" class="form-label">
                                    <i class="bi bi-toggle-on"></i> Trạng thái
                                </label>
                                <select class="form-select" id="trang_thai" name="trang_thai">
                                    <option value="active" <?= ($nguoidung['trang_thai'] ?? 'active') === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="inactive" <?= ($nguoidung['trang_thai'] ?? 'active') === 'inactive' ? 'selected' : '' ?>>Tạm khóa</option>
                                </select>
                                <div class="form-text">Trạng thái tài khoản</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dia_chi" class="form-label">
                                    <i class="bi bi-geo-alt"></i> Địa chỉ
                                </label>
                                <textarea class="form-control" 
                                          id="dia_chi" 
                                          name="dia_chi" 
                                          rows="3"
                                          placeholder="Nhập địa chỉ"><?= htmlspecialchars($nguoidung['dia_chi'] ?? '') ?></textarea>
                                <div class="form-text">Địa chỉ giao hàng của người dùng</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="so_dien_thoai" class="form-label">
                                    <i class="bi bi-telephone"></i> Số điện thoại
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="so_dien_thoai" 
                                       name="so_dien_thoai" 
                                       placeholder="Nhập số điện thoại"
                                       value="<?= htmlspecialchars($nguoidung['so_dien_thoai'] ?? '') ?>">
                                <div class="form-text">Số điện thoại liên lạc</div>
                            </div>
                        </div>

                        <!-- Phần mật khẩu -->
                        <div class="password-section">
                            <h6><i class="bi bi-lock"></i> Thay đổi mật khẩu</h6>
                            <p class="text-muted small">Để trống nếu không muốn thay đổi mật khẩu</p>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mat_khau_moi" class="form-label">
                                        <i class="bi bi-key"></i> Mật khẩu mới
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="mat_khau_moi" 
                                               name="mat_khau_moi" 
                                               placeholder="Nhập mật khẩu mới">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('mat_khau_moi')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Tối thiểu 6 ký tự</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="xac_nhan_mat_khau" class="form-label">
                                        <i class="bi bi-key-fill"></i> Xác nhận mật khẩu
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="xac_nhan_mat_khau" 
                                               name="xac_nhan_mat_khau" 
                                               placeholder="Nhập lại mật khẩu mới">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('xac_nhan_mat_khau')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Nhập lại mật khẩu mới</div>
                                </div>
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="?act=ql_nguoidung" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="bi bi-check-circle"></i> Cập nhật tài khoản
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle hiển thị mật khẩu
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Validate form
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            const matKhauMoi = document.getElementById('mat_khau_moi').value;
            const xacNhanMatKhau = document.getElementById('xac_nhan_mat_khau').value;
            
            if (matKhauMoi || xacNhanMatKhau) {
                if (matKhauMoi.length < 6) {
                    e.preventDefault();
                    alert('Mật khẩu mới phải có ít nhất 6 ký tự!');
                    return;
                }
                
                if (matKhauMoi !== xacNhanMatKhau) {
                    e.preventDefault();
                    alert('Mật khẩu xác nhận không khớp!');
                    return;
                }
            }
        });
    </script>
</body>
</html> 