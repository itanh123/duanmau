<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 220px;
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 8px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

    <!-- Sidebar menu -->
    <div class="sidebar">
        <h4>Admin Menu</h4>
        <a href="?act=home">Trang chủ</a>
        <a href="?act=them">Thêm sản phẩm</a>
        <a href="?act=quan_ly_bien_the">Quản lý biến thể</a>
        <a href="?act=ql_donhang">Quản lý đơn hàng</a>
        <a href="?act=ql_nguoidung">Quản lý người dùng</a>
        <a href="?act=timKiemSanPham">Tìm kiếm</a>
        <a href="?act=logout">Đăng xuất</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h2>Quản lý sản phẩm</h2>
        <table class="table table-bordered">
                            <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Biến thể</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sanpham as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['ten'] ?></td>
                        <td><?= $item['mo_ta'] ?></td>
                        <td><?= number_format($item['gia']) ?> VND</td>
                        <td><img src="<?= $item["hinh_anh"] ?>" alt="Ảnh sản phẩm"></td>
                        <td>
                            <a href="?act=quan_ly_bien_the&san_pham_id=<?= $item['id'] ?>" 
                               class="btn btn-info btn-sm">Xem biến thể</a>
                        </td>
                        <td>
                            <a href="?act=sua&id=<?= $item['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="?act=xoa&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
        </table>
    </div>

</body>
</html>
