# Laravel Package: Edupham Fillable
Package giúp DEV xem danh sách các table trong db và các trường của một table bằng dòng lệnh.

Ngoài ra, bạn có thể dùng các field trên để khai báo fillable trong model. 

## Cài đặt
Chạy lệnh:
- composer require edupham/fillable:dev-master

Hoặc nếu chỉ muốn cài đặt ở môi trường phát triển, chạy lệnh:
- composer require --dev edupham/fillable:dev-master

## Chức năng:
#### Xem danh sách table
Bao gồm các tùy chọn:
- default: sẽ hiển thị tên table như trong db và kèm theo số thứ tự
- upper: sẽ chuyển tên table thành chữ hoa và kèm theo số thứ tự
- const: sẽ tạo sẵn câu lệnh khai báo hằng số với const
- define: sẽ tạo sẵn câu lệnh khai báo hằng số với define

Các lệnh tương ứng với các tùy chọn:
- php artisan table:show-list hoặc php artisan table:show-list default
- php artisan table:show-list upper
- php artisan table:show-list const
- php artisan table:show-list define

Các kết quả tương ứng với từng tùy chọn:
- default: 1. users
- upper: 1. USERS
- const: const TABLE_USERS = 'users';
- define: define('TABLE_USERS', 'users');

#### Xem danh sách field của một table
Chạy lệnh:
- php artisan table:show-field <table_name>

Ví dụ:
- php artisan table:show-field users

## Lưu ý:
Trong một số trường hợp phát sinh lỗi liên quan đến tên lệnh 'table', chạy lệnh sau để cập nhật tải class:
- composer dump-autoload