<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Shop Quần Áo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 80px;
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
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            margin: 20px auto;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .register-header h2 {
            margin: 0;
            font-weight: bold;
        }
        .register-body {
            padding: 40px;
        }
        .form-floating {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-register-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-register-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }
        .password-toggle:hover {
            color: #495057;
        }
        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="?act=home">
                <i class="bi bi-shop"></i> Shop Quần Áo
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=home#san-pham">Sản phẩm</a>
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="register-container">
                    <div class="register-header">
                        <h2><i class="bi bi-person-plus"></i> Đăng ký tài khoản</h2>
                        <p class="mb-0">Tham gia Shop Quần Áo ngay hôm nay!</p>
                    </div>
                    
                    <div class="register-body">
                        <?php if (isset($error)): ?>
                            <div class="error-message">
                                <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" id="registerForm">
                            <div class="form-floating">
                                <input type="text" 
                                       class="form-control" 
                                       id="ten" 
                                       name="ten" 
                                       placeholder="Họ và tên"
                                       value="<?= htmlspecialchars($_POST['ten'] ?? '') ?>"
                                       required>
                                <label for="ten">
                                    <i class="bi bi-person"></i> Họ và tên
                                </label>
                                <div class="form-text">Nhập họ và tên đầy đủ của bạn</div>
                            </div>

                            <div class="form-floating">
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       placeholder="Email"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                       required>
                                <label for="email">
                                    <i class="bi bi-envelope"></i> Email
                                </label>
                                <div class="form-text">Email sẽ được sử dụng để đăng nhập</div>
                            </div>

                            <div class="form-floating position-relative">
                                <input type="password" 
                                       class="form-control" 
                                       id="mat_khau" 
                                       name="mat_khau" 
                                       placeholder="Mật khẩu"
                                       required>
                                <label for="mat_khau">
                                    <i class="bi bi-lock"></i> Mật khẩu
                                </label>
                                <button type="button" class="password-toggle" onclick="togglePassword('mat_khau')">
                                    <i class="bi bi-eye" id="eye-mat_khau"></i>
                                </button>
                                <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự</div>
                            </div>

                            <div class="form-floating position-relative">
                                <input type="password" 
                                       class="form-control" 
                                       id="xac_nhan_mat_khau" 
                                       name="xac_nhan_mat_khau" 
                                       placeholder="Xác nhận mật khẩu"
                                       required>
                                <label for="xac_nhan_mat_khau">
                                    <i class="bi bi-lock-fill"></i> Xác nhận mật khẩu
                                </label>
                                <button type="button" class="password-toggle" onclick="togglePassword('xac_nhan_mat_khau')">
                                    <i class="bi bi-eye" id="eye-xac_nhan_mat_khau"></i>
                                </button>
                                <div class="form-text">Nhập lại mật khẩu để xác nhận</div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-register-submit text-white">
                                    <i class="bi bi-person-plus"></i> Đăng ký ngay
                                </button>
                            </div>
                        </form>

                        <div class="login-link">
                            <p>Đã có tài khoản? <a href="?act=login">Đăng nhập ngay</a></p>
                            <a href="?act=home" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Quay lại trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                eyeIcon.className = 'bi bi-eye';
            }
        }

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const matKhau = document.getElementById('mat_khau').value;
            const xacNhanMatKhau = document.getElementById('xac_nhan_mat_khau').value;
            
            if (matKhau.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 6 ký tự!');
                return false;
            }
            
            if (matKhau !== xacNhanMatKhau) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                return false;
            }
        });
    </script>
</body>
</html>