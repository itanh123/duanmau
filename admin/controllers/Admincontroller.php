<?php
class Admincontroller
{
    public $example;

    public function __construct()
    {
        $this->example = new AdminModels();
    }

    public function home()
    {
        $sanpham = $this->example->hienthi();
        include "admin/views/hienthi.php";
    }
    // sửa sản phẩm
    public function sua($id)
    {
        $sanpham = $this->example->laySanPham($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $gia = $_POST['gia'];
            $mo_ta = $_POST['mo_ta'];
            $image = $_FILES['image']['name'];

            $hinh_anh = $sanpham['hinh_anh']; // giữ ảnh cũ
            if (!empty($image)) {
                $target_dir = "hinhanh/";
                $target_file = $target_dir . basename($image);
                move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                $hinh_anh = $target_file;
            }

            $this->example->suaSanPham($id, $ten, $gia, $mo_ta, $hinh_anh);
            header("Location: " . BASE_URL . "/");
            exit;
        }

        $sanpham['hinh_anh_url'] = !empty($sanpham['hinh_anh']) ? BASE_URL . $sanpham['hinh_anh'] : '';
        include "admin/views/sua.php";
    }
    // xóa sản phẩm
    public function xoa($id)
    {
        $this->example->xoaSanPham($id);
        header("Location: " . BASE_URL . "/");
        exit;
    }
    // thêm sản phẩm
    public function them()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $gia = $_POST['gia'];
            $mo_ta = $_POST['mo_ta'];
            $image = $_FILES['hinh_anh']['name'];

