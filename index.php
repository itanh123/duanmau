<?php
session_start();
require_once "commons/loader.php";

$act = $_GET['act'] ?? '/';

$admin = new Admincontroller();
$controller = new ExampleController();

match ($act) {
    "/" => $controller->home(),
    "home" => $admin->home(),
    "sua" => $admin->sua($_GET['id'] ?? null),
    "xoa" => $admin->xoa($_GET['id'] ?? null),
    "them" => $admin->them(),
    "dangky" => $controller->dangky(),
    "hienthi" => $controller->hienthi(),
    "xemSanPham" => $controller->xemSanPham($_GET['id'] ?? null),
    "dathang" => $controller->dathang(),
    "login" => $controller->login(),
    "themvaogio" => $controller->themvaogio(),
    "xemGioHang" => $controller->xemGioHang(),
    "capNhatGioHang" => $controller->capNhatGioHang(),
    "xoaKhoiGioHang" => $controller->xoaKhoiGioHang(),
    "apDungMaGiamGia" => $controller->apDungMaGiamGia(),
    "xoaMaGiamGia" => $controller->xoaMaGiamGia(),
    "xemDonHang" => $controller->xemDonHang(),
    "danhSachDonHang" => $controller->danhSachDonHang(),
    "timKiemSanPham" => $controller->timKiemSanPham(),
    "themPhanHoi" => $controller->themPhanHoi(),
    "huyDonHang" => $controller->huyDonHang(),
    "xemTrangThaiDonHang" => $controller->xemTrangThaiDonHang($_GET['id'] ?? null),
    "logout" => $controller->logout(),
    // Quản lý biến thể sản phẩm
    "quan_ly_bien_the" => $admin->quanLyBienThe(),
    "them_bien_the" => $admin->themBienThe(),
    "sua_bien_the" => $admin->suaBienThe($_GET['id'] ?? null),
    "xoa_bien_the" => $admin->xoaBienThe($_GET['id'] ?? null),
    // Quản lý đơn hàng
    "ql_donhang" => $admin->quanLyDonHang(),
    "chi_tiet_don_hang" => $admin->chiTietDonHang($_GET['id'] ?? null),
    "cap_nhat_trang_thai_don_hang" => $admin->capNhatTrangThaiDonHang(),
    "huy_don_hang" => $admin->huyDonHang(),
    "bao_cao_don_hang" => $admin->baoCaoDonHang(),
    "tim_kiem_don_hang" => $admin->timKiemDonHang(),
    
    // Quản lý phản hồi
    "quan_ly_phan_hoi" => $admin->quanLyPhanHoi(),
    "cap_nhat_trang_thai_phan_hoi" => $admin->capNhatTrangThaiPhanHoi(),
    "xoa_phan_hoi" => $admin->xoaPhanHoi(),
    // Quản lý người dùng
    "ql_nguoidung" => $admin->quanLyNguoiDung(),
    "them_nguoi_dung" => $admin->themNguoiDung(),
    "sua_nguoi_dung" => $admin->suaNguoiDung($_GET['id'] ?? null),
    "xoa_nguoi_dung" => $admin->xoaNguoiDung($_GET['id'] ?? null),
    default => notFound(),
};
