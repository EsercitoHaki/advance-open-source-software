# Đồ Án Phần Mềm Nguồn Mở Nâng Cao

## Hướng Dẫn Cài Đặt & Chạy Dự Án

Làm theo các bước sau để thiết lập và chạy project:

### 1. Clone project về máy
```bash
git clone <link-repo>
cd <tên-thư-mục-project>
```
### 2. Cài đặt các dependency bằng Composer
```bash
composer install
```
### 3. Tạo file môi trường .env
Trên Linux/MacOS:
```bash
cp .env.example .env
```
Trên Window:
```bash
copy .env.example .env
```
Lưu ý: Hiện tại dự án chưa kết nối đến cơ sở dữ liệu, hãy giữ các cấu hình sau trong file .env:
```ini
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
CACHE_STORE=file
```
### 4. Tạo application key
```bash
php artisan key:generate
```
