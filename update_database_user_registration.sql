-- Cập nhật database để thêm trường địa chỉ và số điện thoại cho bảng nguoi_dung
-- Chạy lệnh này trong phpMyAdmin hoặc MySQL console

-- Thêm cột địa chỉ vào bảng nguoi_dung
ALTER TABLE `nguoi_dung` 
ADD COLUMN `dia_chi` TEXT NULL AFTER `email`;

-- Thêm cột số điện thoại vào bảng nguoi_dung
ALTER TABLE `nguoi_dung` 
ADD COLUMN `so_dien_thoai` VARCHAR(15) NULL AFTER `dia_chi`;

-- Kiểm tra cấu trúc bảng sau khi cập nhật
DESCRIBE nguoi_dung;

-- Cập nhật các tài khoản hiện có (nếu cần)
-- UPDATE nguoi_dung SET dia_chi = 'Chưa cập nhật', so_dien_thoai = 'Chưa cập nhật' WHERE dia_chi IS NULL;
