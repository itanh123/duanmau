# Hướng dẫn sử dụng Sơ đồ Use Case Website Bán Hàng

## Tổng quan
Tôi đã tạo cho bạn 3 phiên bản sơ đồ use case cho website bán hàng:

1. **PlantUML** (`ecommerce_usecase.puml`) - Chuyên nghiệp, dễ chỉnh sửa
2. **Mermaid** (`ecommerce_usecase_mermaid.md`) - Xem trực tiếp trong markdown
3. **Python + Matplotlib** (`create_usecase_diagram.py`) - Tạo sơ đồ bằng code

## 1. Sử dụng PlantUML (Khuyến nghị)

### Cài đặt:
- **VS Code**: Cài extension "PlantUML" của jebbs
- **Online**: Truy cập [PlantUML Online Server](http://www.plantuml.com/plantuml/uml/)

### Cách sử dụng:
1. Mở file `ecommerce_usecase.puml` trong VS Code
2. Sơ đồ sẽ tự động render
3. Để xuất hình ảnh: Ctrl+Shift+P → "PlantUML: Export Current Diagram"

### Ưu điểm:
- Chuyên nghiệp, chuẩn UML
- Dễ chỉnh sửa và bảo trì
- Hỗ trợ nhiều định dạng xuất (PNG, SVG, PDF)

## 2. Sử dụng Mermaid

### Cách sử dụng:
1. Mở file `ecommerce_usecase_mermaid.md`
2. Sơ đồ sẽ hiển thị trực tiếp nếu editor hỗ trợ Mermaid
3. Hoặc copy code mermaid vào [Mermaid Live Editor](https://mermaid.live/)

### Ưu điểm:
- Đơn giản, dễ đọc
- Hỗ trợ tốt trong GitHub, GitLab
- Không cần cài đặt gì thêm

## 3. Sử dụng Python + Matplotlib

### Cài đặt:
```bash
pip install -r requirements.txt
```

### Chạy script:
```bash
python create_usecase_diagram.py
```

### Kết quả:
- Hiển thị sơ đồ trên màn hình
- Lưu file `ecommerce_usecase_diagram.png`

### Ưu điểm:
- Tùy chỉnh hoàn toàn
- Có thể tích hợp vào ứng dụng
- Dễ dàng thay đổi style và layout

## Cấu trúc sơ đồ

### Các Actor chính:
- **Khách hàng**: Người dùng cơ bản
- **Khách hàng đã đăng ký**: Có tài khoản
- **Quản trị viên**: Quản lý hệ thống
- **Nhân viên bán hàng**: Xử lý đơn hàng
- **Hệ thống thanh toán**: Xử lý giao dịch
- **Hệ thống vận chuyển**: Quản lý logistics

### Các nhóm chức năng:
1. **Quản lý tài khoản**: Đăng ký, đăng nhập, cập nhật thông tin
2. **Mua sắm**: Tìm kiếm, xem sản phẩm, giỏ hàng, đặt hàng
3. **Đánh giá và bình luận**: Đánh giá sản phẩm, viết bình luận
4. **Hỗ trợ khách hàng**: Liên hệ và theo dõi yêu cầu hỗ trợ
5. **Quản lý hệ thống**: Quản lý người dùng, sản phẩm, đơn hàng
6. **Hỗ trợ bán hàng**: Xử lý đơn hàng và khiếu nại
7. **Thanh toán**: Xử lý giao dịch và hoàn tiền
8. **Vận chuyển**: Tính phí và theo dõi đơn hàng

## Chỉnh sửa sơ đồ

### Thêm Use Case mới:
1. Mở file PlantUML hoặc Python
2. Thêm use case vào nhóm phù hợp
3. Vẽ mối quan hệ với actor tương ứng

### Thêm Actor mới:
1. Định nghĩa actor trong file
2. Vẽ các mối quan hệ với use case
3. Cập nhật tài liệu

### Thay đổi mối quan hệ:
- **Include (<<include>>)**: Mối quan hệ bắt buộc
- **Extend (<<extend>>)**: Mối quan hệ mở rộng
- **Association**: Mối quan hệ cơ bản

## Lưu ý quan trọng

### Khi sử dụng PlantUML:
- Cần có Java runtime
- Extension VS Code cần internet để render
- Có thể export ra nhiều định dạng

### Khi sử dụng Python:
- Cần cài đặt matplotlib
- Font tiếng Việt có thể không hiển thị đúng trên một số hệ thống
- Có thể điều chỉnh kích thước và màu sắc

### Khi sử dụng Mermaid:
- Hỗ trợ tốt trong GitHub
- Có thể không hiển thị trong một số editor
- Syntax đơn giản hơn PlantUML

## Hỗ trợ và góp ý

Nếu bạn cần:
- Thêm use case mới
- Thay đổi layout
- Thêm actor mới
- Điều chỉnh style

Hãy cho tôi biết và tôi sẽ giúp bạn cập nhật sơ đồ!