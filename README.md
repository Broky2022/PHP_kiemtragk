# Hệ thống Quản lý Sinh viên và Đăng ký Học phần

Hệ thống quản lý sinh viên và đăng ký học phần được xây dựng bằng PHP theo mô hình MVC.

## Chức năng chính

1. Quản lý sinh viên
   - Xem danh sách sinh viên
   - Thêm sinh viên mới
   - Cập nhật thông tin sinh viên
   - Xóa sinh viên
   - Xem chi tiết sinh viên

2. Quản lý học phần
   - Xem danh sách học phần
   - Đăng ký học phần

3. Hệ thống xác thực
   - Đăng nhập
   - Đăng xuất

## Cấu trúc Database

1. Bảng SinhVien
   - MaSV (char)
   - HoTen (nvarchar)
   - GioiTinh (nvarchar)
   - NgaySinh (date)
   - Hinh (varchar)
   - MaNganh (char)

2. Bảng HocPhan
   - MaHP (char)
   - TenHP (nvarchar)
   - SoTinChi (int)

3. Bảng DangKy
   - MaDK (int, auto increment)
   - NgayDK (date)
   - MaSV (char, foreign key)

4. Bảng ChiTietDangKy
   - MaDK (int, foreign key)
   - MaHP (char, foreign key)

## Yêu cầu hệ thống

- PHP >= 7.4
- MySQL >= 5.7
- Apache/Nginx
- mod_rewrite enabled

## Cài đặt

1. Clone repository
```bash
git clone https://github.com/Broky2022/PHP_kiemtragk.git
```

2. Import database
- Tạo database mới tên 'test1'
- Import file SQL từ thư mục database

3. Cấu hình
- Sao chép file config.example.php thành config.php
- Cập nhật thông tin kết nối database trong config.php

4. Phân quyền
- Đảm bảo thư mục img có quyền ghi

## Tác giả

- Broky2022
