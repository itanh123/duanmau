<?php
class AdminModels
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function hienthi()
    {
        $stmt = $this->conn->prepare("SELECT * FROM san_pham");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // lấy sản phẩm theo id
    public function laySanPham($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM san_pham WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    // sửa sản phẩm
    public function suaSanPham($id, $ten, $gia, $mo_ta, $hinh_anh)
    {
        $stmt = $this->conn->prepare("UPDATE san_pham SET ten = :ten, gia = :gia, mo_ta = :mo_ta, hinh_anh = :hinh_anh WHERE id = :id");
        return $stmt->execute(
            [
                ':id' => $id,
                ':ten' => $ten,
                ':gia' => $gia,
                ':mo_ta' => $mo_ta,
                ':hinh_anh' => $hinh_anh
            ]
        );
    }
    // xóa sản phẩm
    public function xoaSanPham($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM san_pham WHERE id = :id");
        return $stmt->execute(
            [
                ':id' => $id
            ]
        );
    }
    // thêm sản phẩm
    public function themSanPham($ten, $gia, $mo_ta, $hinh_anh)
    {
        $stmt = $this->conn->prepare("INSERT INTO san_pham (ten, gia, mo_ta, hinh_anh) VALUES (:ten, :gia, :mo_ta, :hinh_anh)");
        return $stmt->execute(
            [
                ':ten' => $ten,
                ':gia' => $gia,
                ':mo_ta' => $mo_ta,
                ':hinh_anh' => $hinh_anh
            ]
        );
    }
    // hàm lấy ra tài khoản người dùng
    public function layNguoiDung($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM nguoi_dung WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    // hàm sửa và xóa tài khoản người dùng sửa dc vai trò nữa
    public function suaNguoiDung($id, $ten, $email, $mat_khau, $vai_tro, $dia_chi = null, $so_dien_thoai = null)
    {
        $stmt = $this->conn->prepare("UPDATE nguoi_dung SET ten = :ten, email = :email, mat_khau = :mat_khau, vai_tro = :vai_tro, dia_chi = :dia_chi, so_dien_thoai = :so_dien_thoai WHERE id = :id");
        return $stmt->execute(
            [
                ':id' => $id,
                ':ten' => $ten,
                ':email' => $email,
                ':mat_khau' => $mat_khau,
                ':vai_tro' => $vai_tro,
                ':dia_chi' => $dia_chi,
                ':so_dien_thoai' => $so_dien_thoai
            ]
        );
    }

    // ===== QUẢN LÝ BIẾN THỂ SẢN PHẨM =====

    // Lấy danh sách biến thể sản phẩm
    public function layBienTheSanPham($id_san_pham = null)
    {
        if ($id_san_pham) {
            $stmt = $this->conn->prepare("SELECT bt.*, sp.ten as ten_san_pham 
                                        FROM bien_the_san_pham bt 
                                        JOIN san_pham sp ON bt.id_san_pham = sp.id 
                                        WHERE bt.id_san_pham = :id_san_pham");
            $stmt->execute([':id_san_pham' => $id_san_pham]);
        } else {
            $stmt = $this->conn->prepare("SELECT bt.*, sp.ten as ten_san_pham 
                                        FROM bien_the_san_pham bt 
                                        JOIN san_pham sp ON bt.id_san_pham = sp.id");
            $stmt->execute();
        }
        return $stmt->fetchAll();
    }

    // Lấy biến thể theo ID
    public function layBienTheTheoId($id)
    {
        $stmt = $this->conn->prepare("SELECT bt.*, sp.ten as ten_san_pham 
                                    FROM bien_the_san_pham bt 
                                    JOIN san_pham sp ON bt.id_san_pham = sp.id 
                                    WHERE bt.id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Thêm biến thể mới
    public function themBienThe($id_san_pham, $mau_sac, $kich_thuoc, $so_luong)
    {
        $stmt = $this->conn->prepare("INSERT INTO bien_the_san_pham (id_san_pham, mau_sac, kich_thuoc, so_luong) 
                                    VALUES (:id_san_pham, :mau_sac, :kich_thuoc, :so_luong)");
        return $stmt->execute([
            ':id_san_pham' => $id_san_pham,
            ':mau_sac' => $mau_sac,
            ':kich_thuoc' => $kich_thuoc,
            ':so_luong' => $so_luong
        ]);
    }

    // Sửa biến thể
    public function suaBienThe($id, $mau_sac, $kich_thuoc, $so_luong)
    {
        $stmt = $this->conn->prepare("UPDATE bien_the_san_pham 
                                    SET mau_sac = :mau_sac, kich_thuoc = :kich_thuoc, so_luong = :so_luong 
                                    WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':mau_sac' => $mau_sac,
            ':kich_thuoc' => $kich_thuoc,
            ':so_luong' => $so_luong
        ]);
    }

    // Xóa biến thể
    public function xoaBienThe($id)
    {
        // Kiểm tra xem biến thể có trong giỏ hàng hoặc đơn hàng không
        $checkGioHang = $this->conn->prepare("SELECT COUNT(*) FROM gio_hang WHERE id_bien_the = :id");
        $checkGioHang->execute([':id' => $id]);
        $countGioHang = $checkGioHang->fetchColumn();

        $checkDonHang = $this->conn->prepare("SELECT COUNT(*) FROM chi_tiet_don_hang WHERE id_bien_the = :id");
        $checkDonHang->execute([':id' => $id]);
        $countDonHang = $checkDonHang->fetchColumn();

        if ($countGioHang > 0 || $countDonHang > 0) {
            return false; // Không thể xóa vì đang được sử dụng
        }

        $stmt = $this->conn->prepare("DELETE FROM bien_the_san_pham WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Lấy danh sách sản phẩm để chọn khi thêm biến thể
    public function layDanhSachSanPham()
    {
        $stmt = $this->conn->prepare("SELECT id, ten FROM san_pham ORDER BY ten");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh sách tất cả người dùng
    public function layDanhSachNguoiDung()
    {
        $stmt = $this->conn->prepare("SELECT id, ten, email, vai_tro, dia_chi, so_dien_thoai FROM nguoi_dung ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ===== QUẢN LÝ ĐƠN HÀNG =====

    // Lấy danh sách tất cả đơn hàng
    public function layDanhSachDonHang($trangThai = null, $ngayBatDau = null, $ngayKetThuc = null)
    {
        try {
            $sql = "SELECT dh.*, nd.ten as ten_nguoi_dung, nd.email, nd.so_dien_thoai
                    FROM don_hang dh
                    JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id";
            
            $whereConditions = [];
            $params = [];
            
            if ($trangThai && $trangThai !== 'tat_ca') {
                $whereConditions[] = "dh.trang_thai = :trang_thai";
                $params[':trang_thai'] = $trangThai;
            }
            
            if ($ngayBatDau) {
                $whereConditions[] = "DATE(dh.ngay) >= :ngay_bat_dau";
                $params[':ngay_bat_dau'] = $ngayBatDau;
            }
            
            if ($ngayKetThuc) {
                $whereConditions[] = "DATE(dh.ngay) <= :ngay_ket_thuc";
                $params[':ngay_ket_thuc'] = $ngayKetThuc;
            }
            
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }
            
            $sql .= " ORDER BY dh.ngay DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Lỗi lấy danh sách đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    // Lấy chi tiết đơn hàng theo ID
    public function layChiTietDonHang($idDonHang)
    {
        try {
            // Lấy thông tin đơn hàng
            $sqlDonHang = "SELECT dh.*, nd.ten as ten_nguoi_dung, nd.email, nd.so_dien_thoai, nd.dia_chi
                           FROM don_hang dh
                           JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
                           WHERE dh.id = :id";
            
            $stmtDonHang = $this->conn->prepare($sqlDonHang);
            $stmtDonHang->execute([':id' => $idDonHang]);
            $donHang = $stmtDonHang->fetch();
            
            if (!$donHang) {
                return null;
            }
            
            // Lấy chi tiết sản phẩm trong đơn hàng
            $sqlChiTiet = "SELECT ctdh.*, sp.ten as ten_san_pham, sp.hinh_anh, bt.mau_sac, bt.kich_thuoc
                           FROM chi_tiet_don_hang ctdh
                           JOIN bien_the_san_pham bt ON ctdh.id_bien_the = bt.id
                           JOIN san_pham sp ON bt.id_san_pham = sp.id
                           WHERE ctdh.id_don_hang = :id_don_hang";
            
            $stmtChiTiet = $this->conn->prepare($sqlChiTiet);
            $stmtChiTiet->execute([':id_don_hang' => $idDonHang]);
            $chiTiet = $stmtChiTiet->fetchAll();
            
            $donHang['chi_tiet'] = $chiTiet;
            return $donHang;
        } catch (Exception $e) {
            error_log("Lỗi lấy chi tiết đơn hàng: " . $e->getMessage());
            return null;
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function capNhatTrangThaiDonHang($idDonHang, $trangThai, $ghiChu = null)
    {
        try {
            $sql = "UPDATE don_hang SET trang_thai = :trang_thai, ngay_cap_nhat = CURRENT_DATE";
            $params = [':trang_thai' => $trangThai, ':id' => $idDonHang];
            
            if ($ghiChu) {
                $sql .= ", ghi_chu = :ghi_chu";
                $params[':ghi_chu'] = $ghiChu;
            }
            
            $sql .= " WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log("Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // Hủy đơn hàng
    public function huyDonHang($idDonHang, $lyDoHuy)
    {
        try {
            // Cập nhật trạng thái đơn hàng
            $sqlDonHang = "UPDATE don_hang SET trang_thai = 'đã huỷ', ghi_chu = :ghi_chu, ngay_cap_nhat = CURRENT_DATE WHERE id = :id";
            $stmtDonHang = $this->conn->prepare($sqlDonHang);
            $stmtDonHang->execute([':ghi_chu' => $lyDoHuy, ':id' => $idDonHang]);
            
            // Hoàn trả số lượng sản phẩm về kho
            $sqlChiTiet = "SELECT id_bien_the, so_luong FROM chi_tiet_don_hang WHERE id_don_hang = :id_don_hang";
            $stmtChiTiet = $this->conn->prepare($sqlChiTiet);
            $stmtChiTiet->execute([':id_don_hang' => $idDonHang]);
            $chiTiet = $stmtChiTiet->fetchAll();
            
            foreach ($chiTiet as $item) {
                $sqlCapNhat = "UPDATE bien_the_san_pham SET so_luong = so_luong + :so_luong WHERE id = :id";
                $stmtCapNhat = $this->conn->prepare($sqlCapNhat);
                $stmtCapNhat->execute([':so_luong' => $item['so_luong'], ':id' => $item['id_bien_the']]);
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Lỗi hủy đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // Lấy thống kê đơn hàng
    public function layThongKeDonHang($ngayBatDau = null, $ngayKetThuc = null)
    {
        try {
            $sql = "SELECT 
                        COUNT(*) as tong_don_hang,
                        COUNT(CASE WHEN trang_thai = 'chờ xử lý' THEN 1 END) as cho_xu_ly,
                        COUNT(CASE WHEN trang_thai = 'đã xác nhận' THEN 1 END) as da_xac_nhan,
                        COUNT(CASE WHEN trang_thai = 'đang giao' THEN 1 END) as dang_giao,
                        COUNT(CASE WHEN trang_thai = 'đã giao' THEN 1 END) as da_giao,
                        COUNT(CASE WHEN trang_thai = 'đã huỷ' THEN 1 END) as da_huy,
                        SUM(CASE WHEN trang_thai IN ('đã giao') THEN tong_tien ELSE 0 END) as tong_doanh_thu,
                        AVG(CASE WHEN trang_thai IN ('đã giao') THEN tong_tien ELSE NULL END) as trung_binh_don_hang
                    FROM don_hang";
            
            $whereConditions = [];
            $params = [];
            
            if ($ngayBatDau) {
                $whereConditions[] = "DATE(ngay) >= :ngay_bat_dau";
                $params[':ngay_bat_dau'] = $ngayBatDau;
            }
            
            if ($ngayKetThuc) {
                $whereConditions[] = "DATE(ngay) <= :ngay_ket_thuc";
                $params[':ngay_ket_thuc'] = $ngayKetThuc;
            }
            
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Lỗi lấy thống kê đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    // Lấy báo cáo đơn hàng theo thời gian
    public function layBaoCaoDonHang($loaiBaoCao = 'ngay', $ngayBatDau = null, $ngayKetThuc = null)
    {
        try {
            $groupBy = '';
            $select = '';
            
            switch ($loaiBaoCao) {
                case 'ngay':
                    $groupBy = 'DATE(ngay)';
                    $select = 'DATE(ngay) as thoi_gian';
                    break;
                case 'thang':
                    $groupBy = 'YEAR(ngay), MONTH(ngay)';
                    $select = 'CONCAT(YEAR(ngay), "-", MONTH(ngay)) as thoi_gian';
                    break;
                case 'nam':
                    $groupBy = 'YEAR(ngay)';
                    $select = 'YEAR(ngay) as thoi_gian';
                    break;
                default:
                    $groupBy = 'DATE(ngay)';
                    $select = 'DATE(ngay) as thoi_gian';
            }
            
            $sql = "SELECT 
                        $select,
                        COUNT(*) as so_don_hang,
                        SUM(CASE WHEN trang_thai IN ('đã giao') THEN tong_tien ELSE 0 END) as doanh_thu,
                        AVG(CASE WHEN trang_thai IN ('đã giao') THEN tong_tien ELSE NULL END) as trung_binh_don_hang
                    FROM don_hang";
            
            $whereConditions = [];
            $params = [];
            
            if ($ngayBatDau) {
                $whereConditions[] = "DATE(ngay) >= :ngay_bat_dau";
                $params[':ngay_bat_dau'] = $ngayBatDau;
            }
            
            if ($ngayKetThuc) {
                $whereConditions[] = "DATE(ngay) <= :ngay_ket_thuc";
                $params[':ngay_ket_thuc'] = $ngayKetThuc;
            }
            
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }
            
            $sql .= " GROUP BY $groupBy ORDER BY thoi_gian DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Lỗi lấy báo cáo đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    // Tìm kiếm đơn hàng
    public function timKiemDonHang($tuKhoa, $trangThai = null, $ngayBatDau = null, $ngayKetThuc = null)
    {
        try {
            $sql = "SELECT dh.*, nd.ten as ten_nguoi_dung, nd.email, nd.so_dien_thoai
                    FROM don_hang dh
                    JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
                    WHERE (nd.ten LIKE :tu_khoa OR nd.email LIKE :tu_khoa OR dh.id LIKE :tu_khoa)";
            
            $params = [':tu_khoa' => '%' . $tuKhoa . '%'];
            
            if ($trangThai && $trangThai !== 'tat_ca') {
                $sql .= " AND dh.trang_thai = :trang_thai";
                $params[':trang_thai'] = $trangThai;
            }
            
            if ($ngayBatDau) {
                $sql .= " AND DATE(dh.ngay) >= :ngay_bat_dau";
                $params[':ngay_bat_dau'] = $ngayBatDau;
            }
            
            if ($ngayKetThuc) {
                $sql .= " AND DATE(dh.ngay) <= :ngay_ket_thuc";
                $params[':ngay_ket_thuc'] = $ngayKetThuc;
            }
            
            $sql .= " ORDER BY dh.ngay DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Lỗi tìm kiếm đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    // Lấy danh sách trạng thái đơn hàng
    public function layDanhSachTrangThaiDonHang()
    {
        return [
            'cho_xu_ly' => 'chờ xử lý',
            'da_xac_nhan' => 'đã xác nhận',
            'dang_giao' => 'đang giao',
            'da_giao' => 'đã giao',
            'da_huy' => 'đã huỷ'
        ];
    }

    // ===== QUẢN LÝ NGƯỜI DÙNG =====



    // Thêm người dùng mới
    public function themNguoiDung($ten, $email, $mat_khau, $vai_tro = 'user', $dia_chi = '')
    {
        // Kiểm tra email đã tồn tại chưa
        $checkEmail = $this->conn->prepare("SELECT COUNT(*) FROM nguoi_dung WHERE email = :email");
        $checkEmail->execute([':email' => $email]);
        if ($checkEmail->fetchColumn() > 0) {
            return false; // Email đã tồn tại
        }

        $stmt = $this->conn->prepare("INSERT INTO nguoi_dung (ten, email, mat_khau, vai_tro, dia_chi) 
                                    VALUES (:ten, :email, :mat_khau, :vai_tro, :dia_chi)");
        return $stmt->execute([
            ':ten' => $ten,
            ':email' => $email,
            ':mat_khau' => $mat_khau,
            ':vai_tro' => $vai_tro,
            ':dia_chi' => $dia_chi
        ]);
    }

    // Cập nhật thông tin người dùng
    public function capNhatNguoiDung($id, $ten, $email, $vai_tro, $dia_chi = '', $mat_khau = null)
    {
        // Kiểm tra email đã tồn tại chưa (trừ người dùng hiện tại)
        $checkEmail = $this->conn->prepare("SELECT COUNT(*) FROM nguoi_dung WHERE email = :email AND id != :id");
        $checkEmail->execute([':email' => $email, ':id' => $id]);
        if ($checkEmail->fetchColumn() > 0) {
            return false; // Email đã tồn tại
        }

        if ($mat_khau) {
            // Cập nhật cả mật khẩu
            $stmt = $this->conn->prepare("UPDATE nguoi_dung 
                                        SET ten = :ten, email = :email, vai_tro = :vai_tro, dia_chi = :dia_chi, mat_khau = :mat_khau 
                                        WHERE id = :id");
            return $stmt->execute([
                ':id' => $id,
                ':ten' => $ten,
                ':email' => $email,
                ':vai_tro' => $vai_tro,
                ':dia_chi' => $dia_chi,
                ':mat_khau' => $mat_khau
            ]);
        } else {
            // Chỉ cập nhật thông tin cơ bản
            $stmt = $this->conn->prepare("UPDATE nguoi_dung 
                                        SET ten = :ten, email = :email, vai_tro = :vai_tro, dia_chi = :dia_chi 
                                        WHERE id = :id");
            return $stmt->execute([
                ':id' => $id,
                ':ten' => $ten,
                ':email' => $email,
                ':vai_tro' => $vai_tro,
                ':dia_chi' => $dia_chi
            ]);
        }
    }

    // Xóa người dùng
    public function xoaNguoiDung($id)
    {
        // Kiểm tra xem người dùng có đơn hàng không
        $checkDonHang = $this->conn->prepare("SELECT COUNT(*) FROM don_hang WHERE id_nguoi_dung = :id");
        $checkDonHang->execute([':id' => $id]);
        if ($checkDonHang->fetchColumn() > 0) {
            return false; // Không thể xóa vì có đơn hàng
        }

        // Kiểm tra xem người dùng có giỏ hàng không
        $checkGioHang = $this->conn->prepare("SELECT COUNT(*) FROM gio_hang WHERE id_nguoi_dung = :id");
        $checkGioHang->execute([':id' => $id]);
        if ($checkGioHang->fetchColumn() > 0) {
            // Xóa giỏ hàng trước
            $deleteGioHang = $this->conn->prepare("DELETE FROM gio_hang WHERE id_nguoi_dung = :id");
            $deleteGioHang->execute([':id' => $id]);
        }

        $stmt = $this->conn->prepare("DELETE FROM nguoi_dung WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Lấy thống kê người dùng
    public function layThongKeNguoiDung()
    {
        $stmt = $this->conn->prepare("SELECT 
            COUNT(*) as tong_nguoi_dung,
            COUNT(CASE WHEN vai_tro = 'admin' THEN 1 END) as so_admin,
            COUNT(CASE WHEN vai_tro = 'user' THEN 1 END) as so_user
        FROM nguoi_dung");
        $stmt->execute();
        return $stmt->fetch();
    }

    // Hàm tìm kiếm sản phẩm (admin)
    public function timKiemSanPham($tuKhoa, $giaMin = null, $giaMax = null, $mauSac = null)
    {
        $sql = "SELECT DISTINCT sp.id, sp.ten, sp.mo_ta, sp.gia, sp.hinh_anh,
                       bt.id as id_bien_the, bt.mau_sac, bt.kich_thuoc, bt.so_luong 
                FROM san_pham sp 
                LEFT JOIN bien_the_san_pham bt ON sp.id = bt.id_san_pham";

        $whereConditions = [];
        $params = [];

        // Tìm kiếm theo từ khóa (tên sản phẩm hoặc mô tả)
        if (!empty($tuKhoa)) {
            $whereConditions[] = "(sp.ten LIKE :tu_khoa OR sp.mo_ta LIKE :tu_khoa)";
            $params[':tu_khoa'] = '%' . $tuKhoa . '%';
        }

        // Lọc theo giá tối thiểu
        if ($giaMin !== null && $giaMin > 0) {
            $whereConditions[] = "sp.gia >= :gia_min";
            $params[':gia_min'] = $giaMin;
        }

        // Lọc theo giá tối đa
        if ($giaMax !== null && $giaMax > 0) {
            $whereConditions[] = "sp.gia <= :gia_max";
            $params[':gia_max'] = $giaMax;
        }

        // Lọc theo màu sắc
        if (!empty($mauSac)) {
            $whereConditions[] = "bt.mau_sac LIKE :mau_sac";
            $params[':mau_sac'] = '%' . $mauSac . '%';
        }

        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(' AND ', $whereConditions);
        }

        $sql .= " ORDER BY sp.ten ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Hàm lấy danh sách màu sắc có sẵn (admin)
    public function layDanhSachMauSac()
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT mau_sac FROM bien_the_san_pham ORDER BY mau_sac");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // ===== QUẢN LÝ PHẢN HỒI ĐƠN HÀNG =====

    // Lấy tất cả phản hồi
    public function layTatCaPhanHoi()
    {
        try {
            $sql = "SELECT ph.*, dh.id as id_don_hang, nd.ten as ten_nguoi_dung, nd.email
                    FROM phan_hoi_don_hang ph
                    JOIN don_hang dh ON ph.id_don_hang = dh.id
                    JOIN nguoi_dung nd ON ph.id_nguoi_dung = nd.id
                    ORDER BY ph.ngay_tao DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Lỗi lấy danh sách phản hồi: " . $e->getMessage());
            return [];
        }
    }

    // Cập nhật trạng thái phản hồi
    public function capNhatTrangThaiPhanHoi($idPhanHoi, $trangThai)
    {
        try {
            $sql = "UPDATE phan_hoi_don_hang SET trang_thai = :trang_thai WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':trang_thai' => $trangThai,
                ':id' => $idPhanHoi
            ]);
        } catch (Exception $e) {
            error_log("Lỗi cập nhật trạng thái phản hồi: " . $e->getMessage());
            return false;
        }
    }

    // Xóa phản hồi
    public function xoaPhanHoi($idPhanHoi)
    {
        try {
            $sql = "DELETE FROM phan_hoi_don_hang WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $idPhanHoi]);
        } catch (Exception $e) {
            error_log("Lỗi xóa phản hồi: " . $e->getMessage());
            return false;
        }
    }

    // Lấy thống kê phản hồi
    public function layThongKePhanHoi()
    {
        try {
            $sql = "SELECT 
                        COUNT(*) as tong_phan_hoi,
                        COUNT(CASE WHEN trang_thai = 'chờ duyệt' THEN 1 END) as cho_duyet,
                        COUNT(CASE WHEN trang_thai = 'đã duyệt' THEN 1 END) as da_duyet,
                        COUNT(CASE WHEN trang_thai = 'từ chối' THEN 1 END) as tu_choi,
                        AVG(diem_danh_gia) as diem_trung_binh
                    FROM phan_hoi_don_hang";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Lỗi lấy thống kê phản hồi: " . $e->getMessage());
            return [];
        }
    }

}
