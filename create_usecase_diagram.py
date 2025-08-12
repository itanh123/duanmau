#!/usr/bin/env python3
"""
Script tạo sơ đồ Use Case cho website bán hàng sử dụng matplotlib
"""

import matplotlib.pyplot as plt
import matplotlib.patches as patches
from matplotlib.patches import FancyBboxPatch, ConnectionPatch
import numpy as np

# Thiết lập font tiếng Việt
plt.rcParams['font.family'] = 'DejaVu Sans'
plt.rcParams['font.size'] = 10

def create_use_case_diagram():
    """Tạo sơ đồ use case"""
    
    # Tạo figure và axis
    fig, ax = plt.subplots(1, 1, figsize=(20, 16))
    ax.set_xlim(0, 20)
    ax.set_ylim(0, 16)
    ax.axis('off')
    
    # Định nghĩa màu sắc
    colors = {
        'actor': '#e3f2fd',
        'usecase': '#f3e5f5',
        'system': '#e8f5e8',
        'border': '#1976d2'
    }
    
    # Vẽ các Actor
    actors = [
        ('Khách hàng', 1, 14),
        ('Khách hàng\nđã đăng ký', 1, 12),
        ('Quản trị viên', 1, 10),
        ('Nhân viên\nbán hàng', 1, 8),
        ('Hệ thống\nthanh toán', 1, 6),
        ('Hệ thống\nvận chuyển', 1, 4)
    ]
    
    for name, x, y in actors:
        # Vẽ hình người (stick figure)
        circle = plt.Circle((x, y+0.5), 0.3, fill=False, color='black', linewidth=2)
        ax.add_patch(circle)
        
        # Vẽ thân
        body = plt.Line2D([x, x], [y+0.2, y-0.3], color='black', linewidth=2)
        ax.add_line(body)
        
        # Vẽ tay
        left_arm = plt.Line2D([x-0.3, x], [y, y+0.1], color='black', linewidth=2)
        right_arm = plt.Line2D([x+0.3, x], [y, y+0.1], color='black', linewidth=2)
        ax.add_line(left_arm)
        ax.add_line(right_arm)
        
        # Vẽ chân
        left_leg = plt.Line2D([x-0.2, x], [y-0.3, y-0.8], color='black', linewidth=2)
        right_leg = plt.Line2D([x+0.2, x], [y-0.3, y-0.8], color='black', linewidth=2)
        ax.add_line(left_leg)
        ax.add_line(right_leg)
        
        # Tên actor
        ax.text(x, y-1.2, name, ha='center', va='top', fontsize=9, 
                bbox=dict(boxstyle="round,pad=0.3", facecolor=colors['actor'], edgecolor=colors['border']))
    
    # Vẽ các Use Case
    use_cases = {
        'Quản lý tài khoản': [
            ('Đăng ký tài khoản', 4, 14.5),
            ('Đăng nhập', 4, 13.5),
            ('Quên mật khẩu', 4, 12.5),
            ('Cập nhật thông tin', 4, 11.5),
            ('Xem lịch sử đơn hàng', 4, 10.5)
        ],
        'Mua sắm': [
            ('Tìm kiếm sản phẩm', 7, 14.5),
            ('Xem danh sách sản phẩm', 7, 13.5),
            ('Xem chi tiết sản phẩm', 7, 12.5),
            ('Thêm vào giỏ hàng', 7, 11.5),
            ('Xem giỏ hàng', 7, 10.5),
            ('Cập nhật giỏ hàng', 7, 9.5),
            ('Đặt hàng', 7, 8.5),
            ('Chọn phương thức\nthanh toán', 7, 7.5),
            ('Chọn phương thức\nvận chuyển', 7, 6.5)
        ],
        'Đánh giá và bình luận': [
            ('Đánh giá sản phẩm', 10, 14.5),
            ('Viết bình luận', 10, 13.5),
            ('Xem đánh giá của khác', 10, 12.5)
        ],
        'Hỗ trợ khách hàng': [
            ('Liên hệ hỗ trợ', 10, 11.5),
            ('Tạo yêu cầu hỗ trợ', 10, 10.5),
            ('Theo dõi yêu cầu hỗ trợ', 10, 9.5)
        ],
        'Quản lý hệ thống': [
            ('Quản lý người dùng', 13, 14.5),
            ('Quản lý sản phẩm', 13, 13.5),
            ('Quản lý danh mục', 13, 12.5),
            ('Quản lý đơn hàng', 13, 11.5),
            ('Quản lý kho hàng', 13, 10.5),
            ('Xem báo cáo thống kê', 13, 9.5),
            ('Quản lý khuyến mãi', 13, 8.5),
            ('Quản lý vận chuyển', 13, 7.5)
        ],
        'Hỗ trợ bán hàng': [
            ('Xử lý đơn hàng', 16, 14.5),
            ('Cập nhật trạng thái\nđơn hàng', 16, 13.5),
            ('Hỗ trợ khách hàng', 16, 12.5),
            ('Xử lý khiếu nại', 16, 11.5)
        ],
        'Thanh toán': [
            ('Xử lý thanh toán', 16, 10.5),
            ('Hoàn tiền', 16, 9.5),
            ('Xác thực giao dịch', 16, 8.5)
        ],
        'Vận chuyển': [
            ('Tính phí vận chuyển', 16, 7.5),
            ('Theo dõi đơn hàng', 16, 6.5),
            ('Cập nhật trạng thái\nvận chuyển', 16, 5.5)
        ]
    }
    
    # Vẽ các nhóm use case
    for group_name, cases in use_cases.items():
        # Vẽ khung nhóm
        min_x = min(x for _, x, _ in cases) - 0.5
        max_x = max(x for _, x, _ in cases) + 0.5
        min_y = min(y for _, _, y in cases) - 0.3
        max_y = max(y for _, _, y in cases) + 0.3
        
        rect = FancyBboxPatch((min_x, min_y), max_x - min_x, max_y - min_y,
                              boxstyle="round,pad=0.1", 
                              facecolor=colors['system'], 
                              edgecolor=colors['border'],
                              alpha=0.3)
        ax.add_patch(rect)
        
        # Tên nhóm
        ax.text((min_x + max_x) / 2, max_y + 0.2, group_name, 
                ha='center', va='bottom', fontsize=10, fontweight='bold',
                bbox=dict(boxstyle="round,pad=0.2", facecolor='white', edgecolor=colors['border']))
        
        # Vẽ các use case
        for name, x, y in cases:
            ellipse = patches.Ellipse((x, y), 1.8, 0.6, 
                                     facecolor=colors['usecase'], 
                                     edgecolor=colors['border'],
                                     linewidth=1.5)
            ax.add_patch(ellipse)
            ax.text(x, y, name, ha='center', va='center', fontsize=8, wrap=True)
    
    # Vẽ các mối quan hệ
    # Customer relationships
    customer_ucs = [4, 4, 4, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 10, 10]
    customer_y = [14.5, 13.5, 12.5, 14.5, 13.5, 12.5, 11.5, 10.5, 9.5, 8.5, 7.5, 6.5, 12.5, 11.5]
    
    for i, (x, y) in enumerate(zip(customer_ucs, customer_y)):
        if i < 3:  # Quản lý tài khoản
            ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 14),
                       arrowprops=dict(arrowstyle='->', color='blue', lw=1.5))
        elif i < 13:  # Mua sắm
            ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 14),
                       arrowprops=dict(arrowstyle='->', color='blue', lw=1.5))
        else:  # Hỗ trợ
            ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 14),
                       arrowprops=dict(arrowstyle='->', color='blue', lw=1.5))
    
    # Registered Customer relationships
    reg_customer_ucs = [4, 4, 10, 10, 10, 10]
    reg_customer_y = [11.5, 10.5, 14.5, 13.5, 10.5, 9.5]
    
    for x, y in zip(reg_customer_ucs, reg_customer_y):
        ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 12),
                   arrowprops=dict(arrowstyle='->', color='green', lw=1.5))
    
    # Admin relationships
    admin_ucs = [13, 13, 13, 13, 13, 13, 13, 13]
    admin_y = [14.5, 13.5, 12.5, 11.5, 10.5, 9.5, 8.5, 7.5]
    
    for x, y in zip(admin_ucs, admin_y):
        ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 10),
                   arrowprops=dict(arrowstyle='->', color='red', lw=1.5))
    
    # Sales Staff relationships
    sales_ucs = [16, 16, 16, 16]
    sales_y = [14.5, 13.5, 12.5, 11.5]
    
    for x, y in zip(sales_ucs, sales_y):
        ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 8),
                   arrowprops=dict(arrowstyle='->', color='orange', lw=1.5))
    
    # Payment System relationships
    payment_ucs = [16, 16, 16]
    payment_y = [10.5, 9.5, 8.5]
    
    for x, y in zip(payment_ucs, payment_y):
        ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 6),
                   arrowprops=dict(arrowstyle='->', color='purple', lw=1.5))
    
    # Shipping System relationships
    shipping_ucs = [16, 16, 16]
    shipping_y = [7.5, 6.5, 5.5]
    
    for x, y in zip(shipping_ucs, shipping_y):
        ax.annotate('', xy=(x-0.9, y), xytext=(1.3, 4),
                   arrowprops=dict(arrowstyle='->', color='brown', lw=1.5))
    
    # Tiêu đề
    ax.text(10, 15.5, 'Sơ đồ Use Case - Website Bán Hàng', 
            ha='center', va='center', fontsize=16, fontweight='bold',
            bbox=dict(boxstyle="round,pad=0.5", facecolor='lightblue', edgecolor='blue'))
    
    # Chú thích
    legend_elements = [
        patches.Patch(color=colors['actor'], label='Actor'),
        patches.Patch(color=colors['usecase'], label='Use Case'),
        patches.Patch(color=colors['system'], label='Nhóm chức năng', alpha=0.3)
    ]
    
    ax.legend(handles=legend_elements, loc='upper right', bbox_to_anchor=(0.98, 0.98))
    
    plt.tight_layout()
    return fig

def main():
    """Hàm chính"""
    print("Đang tạo sơ đồ Use Case...")
    
    # Tạo sơ đồ
    fig = create_use_case_diagram()
    
    # Lưu sơ đồ
    output_file = 'ecommerce_usecase_diagram.png'
    fig.savefig(output_file, dpi=300, bbox_inches='tight')
    print(f"Đã lưu sơ đồ vào file: {output_file}")
    
    # Hiển thị sơ đồ
    plt.show()

if __name__ == "__main__":
    main()