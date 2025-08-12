<?php
class Example
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }
    // hàm thêm người đùng hay là đăng ký tài khoản
    public function dangky($ten, $email, $mat_khau)
    {
        $stmt = $this->conn->prepare("INSERT INTO nguoi_dung (ten, email, mat_khau, vai_tro) VALUES (:ten, :email, :mat_khau, 'user')");
        return $stmt->execute(
            [
                ':ten' => $ten,
                ':email' => $email,
                ':mat_khau' => $mat_khau
            ]
        );
    }

    // Kiểm tra email đã tồn tại chưa
    public function kiemTraEmailTonTai($email)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM nguoi_dung WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    // hàm xem chi tiết sản phẩn
    public function laySanPham($id)
    {
        $stmt = $this->conn->prepare("SELECT sp.id as id_san_pham, sp.ten, sp.mo_ta, sp.gia, sp.hinh_anh,
                                            bt.id, bt.mau_sac, bt.kich_thuoc, bt.so_luong
                                     FROM san_pham sp
                                     LEFT JOIN bien_the_san_pham bt ON sp.id = bt.id_san_pham
                                     WHERE sp.id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // hàm hiện thị tất cả sản phẩm
    public function hienthi()
    {
        $stmt = $this->conn->prepare("SELECT sp.id as id_san_pham, sp.ten, sp.mo_ta, sp.gia, sp.hinh_anh, 
                                            bt.id as id_bien_the, bt.mau_sac, bt.kich_thuoc, bt.so_luong 
                                    FROM san_pham sp 
                                    JOIN bien_the_san_pham bt ON sp.id = bt.id_san_pham 
                                    WHERE bt.so_luong > 0");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // hàm đặt hàng
    public function taoDonHang($id_nguoi_dung, $tong_tien)
    {
        $sql = "INSERT INTO don_hang (id_nguoi_dung, tong_tien) 
                VALUES (:id_nguoi_dung, :tong_tien)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_nguoi_dung', $id_nguoi_dung);
        $stmt->bindParam(':tong_tien', $tong_tien);
        $stmt->execute();

        return $this->conn->lastInsertId(); // trả về id đơn hàng vừa tạo
    }

    //hàm lấy ra thông tin người đùng đùng đẻ đăng nhập
    public function kiemTraDangNhap($email, $mat_khau)
    {
        $sql = "SELECT * FROM nguoi_dung WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // So sánh mật khẩu (đã mã hóa hoặc plain text)
        if ($user && $mat_khau === $user['mat_khau']) {
            return $user;
        }
        return false; // sai thông tin
    }

    public function themVaoGioHang($idNguoiDung, $idBienThe, $soLuong)
    {
        try {
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $checkSql = "SELECT id, so_luong FROM gio_hang 
                         WHERE id_nguoi_dung = :id_nguoi_dung AND id_bien_the = :id_bien_the";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([
                ':id_nguoi_dung' => $idNguoiDung,
                ':id_bien_the' => $idBienThe
            ]);
            $existingItem = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                // Nếu đã có, cập nhật số lượng
                $newQuantity = $existingItem['so_luong'] + $soLuong;
                $updateSql = "UPDATE gio_hang SET so_luong = :so_luong 
                              WHERE id = :id";
                $updateStmt = $this->conn->prepare($updateSql);
                return $updateStmt->execute([
                    ':so_luong' => $newQuantity,
                    ':id' => $existingItem['id']
                ]);
            } else {
                // Nếu chưa có, thêm mới
                $insertSql = "INSERT INTO gio_hang (id_nguoi_dung, id_bien_the, so_luong) 
                              VALUES (:id_nguoi_dung, :id_bien_the, :so_luong)";
                $insertStmt = $this->conn->prepare($insertSql);
                return $insertStmt->execute([
                    ':id_nguoi_dung' => $idNguoiDung,
                    ':id_bien_the' => $idBienThe,
                    ':so_luong' => $soLuong
                ]);
            }
        } catch (PDOException $e) {
            error_log("Lỗi thêm vào giỏ hàng: " . $e->getMessage());
            return false;
        }
    }

    // Hàm lấy thông tin giỏ hàng của người dùng
    public function layGioHang($idNguoiDung)
    {
        $sql = "SELECT gh.id, gh.id_bien_the, gh.so_luong, sp.ten as ten_san_pham, sp.gia, sp.hinh_anh,
                       bt.mau_sac, bt.kich_thuoc, bt.so_luong as ton_kho
                FROM gio_hang gh
                JOIN bien_the_san_pham bt ON gh.id_bien_the = bt.id
                JOIN san_pham sp ON bt.id_san_pham = sp.id
                WHERE gh.id_nguoi_dung = :id_nguoi_dung";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_nguoi_dung' => $idNguoiDung]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm cập nhật số lượng trong giỏ hàng
    public function capNhatSoLuongGioHang($idGioHang, $soLuong)
    {
        $sql = "UPDATE gio_hang SET so_luong = :so_luong WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':so_luong' => $soLuong,
            ':id' => $idGioHang
        ]);
    }

    // Hàm xóa sản phẩm khỏi giỏ hàng
    public function xoaKhoiGioHang($idGioHang, $idNguoiDung)
    {
        $sql = "DELETE FROM gio_hang WHERE id = :id AND id_nguoi_dung = :id_nguoi_dung";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $idGioHang,
            ':id_nguoi_dung' => $idNguoiDung
        ]);
    }

    // Hàm xóa toàn bộ giỏ hàng của người dùng
    public function xoaGioHang($idNguoiDung)
    {
        $sql = "DELETE FROM gio_hang WHERE id_nguoi_dung = :id_nguoi_dung";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id_nguoi_dung' => $idNguoiDung]);
    }

    // Hàm thêm chi tiết đơn hàng
    public function themChiTietDonHang($idDonHang, $idBienThe, $soLuong, $gia)
    {
        try {
            $sql = "INSERT INTO chi_tiet_don_hang (id_don_hang, id_bien_the, so_luong, gia) 
                    VALUES (:id_don_hang, :id_bien_the, :so_luong, :gia)";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id_don_hang' => $idDonHang,
                ':id_bien_the' => $idBienThe,
                ':so_luong' => $soLuong,
                ':gia' => $gia
            ]);
        } catch (Exception $e) {
            error_log("Lỗi thêm chi tiết đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // Hàm cập nhật tồn kho
    public function capNhatTonKho($idBienThe, $soLuongDaBan)
    {
        try {
            // Kiểm tra số lượng hiện tại
            $checkSql = "SELECT so_luong FROM bien_the_san_pham WHERE id = :id_bien_the";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([':id_bien_the' => $idBienThe]);
            $currentStock = $checkStmt->fetchColumn();

            if ($currentStock < $soLuongDaBan) {
                throw new Exception("Không đủ hàng trong kho");
            }

            // Cập nhật số lượng tồn kho
            $sql = "UPDATE bien_the_san_pham SET so_luong = so_luong - :so_luong_da_ban 
                    WHERE id = :id_bien_the AND so_luong >= :so_luong_da_ban";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                ':so_luong_da_ban' => $soLuongDaBan,
                ':id_bien_the' => $idBienThe
            ]);

            if ($stmt->rowCount() == 0) {
                throw new Exception("Không thể cập nhật tồn kho");
            }

            return true;
        } catch (Exception $e) {
            error_log("Lỗi cập nhật tồn kho: " . $e->getMessage());
            return false;
        }
    }

    // Hàm lấy thông tin đơn hàng
    public function layDonHang($idDonHang, $idNguoiDung = null)
    {
        $sql = "SELECT dh.*, nd.ten as ten_nguoi_dung, nd.email 
                FROM don_hang dh
                JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
                WHERE dh.id = :id_don_hang";

        if ($idNguoiDung) {
            $sql .= " AND dh.id_nguoi_dung = :id_nguoi_dung";
        }

        $stmt = $this->conn->prepare($sql);
        $params = [':id_don_hang' => $idDonHang];

        if ($idNguoiDung) {
            $params[':id_nguoi_dung'] = $idNguoiDung;
        }

        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Hàm lấy chi tiết đơn hàng
    public function layChiTietDonHang($idDonHang)
    {
        try {
            // Kiểm tra xem bảng có cột id_don_hang không
            $checkSql = "DESCRIBE chi_tiet_don_hang";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute();
            $columns = $checkStmt->fetchAll(PDO::FETCH_COLUMN);

            if (in_array('id_don_hang', $columns)) {
                // Nếu có cột id_don_hang
                $sql = "SELECT ctdh.*, sp.ten as ten_san_pham, sp.hinh_anh, bt.mau_sac, bt.kich_thuoc
                        FROM chi_tiet_don_hang ctdh
                        JOIN bien_the_san_pham bt ON ctdh.id_bien_the = bt.id
                        JOIN san_pham sp ON bt.id_san_pham = sp.id
                        WHERE ctdh.id_don_hang = :id_don_hang";
            } else {
                // Nếu không có, sử dụng id_san_pham
                $sql = "SELECT ctdh.*, sp.ten as ten_san_pham, sp.hinh_anh, bt.mau_sac, bt.kich_thuoc
                        FROM chi_tiet_don_hang ctdh
                        JOIN bien_the_san_pham bt ON ctdh.id_bien_the = bt.id
                        JOIN san_pham sp ON bt.id_san_pham = sp.id
                        WHERE ctdh.id_san_pham = :id_don_hang";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_don_hang' => $idDonHang]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi lấy chi tiết đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    // Hàm lấy danh sách đơn hàng của người dùng
    public function layDanhSachDonHang($idNguoiDung)
    {
        try {
            // Kiểm tra xem bảng có cột id_don_hang không
            $checkSql = "DESCRIBE chi_tiet_don_hang";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute();
            $columns = $checkStmt->fetchAll(PDO::FETCH_COLUMN);

            if (in_array('id_don_hang', $columns)) {
                // Nếu có cột id_don_hang
                $sql = "SELECT dh.*, 
                               (SELECT COUNT(*) FROM chi_tiet_don_hang WHERE id_don_hang = dh.id) as so_san_pham
                        FROM don_hang dh
                        WHERE dh.id_nguoi_dung = :id_nguoi_dung
                        ORDER BY dh.ngay DESC";
            } else {
                // Nếu không có, sử dụng id_san_pham
                $sql = "SELECT dh.*, 
                               (SELECT COUNT(*) FROM chi_tiet_don_hang WHERE id_san_pham = dh.id) as so_san_pham
                        FROM don_hang dh
                        WHERE dh.id_nguoi_dung = :id_nguoi_dung
                        ORDER BY dh.ngay DESC";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_nguoi_dung' => $idNguoiDung]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi lấy danh sách đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    // Hàm kiểm tra tồn kho
    public function kiemTraTonKho($idBienThe, $soLuongYeuCau)
    {
        try {
            $sql = "SELECT so_luong FROM bien_the_san_pham WHERE id = :id_bien_the";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_bien_the' => $idBienThe]);
            $tonKho = $stmt->fetchColumn();
            
            if ($tonKho === false) {
                error_log("Không tìm thấy biến thể sản phẩm với ID: $idBienThe");
                return false;
            }
            
            $duKho = $tonKho >= $soLuongYeuCau;
            error_log("Kiểm tra tồn kho - ID biến thể: $idBienThe, Tồn kho: $tonKho, Yêu cầu: $soLuongYeuCau, Đủ kho: " . ($duKho ? 'Có' : 'Không'));
            
            return $duKho;
            
        } catch (Exception $e) {
            error_log("Lỗi kiểm tra tồn kho: " . $e->getMessage());
            return false;
        }
    }

    // Hàm lấy thông tin biến thể sản phẩm
    public function layBienTheSanPham($idBienThe)
    {
        try {
            $sql = "SELECT bt.*, sp.ten as ten_san_pham, sp.gia, sp.hinh_anh
                    FROM bien_the_san_pham bt
                    JOIN san_pham sp ON bt.id_san_pham = sp.id
                    WHERE bt.id = :id_bien_the";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_bien_the' => $idBienThe]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                error_log("Không tìm thấy biến thể sản phẩm với ID: $idBienThe");
                return [
                    'ten_san_pham' => 'Không xác định',
                    'mau_sac' => 'Không xác định',
                    'kich_thuoc' => 'Không xác định',
                    'gia' => 0,
                    'hinh_anh' => ''
                ];
            }
            
            // Đảm bảo các giá trị không bị NULL
            $result['ten_san_pham'] = $result['ten_san_pham'] ?? 'Không xác định';
            $result['mau_sac'] = $result['mau_sac'] ?? 'Không xác định';
            $result['kich_thuoc'] = $result['kich_thuoc'] ?? 'Không xác định';
            
            error_log("Lấy biến thể sản phẩm thành công: " . print_r($result, true));
            return $result;
            
        } catch (Exception $e) {
            error_log("Lỗi lấy biến thể sản phẩm: " . $e->getMessage());
            return [
                'ten_san_pham' => 'Không xác định',
                'mau_sac' => 'Không xác định',
                'kich_thuoc' => 'Không xác định',
                'gia' => 0,
                'hinh_anh' => ''
            ];
        }
    }

    // Hàm kiểm tra mã giảm giá
    public function kiemTraMaGiamGia($maGiamGia)
    {
        try {
            $sql = "SELECT * FROM ma_giam_gia 
                    WHERE ma = :ma AND han_dung >= CURDATE()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':ma' => $maGiamGia]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi kiểm tra mã giảm giá: " . $e->getMessage());
            return false;
        }
    }

    // Hàm tính toán giá sau khi áp dụng mã giảm giá
    public function tinhGiaSauGiamGia($tongTien, $phanTramGiam)
    {
        $soTienGiam = ($tongTien * $phanTramGiam) / 100;
        return $tongTien - $soTienGiam;
    }

    // Hàm lưu mã giảm giá đã sử dụng vào session
    public function luuMaGiamGiaVaoSession($maGiamGia, $phanTramGiam, $soTienGiam)
    {
        if (!isset($_SESSION['ma_giam_gia'])) {
            $_SESSION['ma_giam_gia'] = [];
        }
        
        $_SESSION['ma_giam_gia'] = [
            'ma' => $maGiamGia,
            'phan_tram' => $phanTramGiam,
            'so_tien_giam' => $soTienGiam,
            'ngay_ap_dung' => date('Y-m-d H:i:s')
        ];
        
        return true;
    }

    // Hàm xóa mã giảm giá khỏi session
    public function xoaMaGiamGiaKhoiSession()
    {
        if (isset($_SESSION['ma_giam_gia'])) {
            unset($_SESSION['ma_giam_gia']);
        }
        return true;
    }

    // Hàm lấy thông tin mã giảm giá từ session
    public function layMaGiamGiaTuSession()
    {
        if (isset($_SESSION['ma_giam_gia'])) {
            return $_SESSION['ma_giam_gia'];
        }
        return null;
    }

    // Hàm tìm kiếm sản phẩm
    public function timKiemSanPham($tuKhoa, $giaMin = null, $giaMax = null, $mauSac = null)
    {
        $sql = "SELECT DISTINCT sp.id as id_san_pham, sp.ten, sp.mo_ta, sp.gia, sp.hinh_anh, 
                       bt.id as id_bien_the, bt.mau_sac, bt.kich_thuoc, bt.so_luong 
                FROM san_pham sp 
                JOIN bien_the_san_pham bt ON sp.id = bt.id_san_pham 
                WHERE bt.so_luong > 0";
        
        $params = [];
        
        // Tìm kiếm theo từ khóa (tên sản phẩm hoặc mô tả)
        if (!empty($tuKhoa)) {
            $sql .= " AND (sp.ten LIKE :tu_khoa OR sp.mo_ta LIKE :tu_khoa)";
            $params[':tu_khoa'] = '%' . $tuKhoa . '%';
        }
        
        // Lọc theo giá tối thiểu
        if ($giaMin !== null && $giaMin > 0) {
            $sql .= " AND sp.gia >= :gia_min";
            $params[':gia_min'] = $giaMin;
        }
        
        // Lọc theo giá tối đa
        if ($giaMax !== null && $giaMax > 0) {
            $sql .= " AND sp.gia <= :gia_max";
            $params[':gia_max'] = $giaMax;
        }
        
        // Lọc theo màu sắc
        if (!empty($mauSac)) {
            $sql .= " AND bt.mau_sac LIKE :mau_sac";
            $params[':mau_sac'] = '%' . $mauSac . '%';
        }
        
        $sql .= " ORDER BY sp.ten ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Hàm lấy danh sách màu sắc có sẵn
    public function layDanhSachMauSac()
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT mau_sac FROM bien_the_san_pham WHERE so_luong > 0 ORDER BY mau_sac");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // ===== CHỨC NĂNG PHẢN HỒI ĐƠN HÀNG =====

    // Thêm phản hồi mới
    public function themPhanHoi($idDonHang, $idNguoiDung, $noiDung, $diemDanhGia)
    {
        try {
            // Kiểm tra xem đơn hàng đã được giao chưa
            $sql = "SELECT trang_thai FROM don_hang WHERE id = :id_don_hang AND id_nguoi_dung = :id_nguoi_dung";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_don_hang' => $idDonHang, ':id_nguoi_dung' => $idNguoiDung]);
            $donHang = $stmt->fetch();

            if (!$donHang || $donHang['trang_thai'] !== 'đã giao') {
                return false; // Chỉ cho phép phản hồi khi đơn hàng đã giao
            }

            // Kiểm tra xem đã có phản hồi cho đơn hàng này chưa
            $checkSql = "SELECT COUNT(*) FROM phan_hoi_don_hang WHERE id_don_hang = :id_don_hang";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([':id_don_hang' => $idDonHang]);
            
            if ($checkStmt->fetchColumn() > 0) {
                return false; // Đã có phản hồi cho đơn hàng này
            }

            // Thêm phản hồi mới
            $sql = "INSERT INTO phan_hoi_don_hang (id_don_hang, id_nguoi_dung, noi_dung, diem_danh_gia) 
                    VALUES (:id_don_hang, :id_nguoi_dung, :noi_dung, :diem_danh_gia)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id_don_hang' => $idDonHang,
                ':id_nguoi_dung' => $idNguoiDung,
                ':noi_dung' => $noiDung,
                ':diem_danh_gia' => $diemDanhGia
            ]);
        } catch (Exception $e) {
            error_log("Lỗi thêm phản hồi: " . $e->getMessage());
            return false;
        }
    }

    // Lấy phản hồi của đơn hàng
    public function layPhanHoiDonHang($idDonHang)
    {
        try {
            $sql = "SELECT ph.*, nd.ten as ten_nguoi_dung 
                    FROM phan_hoi_don_hang ph
                    JOIN nguoi_dung nd ON ph.id_nguoi_dung = nd.id
                    WHERE ph.id_don_hang = :id_don_hang";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_don_hang' => $idDonHang]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Lỗi lấy phản hồi đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra xem đơn hàng có thể phản hồi không
    public function coThePhanHoi($idDonHang, $idNguoiDung)
    {
        try {
            $sql = "SELECT trang_thai FROM don_hang 
                    WHERE id = :id_don_hang AND id_nguoi_dung = :id_nguoi_dung";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_don_hang' => $idDonHang, ':id_nguoi_dung' => $idNguoiDung]);
            $donHang = $stmt->fetch();

            if (!$donHang) {
                return false;
            }

            // Chỉ cho phép phản hồi khi đơn hàng đã giao
            if ($donHang['trang_thai'] !== 'đã giao') {
                return false;
            }

            // Kiểm tra xem đã có phản hồi chưa
            $checkSql = "SELECT COUNT(*) FROM phan_hoi_don_hang WHERE id_don_hang = :id_don_hang";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([':id_don_hang' => $idDonHang]);
            
            return $checkStmt->fetchColumn() == 0; // Trả về true nếu chưa có phản hồi
        } catch (Exception $e) {
            error_log("Lỗi kiểm tra khả năng phản hồi: " . $e->getMessage());
            return false;
        }
    }
}
