# edupham_fillable

#### Cài đặt, chạy lệnh:
- composer require edupham/fillable:dev-master

#### Chức năng:
Xem danh sách table, chạy lệnh:
- php artisan table:show-list

Xem danh sách field của một table, chạy lệnh:
- php artisan table:show-field <table_name>
- Ví dụ: php artisan table:show-field users

#### Lưu ý:
Trong một số trường hợp phát sinh lỗi liên quan đến tên lệnh 'table', chạy lệnh sau để cập nhật:
- composer dump-autoload