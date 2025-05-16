# Đồ Án Phần Mềm Nguồn Mở Nâng Cao

## Hướng Dẫn Cài Đặt & Chạy Dự Án

Làm theo các bước sau để thiết lập và chạy project:

### 1. Clone project về máy
```bash
git clone https://github.com/EsercitoHaki/advance-open-source-software.git
cd advance-open-source-software
```
### 2. Cập nhật và cài đặt các dependency bằng Composer
```bash
composer update
composer install
```
### 3. Tạo file môi trường .env
Trên Linux/MacOS:
```bash
cp .env.example .env
```
Trên Window:
```cmd
copy .env.example .env
```
Setup file .env
```ini
# Version API
API_VERSION=v1

# Kết nối database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eng_test # Đặt tên tùy ý
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=file
```
### 4. Tạo application key
```bash
php artisan key:generate
```
### 5. Setup JWT Authentication
Chạy lệnh sau để render key jwt
```bash
php artisan jwt:secret
```
Thêm các cấu hình jwt vào .env
```bash
JWT_TTL=3600
JWT_REFRESH_TTL=2592000
```

### 6. Setup config quên mật khẩu
Thay đổi cấu hình file .env như sau:
```ini
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=huce.english.learning.lab@gmail.com
MAIL_PASSWORD=nrckcovzzlkiwbbg
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=huce.english.learning.lab@gmail.com
MAIL_FROM_NAME=HELL

FRONTEND_URL=http://localhost:5173
```

### 7. Tạo Database
Chạy lệnh sau để Laravel khởi tạo database cũng như bảng trong mysql
```bash
php artisan migrate
```

### 8. Tạo một symbolic link
Lưu vị trí file upload
```bash
php artisan storage:link
```