            $target_dir = "hinhanh/";
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file);

            $this->example->themSanPham($ten, $gia, $mo_ta, $target_file);
            header("Location: " . BASE_URL . "/");
            exit;
        }

        include "admin/views/them.php";
    }
    // hàm sửa và xóa tài khoản người dùng sửa dc vai trò nữa
    public function suaTaiKhoan($id)
    {
        $nguoidung = $this->example->layNguoiDung($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $email = $_POST['email'];
            $mat_khau = $_POST['mat_khau'];
            $vai_tro = $_POST['vai_tro'];

            $this->example->suaNguoiDung($id, $ten, $email, $mat_khau, $vai_tro);
            header("Location: " . BASE_URL . "/");
            exit;
        }

        $nguoidung['hinh_anh_url'] = !empty($nguoidung['hinh_anh']) ? BASE_URL . $nguoidung['hinh_anh'] : '';
        include "admin/views/sua_taikhoan.php";
    }

    // ===== QUẢN LÝ BIẾN THỂ SẢN PHẨM =====

    // Hiển thị danh sách biến thể
    public function quanLyBienThe()
    {
        $bienThe = $this->example->layBienTheSanPham();
        include "admin/views/quan_ly_bien_the.php";
    }

    // Thêm biến thể mới
    public function themBienThe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_san_pham = $_POST['id_san_pham'];
            $mau_sac = $_POST['mau_sac'];
            $kich_thuoc = $_POST['kich_thuoc'];
            $so_luong = $_POST['so_luong'];

            if ($this->example->themBienThe($id_san_pham, $mau_sac, $kich_thuoc, $so_luong)) {
                $_SESSION['success'] = "Thêm biến thể thành công!";
            } else {
                $_SESSION['error'] = "Thêm biến thể thất bại!";
            }
            header("Location: ?act=quan_ly_bien_the");
            exit;
        }

        $sanPham = $this->example->layDanhSachSanPham();
        include "admin/views/them_bien_the.php";
    }

    // Sửa biến thể
    public function suaBienThe($id)
    {
        $bienThe = $this->example->layBienTheTheoId($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mau_sac = $_POST['mau_sac'];
            $kich_thuoc = $_POST['kich_thuoc'];
            $so_luong = $_POST['so_luong'];

            if ($this->example->suaBienThe($id, $mau_sac, $kich_thuoc, $so_luong)) {
                $_SESSION['success'] = "Sửa biến thể thành công!";
            } else {
                $_SESSION['error'] = "Sửa biến thể thất bại!";
            }
            header("Location: ?act=quan_ly_bien_the");
            exit;
        }

        include "admin/views/sua_bien_the.php";
    }

    // Xóa biến thể
    public function xoaBienThe($id)
    {
        if ($this->example->xoaBienThe($id)) {
            $_SESSION['success'] = "Xóa biến thể thành công!";
        } else {
            $_SESSION['error'] = "Không thể xóa biến thể này vì đang được sử dụng!";
        }
        header("Location: ?act=quan_ly_bien_the");
        exit;
    }

    // ===== QUẢN LÝ ĐƠN HÀNG =====

    // Hiển thị trang quản lý đơn hàng
    public function quanLyDonHang()
    {
        $trangThai = $_GET['trang_thai'] ?? null;
        $ngayBatDau = $_GET['ngay_bat_dau'] ?? null;
        $ngayKetThuc = $_GET['ngay_ket_thuc'] ?? null;
        
        $danhSachDonHang = $this->example->layDanhSachDonHang($trangThai, $ngayBatDau, $ngayKetThuc);
        $thongKe = $this->example->layThongKeDonHang($ngayBatDau, $ngayKetThuc);
        $danhSachTrangThai = $this->example->layDanhSachTrangThaiDonHang();
        
        include "admin/views/quan_ly_don_hang.php";
    }

    // Hiển thị chi tiết đơn hàng
    public function chiTietDonHang($id)
    {
        if (!$id) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng!";
            header("Location: ?act=ql_donhang");
            exit;
        }
        
        $donHang = $this->example->layChiTietDonHang($id);
        if (!$donHang) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng!";
            header("Location: ?act=ql_donhang");
            exit;
        }
        
        include "admin/views/chi_tiet_don_hang.php";
    }

    // Cập nhật trạng thái đơn hàng
    public function capNhatTrangThaiDonHang()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idDonHang = $_POST['id_don_hang'] ?? '';
            $trangThai = $_POST['trang_thai'] ?? '';
            $ghiChu = $_POST['ghi_chu'] ?? '';
            
            if (empty($idDonHang) || empty($trangThai)) {
                $_SESSION['error'] = "Thông tin không hợp lệ!";
                header("Location: ?act=ql_donhang");
                exit;
            }
            
            if ($this->example->capNhatTrangThaiDonHang($idDonHang, $trangThai, $ghiChu)) {
                $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật trạng thái đơn hàng thất bại!";
            }
        }
        
        header("Location: ?act=ql_donhang");
        exit;
    }

    // Hủy đơn hàng
    public function huyDonHang()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idDonHang = $_POST['id_don_hang'] ?? '';
            $lyDoHuy = $_POST['ly_do_huy'] ?? 'Không có lý do';
            
            if (empty($idDonHang)) {
                $_SESSION['error'] = "Thông tin không hợp lệ!";
                header("Location: ?act=ql_donhang");
                exit;
            }
            
            if ($this->example->huyDonHang($idDonHang, $lyDoHuy)) {
                $_SESSION['success'] = "Hủy đơn hàng thành công!";
            } else {
                $_SESSION['error'] = "Hủy đơn hàng thất bại!";
            }
        }
        
        header("Location: ?act=ql_donhang");
        exit;
    }

    // Báo cáo đơn hàng
    public function baoCaoDonHang()
    {
        $loaiBaoCao = $_GET['loai_bao_cao'] ?? 'ngay';
        $ngayBatDau = $_GET['ngay_bat_dau'] ?? null;
        $ngayKetThuc = $_GET['ngay_ket_thuc'] ?? null;
        
        $baoCao = $this->example->layBaoCaoDonHang($loaiBaoCao, $ngayBatDau, $ngayKetThuc);
        $thongKe = $this->example->layThongKeDonHang($ngayBatDau, $ngayKetThuc);
        
        include "admin/views/bao_cao_don_hang.php";
    }

    // Tìm kiếm đơn hàng
    public function timKiemDonHang()
    {
        $tuKhoa = $_GET['tu_khoa'] ?? '';
        $trangThai = $_GET['trang_thai'] ?? null;
        $ngayBatDau = $_GET['ngay_bat_dau'] ?? null;
        $ngayKetThuc = $_GET['ngay_ket_thuc'] ?? null;
        
        if (empty($tuKhoa)) {
            header("Location: ?act=ql_donhang");
            exit;
        }
        
        $ketQuaTimKiem = $this->example->timKiemDonHang($tuKhoa, $trangThai, $ngayBatDau, $ngayKetThuc);
        $danhSachTrangThai = $this->example->layDanhSachTrangThaiDonHang();
        
        include "admin/views/tim_kiem_don_hang.php";
    }

    // ===== QUẢN LÝ NGƯỜI DÙNG =====

    // Hiển thị danh sách người dùng
    public function quanLyNguoiDung()
    {
        $nguoiDung = $this->example->layDanhSachNguoiDung();
        $thongKe = $this->example->layThongKeNguoiDung();
        include "admin/views/quan_ly_nguoi_dung.php";
    }

    // Thêm người dùng mới
    public function themNguoiDung()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $email = $_POST['email'];
            $mat_khau = $_POST['mat_khau'];
            $vai_tro = $_POST['vai_tro'] ?? 'user';
            $dia_chi = $_POST['dia_chi'] ?? '';

            if ($this->example->themNguoiDung($ten, $email, $mat_khau, $vai_tro, $dia_chi)) {
                $_SESSION['success'] = "Thêm người dùng thành công!";
            } else {
                $_SESSION['error'] = "Email đã tồn tại hoặc có lỗi xảy ra!";
            }
            header("Location: ?act=ql_nguoidung");
            exit;
        }

        include "admin/views/them_nguoi_dung.php";
    }

    // Sửa thông tin người dùng
    public function suaNguoiDung($id)
    {
        $nguoiDung = $this->example->layNguoiDung($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $email = $_POST['email'];
            $vai_tro = $_POST['vai_tro'];
            $dia_chi = $_POST['dia_chi'] ?? '';
            $mat_khau = $_POST['mat_khau'] ?? null;

            if ($this->example->capNhatNguoiDung($id, $ten, $email, $vai_tro, $dia_chi, $mat_khau)) {
                $_SESSION['success'] = "Cập nhật thông tin người dùng thành công!";
            } else {
                $_SESSION['error'] = "Email đã tồn tại hoặc có lỗi xảy ra!";
            }
            header("Location: ?act=ql_nguoidung");
            exit;
        }

        include "admin/views/sua_nguoi_dung.php";
    }

    // Xóa người dùng
    public function xoaNguoiDung($id)
    {
        if ($this->example->xoaNguoiDung($id)) {
            $_SESSION['success'] = "Xóa người dùng thành công!";
        } else {
            $_SESSION['error'] = "Không thể xóa người dùng này vì có đơn hàng liên quan!";
        }
        header("Location: ?act=ql_nguoidung");
        exit;
    }

    // Hàm tìm kiếm sản phẩm (admin)
    public function timKiemSanPham()
    {
        $tuKhoa = $_GET['tu_khoa'] ?? '';
        $giaMin = isset($_GET['gia_min']) && $_GET['gia_min'] !== '' ? (float)$_GET['gia_min'] : null;
        $giaMax = isset($_GET['gia_max']) && $_GET['gia_max'] !== '' ? (float)$_GET['gia_max'] : null;
        $mauSac = $_GET['mau_sac'] ?? '';

        // Lấy danh sách màu sắc để hiển thị trong form
        $danhSachMauSac = $this->example->layDanhSachMauSac();

        // Thực hiện tìm kiếm
        $sanpham = $this->example->timKiemSanPham($tuKhoa, $giaMin, $giaMax, $mauSac);

        include "admin/views/timkiem_admin.php";
    }

    // ===== QUẢN LÝ PHẢN HỒI ĐƠN HÀNG =====

    // Hiển thị trang quản lý phản hồi
    public function quanLyPhanHoi()
    {
        $danhSachPhanHoi = $this->example->layTatCaPhanHoi();
        $thongKePhanHoi = $this->example->layThongKePhanHoi();
        include "admin/views/quan_ly_phan_hoi.php";
    }

    // Cập nhật trạng thái phản hồi
    public function capNhatTrangThaiPhanHoi()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPhanHoi = $_POST['id_phan_hoi'] ?? '';
            $trangThai = $_POST['trang_thai'] ?? '';

            if ($this->example->capNhatTrangThaiPhanHoi($idPhanHoi, $trangThai)) {
                $_SESSION['success'] = "Cập nhật trạng thái phản hồi thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật trạng thái phản hồi thất bại!";
            }
        }

        header("Location: ?act=quan_ly_phan_hoi");
        exit;
    }

    // Xóa phản hồi
    public function xoaPhanHoi()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPhanHoi = $_POST['id_phan_hoi'] ?? '';

            if ($this->example->xoaPhanHoi($idPhanHoi)) {
                $_SESSION['success'] = "Xóa phản hồi thành công!";
            } else {
                $_SESSION['error'] = "Xóa phản hồi thất bại!";
            }
        }

        header("Location: ?act=quan_ly_phan_hoi");
        exit;
    }
}
