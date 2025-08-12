<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin người dùng - Admin Dashboard</title>
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
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #333;
            border-radius: 15px 15px 0 0;
            padding: 25px;
        }
        .form-body {
            padding: 30px;
        }
        .form-control:focus {
            border-color: #ff9a9e;
            box-shadow: 0 0 0 0.2rem rgba(255, 154, 158, 0.25);
        }
        .btn-submit {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            color: #333;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 154, 158, 0.4);
            color: #333;
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
                <h2><i class="bi bi-person-gear"></i> Sửa thông tin người dùng</h2>
                <p class="text-muted">Cập nhật thông tin tài khoản người dùng</p>
            </div>

            <!-- Thông tin người dùng hiện tại -->
            <div class="user-info">
                <h6><i class="bi bi-info-circle"></i> Thông tin hiện tại:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tên:</strong> <?= htmlspecialchars($nguoiDung['ten']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong> <?= htmlspecialchars($nguoiDung['email']) ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong>Vai trò:</strong> 
                        <span class="badge <?= $nguoiDung['vai_tro'] === 'admin' ? 'bg-danger' : 'bg-secondary' ?>">
                            <?= $nguoiDung['vai_tro'] === 'admin' ? 'Admin' : 'User' ?>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>ID:</strong> #<?= $nguoiDung['id'] ?>
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
                                       value="<?= htmlspecialchars($nguoiDung['ten']) ?>">
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
                                       value="<?= htmlspecialchars($nguoiDung['email']) ?>">
                                <div class="form-text">Email đăng nhập của người dùng</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vai_tro" class="form-label">
                                    <i class="bi bi-shield"></i> Vai trò
                                </label>
                                <select class="form-select" id="vai_tro" name="vai_tro">
                                    <option value="user" <?= $nguoiDung['vai_tro'] === 'user' ? 'selected' : '' ?>>
                                        <i class="bi bi-person"></i> Người dùng thường
                                    </option>
                                    <option value="admin" <?= $nguoiDung['vai_tro'] === 'admin' ? 'selected' : '' ?>>
                                        <i class="bi bi-shield-check"></i> Quản trị viên
                                    </option>
                                </select>
                                <div class="form-text">Phân quyền truy cập hệ thống</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="dia_chi" class="form-label">
                                    <i class="bi bi-geo-alt"></i> Địa chỉ
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="dia_chi" 
                                       name="dia_chi"
                                       placeholder="Nhập địa chỉ"
                                       value="<?= htmlspecialchars($nguoiDung['dia_chi'] ?? '') ?>">
                                <div class="form-text">Địa chỉ của người dùng</div>
                            </div>
                        </div>

                        <!-- Phần mật khẩu (tùy chọn) -->
                        <div class="password-section">
                            <h6><i class="bi bi-lock"></i> Thay đổi mật khẩu (tùy chọn)</h6>
                            <p class="text-muted small">Để giữ nguyên mật khẩu hiện tại, hãy để trống các trường bên dưới</p>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mat_khau" class="form-label">
                                        <i class="bi bi-lock"></i> Mật khẩu mới
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="mat_khau" 
                                               name="mat_khau" 
                                               placeholder="Để trống nếu không đổi"
                                               minlength="6">
                                        <button class="btn btn-outline-secondary" 
                                                type="button" 
                                                id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Mật khẩu tối thiểu 6 ký tự</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="xac_nhan_mat_khau" class="form-label">
                                        <i class="bi bi-lock-fill"></i> Xác nhận mật khẩu mới
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="xac_nhan_mat_khau" 
                                           name="xac_nhan_mat_khau" 
                                           placeholder="Nhập lại mật khẩu mới">
                                    <div class="form-text">Nhập lại mật khẩu để xác nhận</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="?act=ql_nguoidung" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-check-circle"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6><i class="bi bi-info-circle"></i> Lưu ý:</h6>
                    <ul class="mb-0">
                        <li>Email phải là duy nhất trong hệ thống</li>
                        <li>Nếu không nhập mật khẩu mới, mật khẩu cũ sẽ được giữ nguyên</li>
                        <li>Thay đổi vai trò sẽ ảnh hưởng đến quyền truy cập</li>
                        <li>Không thể xóa tài khoản admin cuối cùng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('mat_khau');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Form validation
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('mat_khau').value;
            const confirmPassword = document.getElementById('xac_nhan_mat_khau').value;
            
            // Nếu có nhập mật khẩu mới thì phải xác nhận
            if (password && password !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                return false;
            }
            
            // Nếu có nhập mật khẩu mới thì phải đủ độ dài
            if (password && password.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 6 ký tự!');
                return false;
            }
        });
    </script>
</body>
</html>
