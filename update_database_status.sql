-- Cập nhật database để thêm trạng thái "đã xác nhận"
-- Chạy lệnh này trong phpMyAdmin hoặc MySQL console

-- Cập nhật bảng don_hang để thêm trạng thái "đã xác nhận"
ALTER TABLE `don_hang` 
MODIFY COLUMN `trang_thai` enum('chờ xử lý','đã xác nhận','đang giao','đã giao','đã huỷ') COLLATE utf8mb4_unicode_ci DEFAULT 'chờ xử lý';

-- Cập nhật các đơn hàng hiện có từ "chờ xử lý" sang "đã xác nhận" nếu cần
-- UPDATE don_hang SET trang_thai = 'đã xác nhận' WHERE trang_thai = 'chờ xử lý' AND id IN (SELECT id FROM (SELECT id FROM don_hang WHERE trang_thai = 'chờ xử lý' LIMIT 5) AS temp);

-- Kiểm tra cấu trúc bảng sau khi cập nhật
DESCRIBE don_hang;
