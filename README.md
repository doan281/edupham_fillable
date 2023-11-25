# Laravel Package: Edupham Fillable
Package giúp DEV xem danh sách các table trong db và các trường của một table bằng dòng lệnh.

Ngoài ra, bạn có thể dùng các field trên để khai báo fillable trong model. 

## Cài đặt
Chạy lệnh:
```
composer require edupham/fillable:dev-master
```
Hoặc nếu chỉ muốn cài đặt ở môi trường phát triển, chạy lệnh:
```
composer require --dev edupham/fillable:dev-master
```
Với Laravel 5.4.x trở về trước, Bạn phải cấu hình trong file config/app.php và tìm đến đoạn cấu hình mảng providers, sau đó thêm đoạn mã sau để đăng ký với hệ thống:
```
'providers' => [
    ...
    \Edupham\Fillable\EduphamFillableServiceProvider::class,
    ...
]
``` 
Với Laravel từ 5.5.x, hệ thống đăng ký tự động nên không phải cấu hình.

## Chức năng:
#### 1. Xem danh sách table
Bao gồm các tùy chọn:
- default: sẽ hiển thị tên table như trong db và kèm theo số thứ tự
- record: sẽ hiển thị tên table như trong db, kèm theo số thứ tự và số bản ghi hiện có của bảng. Mặc định kết quả sắp xếp tăng dần theo tên của bảng. Nếu cần sắp xếp giảm dần theo số bản ghi thì thêm tuỳ chọn --order=desc
- upper: sẽ chuyển tên table thành chữ hoa và kèm theo số thứ tự
- const: sẽ tạo sẵn câu lệnh khai báo hằng số với const
- define: sẽ tạo sẵn câu lệnh khai báo hằng số với define

Các lệnh tương ứng với các tùy chọn:
```
- php artisan table:show-list hoặc php artisan table:show-list default
- php artisan table:show-list upper
- php artisan table:show-list record hoặc php artisan table:show-list record --order=desc
- php artisan table:show-list const
- php artisan table:show-list define
```
Các kết quả tương ứng với từng tùy chọn, ví dụ DB có một bảng users:
- default: 1. users
- record: 1. users (1000)
- upper: 1. USERS
- const: const TABLE_USERS = 'users';
- define: define('TABLE_USERS', 'users');

Kết quả được lưu ra file theo đường dẫn:
- storage/app/public/tables.txt

#### 2. Xem danh sách field của một table
Chạy lệnh:
```
php artisan table:show-field <table_name>
```
Ví dụ:
```
php artisan table:show-field users
```

Kết quả được lưu ra file theo đường dẫn:
- storage/app/public/fields.txt

## Lưu ý:
Trong một số trường hợp phát sinh lỗi liên quan đến tên lệnh 'table', chạy lệnh sau để cập nhật tải class:
```
composer dump-autoload
```