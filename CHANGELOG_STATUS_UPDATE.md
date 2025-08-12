# Changelog - Cập nhật hệ thống trạng thái đơn hàng

## Tổng quan
Đã thêm trạng thái mới "đã xác nhận" và cập nhật logic để khi đơn hàng đang ở trạng thái "đang giao" hoặc "đã giao" thì không thể hủy được nữa.

## Các thay đổi chính

### 1. Database
- **File**: `update_database_status.sql`
- **Thay đổi**: Cập nhật bảng `don_hang` để thêm trạng thái "đã xác nhận"
- **SQL**: 
  ```sql
  ALTER TABLE `don_hang` 
  MODIFY COLUMN `trang_thai` enum('chờ xử lý','đã xác nhận','đang giao','đã giao','đã huỷ') 
  COLLATE utf8mb4_unicode_ci DEFAULT 'chờ xử lý';
  ```

### 2. Model (AdminModels.php)
- **Thêm trạng thái mới** vào hàm `layDanhSachTrangThaiDonHang()`
- **Cập nhật thống kê** để bao gồm trạng thái "đã xác nhận"

### 3. Views

#### 3.1 quan_ly_don_hang.php
- **Thêm trạng thái "đã xác nhận"** với icon và màu sắc mới
- **Cập nhật thống kê**: Thay đổi từ 4 cột thành 6 cột (col-md-2)
- **Cập nhật logic hiển thị nút**:
  - Nút "Cập nhật trạng thái": Hiển thị khi trạng thái là "chờ xử lý", "đã xác nhận", hoặc "đang giao"
  - Nút "Hủy đơn hàng": Chỉ hiển thị khi trạng thái là "chờ xử lý" hoặc "đã xác nhận"
- **Cập nhật JavaScript**: Logic chuyển đổi trạng thái mới

#### 3.2 chi_tiet_don_hang.php
- **Thêm trạng thái "đã xác nhận"** với icon và màu sắc mới
- **Cập nhật logic hiển thị nút** tương tự như quan_ly_don_hang.php
- **Cập nhật JavaScript** để xử lý trạng thái mới

#### 3.3 tim_kiem_don_hang.php
- **Thêm trạng thái "đã xác nhận"** với icon và màu sắc mới
- **Cập nhật logic hiển thị nút** tương tự như các file khác
- **Cập nhật JavaScript** để xử lý trạng thái mới

## Logic chuyển đổi trạng thái mới

### Trước đây:
- **Từ "chờ xử lý"** → có thể chuyển sang: "đang giao", "đã giao", "đã huỷ"
- **Từ "đang giao"** → có thể chuyển sang: "đã giao", "đã huỷ"

### Bây giờ:
- **Từ "chờ xử lý"** → có thể chuyển sang: "đã xác nhận", "đã huỷ"
- **Từ "đã xác nhận"** → có thể chuyển sang: "đang giao", "đã huỷ"
- **Từ "đang giao"** → có thể chuyển sang: "đã giao" (không thể hủy)
- **Từ "đã giao"** → không thể chuyển sang trạng thái khác
- **Từ "đã huỷ"** → không thể chuyển sang trạng thái khác

## Quy tắc hủy đơn hàng mới

### Có thể hủy:
- ✅ Trạng thái "chờ xử lý"
- ✅ Trạng thái "đã xác nhận"

### Không thể hủy:
- ❌ Trạng thái "đang giao"
- ❌ Trạng thái "đã giao"
- ❌ Trạng thái "đã huỷ"

## Thống kê mới
Hệ thống thống kê giờ đây hiển thị 6 cột:
1. **Tổng đơn hàng** (bg-primary)
2. **Chờ xử lý** (bg-warning)
3. **Đã xác nhận** (bg-info) - MỚI
4. **Đang giao** (bg-secondary) - MỚI
5. **Đã giao** (bg-success)
6. **Doanh thu** (bg-dark)

## Icon và màu sắc
- **Chờ xử lý**: `bi-clock` + `bg-warning`
- **Đã xác nhận**: `bi-check-circle-fill` + `bg-primary` - MỚI
- **Đang giao**: `bi-truck` + `bg-info`
- **Đã giao**: `bi-check-circle` + `bg-success`
- **Đã huỷ**: `bi-x-circle` + `bg-danger`

## Lưu ý quan trọng
1. **Cần chạy SQL** trong `update_database_status.sql` trước khi sử dụng
2. **Tất cả các trang** đã được cập nhật để nhất quán
3. **Logic bảo mật** đã được cải thiện - không thể hủy đơn hàng khi đang giao hoặc đã giao
4. **Giao diện** đã được tối ưu hóa với 6 cột thống kê

## Kiểm tra
Sau khi cập nhật, hãy kiểm tra:
- [ ] Database đã được cập nhật với trạng thái mới
- [ ] Tất cả các trang hiển thị trạng thái mới đúng
- [ ] Logic chuyển đổi trạng thái hoạt động chính xác
- [ ] Nút hủy đơn hàng chỉ hiển thị ở các trạng thái phù hợp
- [ ] Thống kê hiển thị đầy đủ 6 cột
