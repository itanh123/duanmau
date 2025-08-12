<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm người dùng mới - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="form-container">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2><i class="bi bi-person-plus-fill"></i> Thêm người dùng mới</h2>
                <p class="text-muted">Tạo tài khoản mới cho người dùng hệ thống</p>
            </div>

            <!-- Form -->
            <div class="card form-card">
                <div class="form-header text-center">
                    <h4 class="mb-0"><i class="bi bi-user-plus"></i> Thông tin người dùng</h4>
                </div>
                <div class="form-body">
                    <form method="POST" id="addUserForm">
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
                                       value="<?= $_POST['ten'] ?? '' ?>">
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
                                       value="<?= $_POST['email'] ?? '' ?>">
                                <div class="form-text">Email đăng nhập của người dùng</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mat_khau" class="form-label">
                                    <i class="bi bi-lock"></i> Mật khẩu <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="mat_khau" 
                                           name="mat_khau" 
                                           required 
                                           placeholder="Nhập mật khẩu"
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
                                <label for="vai_tro" class="form-label">
                                    <i class="bi bi-shield"></i> Vai trò
                                </label>
                                <select class="form-select" id="vai_tro" name="vai_tro">
                                    <option value="user" <?= ($_POST['vai_tro'] ?? 'user') === 'user' ? 'selected' : '' ?>>
                                        <i class="bi bi-person"></i> Người dùng thường
                                    </option>
                                    <option value="admin" <?= ($_POST['vai_tro'] ?? 'user') === 'admin' ? 'selected' : '' ?>>
                                        <i class="bi bi-shield-check"></i> Quản trị viên
                                    </option>
                                </select>
                                <div class="form-text">Phân quyền truy cập hệ thống</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dia_chi" class="form-label">
                                    <i class="bi bi-geo-alt"></i> Địa chỉ
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="dia_chi" 
                                       name="dia_chi" 
                                       placeholder="Nhập địa chỉ"
                                       value="<?= $_POST['dia_chi'] ?? '' ?>">
                                <div class="form-text">Địa chỉ của người dùng</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="xac_nhan_mat_khau" class="form-label">
                                    <i class="bi bi-lock-fill"></i> Xác nhận mật khẩu <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="xac_nhan_mat_khau" 
                                       name="xac_nhan_mat_khau" 
                                       required 
                                       placeholder="Nhập lại mật khẩu">
                                <div class="form-text">Nhập lại mật khẩu để xác nhận</div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="?act=ql_nguoidung" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-check-circle"></i> Thêm người dùng
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
                        <li>Mật khẩu sẽ được lưu trữ an toàn</li>
                        <li>Quản trị viên có quyền truy cập tất cả chức năng</li>
                        <li>Người dùng thường chỉ có quyền truy cập hạn chế</li>
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
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('mat_khau').value;
            const confirmPassword = document.getElementById('xac_nhan_mat_khau').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 6 ký tự!');
                return false;
            }
        });
    </script>
</body>
</html>
