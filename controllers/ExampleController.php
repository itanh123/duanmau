<?php

class ExampleController
{
    public $example;

    public function __construct()
    {
        $this->example = new Example();
    }

    public function home()
    {
        // Lấy danh sách sản phẩm để hiển thị cho khách vãng lai
        $sanpham = $this->example->hienthi();
        require "views/home.php";
    }
    // hàm thêm người dùng
    public function dangky()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $email = $_POST['email'];
            $mat_khau = $_POST['mat_khau'];
            $xac_nhan_mat_khau = $_POST['xac_nhan_mat_khau'] ?? '';

            // Kiểm tra xác nhận mật khẩu
            if ($mat_khau !== $xac_nhan_mat_khau) {
                $error = "Mật khẩu xác nhận không khớp!";
            } else {
                // Kiểm tra email đã tồn tại chưa
                if ($this->example->kiemTraEmailTonTai($email)) {
                    $error = "Email này đã được sử dụng!";
                } else {
                    // Thực hiện đăng ký
                    if ($this->example->dangky($ten, $email, $mat_khau)) {
                        $_SESSION['success'] = "Đăng ký tài khoản thành công! Vui lòng đăng nhập.";
                        header("Location: ?act=login");
                        exit;
                    } else {
                        $error = "Có lỗi xảy ra khi đăng ký. Vui lòng thử lại!";
                    }
                }
            }
        }

        require "views/dangky.php";
    }
    // hàm xem chi tiết sản phẩm
    public function xemSanPham($id)
    {
        // Cho phép khách vãng lai xem chi tiết sản phẩm
        $sanpham = $this->example->laySanPham($id);
        if (!$sanpham) {
            header("Location: " . BASE_URL . "/");
            exit;
        }
        include "views/chitiet.php";
    }
    // hàm hiện thị tất cả sản phẩm
    public function hienthi()
    {
        // Kiểm tra đăng nhập - chỉ người dùng đã đăng nhập mới có thể truy cập
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        $sanpham = $this->example->hienthi();

        // Lấy thông tin giỏ hàng nếu đã đăng nhập
        $gioHang = [];
        if (isset($_SESSION['user_id'])) {
            $gioHang = $this->example->layGioHang($_SESSION['user_id']);
        }

        include "views/hienthi.php";
    }
    // hàm đặt hàng
    public function dathang()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        $gioHang = $this->example->layGioHang($_SESSION['user_id']);
        $tong_tien = 0;

        foreach ($gioHang as $item) {
            $tong_tien += $item['gia'] * $item['so_luong'];
        }

        // Áp dụng mã giảm giá nếu có
        $soTienGiam = 0;
        $tongTienSauGiam = $tong_tien;

        if (isset($_SESSION['ma_giam_gia'])) {
            $soTienGiam = $_SESSION['ma_giam_gia']['so_tien_giam'];
            $tongTienSauGiam = $tong_tien - $soTienGiam;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Bắt đầu transaction
                $this->example->conn->beginTransaction();

                // Tạo đơn hàng mới với giá sau khi áp dụng mã giảm giá
                $id_don_hang = $this->example->taoDonHang($_SESSION['user_id'], $tongTienSauGiam);

                if ($id_don_hang) {
                    $success = true;

                    // Thêm chi tiết đơn hàng và cập nhật tồn kho
                    foreach ($gioHang as $item) {
                        // Thêm chi tiết đơn hàng
                        $result1 = $this->example->themChiTietDonHang($id_don_hang, $item['id_bien_the'], $item['so_luong'], $item['gia']);

                        if (!$result1) {
                            throw new Exception("Lỗi khi thêm chi tiết đơn hàng cho sản phẩm: " . $item['ten_san_pham']);
                        }

                        // Cập nhật số lượng tồn kho
                        $result2 = $this->example->capNhatTonKho($item['id_bien_the'], $item['so_luong']);

                        if (!$result2) {
                            throw new Exception("Lỗi khi cập nhật tồn kho cho sản phẩm: " . $item['ten_san_pham']);
                        }
                    }

                    // Xóa giỏ hàng sau khi đặt hàng thành công
                    $this->example->xoaGioHang($_SESSION['user_id']);

                    // Xóa mã giảm giá khỏi session sau khi đặt hàng thành công
                    if (isset($_SESSION['ma_giam_gia'])) {
                        $this->example->xoaMaGiamGiaKhoiSession();
                    }

                    // Commit transaction
                    $this->example->conn->commit();

                    $_SESSION['success'] = "Đặt hàng thành công! Mã đơn hàng: #" . $id_don_hang;
                    if ($soTienGiam > 0) {
                        $_SESSION['success'] .= " (Đã giảm " . number_format($soTienGiam) . " VNĐ)";
                    }
                    header("Location: ?act=xemDonHang&id=" . $id_don_hang);
                    exit;
                } else {
                    throw new Exception("Không thể tạo đơn hàng. Vui lòng thử lại.");
                }
            } catch (Exception $e) {
                // Rollback transaction nếu có lỗi
                if ($this->example->conn->inTransaction()) {
                    $this->example->conn->rollBack();
                }
                $error = "Lỗi đặt hàng: " . $e->getMessage();
                error_log("Order error: " . $e->getMessage());
            }
        }

        // Lấy thông tin mã giảm giá từ session nếu có
        $maGiamGia = $this->example->layMaGiamGiaTuSession();

        include "views/dathang.php";
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $mat_khau = $_POST['mat_khau'] ?? '';

            $nguoi_dung = $this->example->kiemTraDangNhap($email, $mat_khau);
            if ($nguoi_dung) {
                // Lưu session
                $_SESSION['user_id'] = $nguoi_dung['id'];
                $_SESSION['vai_tro'] = $nguoi_dung['vai_tro'];
                $_SESSION['ten'] = $nguoi_dung['ten'];

                if ($nguoi_dung['vai_tro'] === 'admin') {
                    header("Location: ?act=home");
                } else {
                    header("Location: ?act=hienthi");
                }
                exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
            }
        }

        include "views/login.php";
    }

    public function themvaogio()
    {
        error_log("Method themvaogio() được gọi");
        error_log("Session data: " . print_r($_SESSION, true));

        if (!isset($_SESSION['user_id'])) {
            error_log("Không có user_id trong session, redirect về login");
            error_log("Đang redirect đến: ?act=login");
            header("Location: ?act=login");
            exit;
        }

        error_log("Request method: " . $_SERVER['REQUEST_METHOD']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debug: Log POST data
            error_log("POST data: " . print_r($_POST, true));

            $idNguoiDung = $_SESSION['user_id'];
            $idBienThe = $_POST['id_bien_the'] ?? null;
            $soLuong = $_POST['so_luong'] ?? 1;
            $redirectUrl = $_POST['redirect_url'] ?? '?act=hienthi';

            error_log("ID Người dùng: $idNguoiDung");
            error_log("ID Biến thể: $idBienThe");
            error_log("Số lượng: $soLuong");
            error_log("Redirect URL: $redirectUrl");

            if (!$idBienThe) {
                $_SESSION['error'] = "Vui lòng chọn sản phẩm!";
                error_log("Lỗi: Không có ID biến thể");
                error_log("Đang redirect đến: " . $redirectUrl);
            } else {
                try {
                    // Debug: Log thông tin
                    error_log("Thêm vào giỏ hàng - ID Biến thể: $idBienThe, Số lượng: $soLuong, Người dùng: $idNguoiDung");
                    error_log("DEBUG: Kiểm tra tồn kho với ID=$idBienThe, Số lượng=$soLuong");

                    // Kiểm tra tồn kho
                    if (!$this->example->kiemTraTonKho($idBienThe, $soLuong)) {
                        $bienThe = $this->example->layBienTheSanPham($idBienThe);

                        // Xử lý trường hợp dữ liệu trống
                        $tenSanPham = $bienThe['ten_san_pham'] ?? 'Không xác định';
                        $mauSac = $bienThe['mau_sac'] ?? 'Không xác định';
                        $kichThuoc = $bienThe['kich_thuoc'] ?? 'Không xác định';

                        $_SESSION['error'] = "Không đủ hàng trong kho. Sản phẩm: " . $tenSanPham .
                            " (Màu: " . $mauSac . ", Kích thước: " . $kichThuoc . ")";
                        error_log("Không đủ hàng trong kho - ID biến thể: $idBienThe, Dữ liệu: " . print_r($bienThe, true));
                    } else {
                        $ok = $this->example->themVaoGioHang($idNguoiDung, $idBienThe, $soLuong);
                        if ($ok) {
                            $_SESSION['success'] = "Đã thêm vào giỏ hàng thành công!";
                            error_log("Thêm vào giỏ hàng thành công");
                        } else {
                            $_SESSION['error'] = "Thêm giỏ hàng thất bại.";
                            error_log("Thêm vào giỏ hàng thất bại");
                        }
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = "Lỗi: " . $e->getMessage();
                    error_log("Lỗi thêm vào giỏ hàng: " . $e->getMessage());
                    error_log("Exception details: " . $e->getTraceAsString());
                }
            }

            // Debug: Log session data
            error_log("Session data trước khi redirect: " . print_r($_SESSION, true));

            // Debug: Log redirect URL
            error_log("Redirect URL: " . $redirectUrl);

            // Chuyển về trang trước đó
            error_log("Đang redirect đến: " . $redirectUrl);
            header("Location: " . $redirectUrl);
            exit;
        }

        // Nếu không phải POST request, chuyển về trang sản phẩm
        error_log("Không phải POST request, redirect về hienthi");
        error_log("Đang redirect đến: ?act=hienthi");
        header("Location: ?act=hienthi");
        exit;
    }

    // Hàm xem giỏ hàng
    public function xemGioHang()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        $gioHang = $this->example->layGioHang($_SESSION['user_id']);

        // Lấy thông tin mã giảm giá từ session nếu có
        $maGiamGia = $this->example->layMaGiamGiaTuSession();

        include "views/giohang.php";
    }

    // Hàm cập nhật số lượng trong giỏ hàng
    public function capNhatGioHang()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idGioHang = $_POST['id_gio_hang'] ?? null;
            $soLuong = $_POST['so_luong'] ?? 1;

            if ($idGioHang && $soLuong > 0) {
                $ok = $this->example->capNhatSoLuongGioHang($idGioHang, $soLuong);
                if ($ok) {
                    $success = "Cập nhật giỏ hàng thành công!";
                } else {
                    $error = "Cập nhật thất bại.";
                }
            }
        }

        header("Location: ?act=xemGioHang");
        exit;
    }

    // Hàm xóa sản phẩm khỏi giỏ hàng
    public function xoaKhoiGioHang()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idGioHang = $_POST['id_gio_hang'] ?? null;

            if ($idGioHang) {
                $ok = $this->example->xoaKhoiGioHang($idGioHang, $_SESSION['user_id']);
                if ($ok) {
                    $success = "Đã xóa sản phẩm khỏi giỏ hàng!";
                } else {
                    $error = "Xóa thất bại.";
                }
            }
        }

        header("Location: ?act=xemGioHang");
        exit;
    }
    // hàm đăng xuất
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: ?act=login");
        exit;
    }

    // Hàm xem chi tiết đơn hàng
    public function xemDonHang()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        $idDonHang = $_GET['id'] ?? null;
        if (!$idDonHang) {
            header("Location: ?act=danhSachDonHang");
            exit;
        }

        $donHang = $this->example->layDonHang($idDonHang, $_SESSION['user_id']);
        if (!$donHang) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng!";
            header("Location: ?act=danhSachDonHang");
            exit;
        }

        $chiTietDonHang = $this->example->layChiTietDonHang($idDonHang);
        include "views/chitietdonhang.php";
    }

    // Hàm xem danh sách đơn hàng
    public function danhSachDonHang()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        $danhSachDonHang = $this->example->layDanhSachDonHang($_SESSION['user_id']);
        include "views/danhsachdonhang.php";
    }

    // Hàm áp dụng mã giảm giá
    public function apDungMaGiamGia()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maGiamGia = trim($_POST['ma_giam_gia'] ?? '');

            if (empty($maGiamGia)) {
                $_SESSION['error'] = "Vui lòng nhập mã giảm giá!";
                header("Location: ?act=xemGioHang");
                exit;
            }

            // Kiểm tra mã giảm giá
            $maGiamGiaInfo = $this->example->kiemTraMaGiamGia($maGiamGia);

            if (!$maGiamGiaInfo) {
                $_SESSION['error'] = "Mã giảm giá không hợp lệ hoặc đã hết hạn!";
                header("Location: ?act=xemGioHang");
                exit;
            }

            // Lấy giỏ hàng để tính tổng tiền
            $gioHang = $this->example->layGioHang($_SESSION['user_id']);
            $tongTien = 0;

            foreach ($gioHang as $item) {
                $tongTien += $item['gia'] * $item['so_luong'];
            }

            // Tính số tiền giảm
            $soTienGiam = ($tongTien * $maGiamGiaInfo['phan_tram']) / 100;

            // Lưu thông tin mã giảm giá vào session
            $this->example->luuMaGiamGiaVaoSession(
                $maGiamGiaInfo['ma'],
                $maGiamGiaInfo['phan_tram'],
                $soTienGiam
            );

            $_SESSION['success'] = "Áp dụng mã giảm giá thành công! Giảm " .
                number_format($soTienGiam) . " VNĐ (" .
                $maGiamGiaInfo['phan_tram'] . "%)";
        }

        header("Location: ?act=xemGioHang");
        exit;
    }

    // Hàm xóa mã giảm giá
    public function xoaMaGiamGia()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        $this->example->xoaMaGiamGiaKhoiSession();
        $_SESSION['success'] = "Đã xóa mã giảm giá!";

        header("Location: ?act=xemGioHang");
        exit;
    }

    // Hàm tìm kiếm sản phẩm
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

        // Lấy thông tin giỏ hàng nếu đã đăng nhập
        $gioHang = [];
        if (isset($_SESSION['user_id'])) {
            $gioHang = $this->example->layGioHang($_SESSION['user_id']);
        }

        include "views/timkiem.php";
    }

    // ===== CHỨC NĂNG PHẢN HỒI ĐƠN HÀNG =====

    // Thêm phản hồi mới
    public function themPhanHoi()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idDonHang = $_POST['id_don_hang'] ?? '';
            $noiDung = $_POST['noi_dung'] ?? '';
            $diemDanhGia = $_POST['diem_danh_gia'] ?? 5;
            $idNguoiDung = $_SESSION['user_id'];

            if (empty($noiDung)) {
                $_SESSION['error'] = "Vui lòng nhập nội dung phản hồi!";
            } else {
                $result = $this->example->themPhanHoi($idDonHang, $idNguoiDung, $noiDung, $diemDanhGia);
                if ($result) {
                    $_SESSION['success'] = "Gửi phản hồi thành công! Cảm ơn bạn đã đánh giá.";
                } else {
                    $_SESSION['error'] = "Không thể gửi phản hồi. Vui lòng kiểm tra lại trạng thái đơn hàng.";
                }
            }
        }

        // Redirect về trang xem đơn hàng
        header("Location: ?act=xemDonHang&id=" . $idDonHang);
        exit;
    }

    // ===== CHỨC NĂNG QUẢN LÝ ĐƠN HÀNG CHO KHÁCH HÀNG =====

    // Hủy đơn hàng (chỉ khi chưa giao hàng)
    public function huyDonHang()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idDonHang = $_POST['id_don_hang'] ?? '';
            $lyDoHuy = $_POST['ly_do_huy'] ?? 'Khách hàng yêu cầu hủy';

            if (empty($idDonHang)) {
                $_SESSION['error'] = "Thông tin không hợp lệ!";
                header("Location: ?act=danhSachDonHang");
                exit;
            }

            // Kiểm tra xem đơn hàng có thuộc về người dùng hiện tại không
            $donHang = $this->example->layDonHangTheoId($idDonHang);
            if (!$donHang || $donHang['id_nguoi_dung'] != $_SESSION['user_id']) {
                $_SESSION['error'] = "Bạn không có quyền hủy đơn hàng này!";
                header("Location: ?act=danhSachDonHang");
                exit;
            }

            // Kiểm tra xem đơn hàng có thể hủy không (chỉ hủy được khi chưa giao)
            if ($donHang['trang_thai'] !== 'chờ xử lý' && $donHang['trang_thai'] !== 'đang giao') {
                $_SESSION['error'] = "Không thể hủy đơn hàng này vì đã được giao hoặc đã hoàn thành!";
                header("Location: ?act=danhSachDonHang");
                exit;
            }

            // Thực hiện hủy đơn hàng
            if ($this->example->huyDonHangKhachHang($idDonHang, $lyDoHuy)) {
                $_SESSION['success'] = "Hủy đơn hàng thành công!";
            } else {
                $_SESSION['error'] = "Không thể hủy đơn hàng. Vui lòng thử lại!";
            }
        }

        header("Location: ?act=danhSachDonHang");
        exit;
    }

    // Xem trạng thái đơn hàng chi tiết
    public function xemTrangThaiDonHang($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?act=login");
            exit;
        }

        if (!$id) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng!";
            header("Location: ?act=danhSachDonHang");
            exit;
        }

        // Lấy thông tin đơn hàng
        $donHang = $this->example->layDonHangTheoId($id);
        if (!$donHang || $donHang['id_nguoi_dung'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Bạn không có quyền xem đơn hàng này!";
            header("Location: ?act=danhSachDonHang");
            exit;
        }

        // Lấy chi tiết đơn hàng
        $chiTietDonHang = $this->example->layChiTietDonHangTheoId($id);
        
        // Lấy lịch sử cập nhật trạng thái
        $lichSuTrangThai = $this->example->layLichSuTrangThaiDonHang($id);

        include "views/trang_thai_don_hang.php";
    }
}
