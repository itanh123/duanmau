# Sơ đồ Use Case - Website Bán Hàng

## Mô tả
Sơ đồ use case này mô tả đầy đủ các chức năng và tương tác trong một website bán hàng trực tuyến.

## Các Actor (Người tham gia)

### 1. Khách hàng (Customer)
- Người dùng chưa đăng ký tài khoản
- Có thể xem sản phẩm, thêm vào giỏ hàng và đặt hàng

### 2. Khách hàng đã đăng ký (Registered Customer)
- Người dùng có tài khoản
- Có thêm quyền: cập nhật thông tin, xem lịch sử, đánh giá sản phẩm

### 3. Quản trị viên (Admin)
- Quản lý toàn bộ hệ thống
- Quản lý người dùng, sản phẩm, đơn hàng, báo cáo

### 4. Nhân viên bán hàng (Sales Staff)
- Xử lý đơn hàng và hỗ trợ khách hàng
- Cập nhật trạng thái đơn hàng

### 5. Hệ thống thanh toán (Payment System)
- Xử lý các giao dịch thanh toán
- Quản lý hoàn tiền và xác thực

### 6. Hệ thống vận chuyển (Shipping System)
- Tính phí vận chuyển
- Theo dõi và cập nhật trạng thái vận chuyển

## Các nhóm Use Case chính

### Quản lý tài khoản
- Đăng ký, đăng nhập, quên mật khẩu
- Cập nhật thông tin cá nhân
- Xem lịch sử đơn hàng

### Mua sắm
- Tìm kiếm và xem sản phẩm
- Quản lý giỏ hàng
- Đặt hàng và chọn phương thức thanh toán/vận chuyển

### Đánh giá và bình luận
- Đánh giá sản phẩm
- Viết bình luận
- Xem đánh giá của người khác

### Hỗ trợ khách hàng
- Liên hệ và tạo yêu cầu hỗ trợ
- Theo dõi yêu cầu hỗ trợ

### Quản lý hệ thống (Admin)
- Quản lý người dùng, sản phẩm, danh mục
- Quản lý đơn hàng, kho hàng, khuyến mãi
- Xem báo cáo thống kê

## Cách sử dụng

### Để xem sơ đồ:
1. Cài đặt PlantUML extension trong VS Code hoặc sử dụng online PlantUML
2. Mở file `ecommerce_usecase.puml`
3. Sơ đồ sẽ được render tự động

### Để chỉnh sửa:
1. Chỉnh sửa file `.puml`
2. Thêm/bớt use case, actor hoặc relationship
3. Lưu file để cập nhật sơ đồ

## Mối quan hệ

### Include (<<include>>)
- Đặt hàng bao gồm: chọn thanh toán, vận chuyển
- Quản lý sản phẩm bao gồm: quản lý kho hàng
- Quản lý đơn hàng bao gồm: cập nhật trạng thái

### Extend (<<extend>>)
- Đánh giá và bình luận mở rộng từ việc xem đánh giá

## Lưu ý
- Sơ đồ này có thể được mở rộng thêm tùy theo yêu cầu cụ thể
- Có thể thêm các use case phụ như: quản lý wishlist, so sánh sản phẩm, etc.
- Các relationship có thể được điều chỉnh theo logic nghiệp vụ thực tế