# Tính năng Tin tức - Blog

## Tổng quan
Tính năng tin tức cho phép quản trị viên tạo, chỉnh sửa và quản lý các bài viết tin tức trên website. Người dùng có thể xem danh sách tin tức và đọc chi tiết từng bài viết.

## Cấu trúc Database

### Bảng: blogs
- `id`: ID tự động tăng
- `title`: Tiêu đề bài viết (bắt buộc)
- `content`: Nội dung bài viết (textarea, bắt buộc)
- `image`: Đường dẫn hình ảnh (tùy chọn)
- `is_active`: Trạng thái hiển thị (boolean)
- `created_at`: Thời gian tạo
- `updated_at`: Thời gian cập nhật

## Files đã tạo

### Models
- `app/Models/Blog.php`

### Controllers
- `app/Http/Controllers/Admin/BlogController.php` - Quản lý tin tức (Admin)
- `app/Http/Controllers/Client/BlogController.php` - Hiển thị tin tức (Client)

### Views - Admin
- `resources/views/admin/blogs/index.blade.php` - Danh sách tin tức
- `resources/views/admin/blogs/create.blade.php` - Tạo tin tức mới
- `resources/views/admin/blogs/edit.blade.php` - Sửa tin tức
- `resources/views/admin/blogs/show.blade.php` - Chi tiết tin tức

### Views - Client
- `resources/views/client/blogs/index.blade.php` - Danh sách tin tức (Client)
- `resources/views/client/blogs/show.blade.php` - Chi tiết tin tức (Client)

### Database
- `database/migrations/2025_11_17_114825_create_blogs_table.php`
- `database/factories/BlogFactory.php`
- `database/seeders/BlogSeeder.php`

## Routes

### Client Routes
- `GET /blogs` - Danh sách tin tức
- `GET /blogs/{id}` - Chi tiết tin tức

### Admin Routes (prefix: /ad)
- `GET /ad/blogs` - Danh sách quản lý tin tức
- `GET /ad/blogs/create` - Form tạo tin tức mới
- `POST /ad/blogs` - Lưu tin tức mới
- `GET /ad/blogs/{id}` - Chi tiết tin tức
- `GET /ad/blogs/{id}/edit` - Form sửa tin tức
- `PUT /ad/blogs/{id}` - Cập nhật tin tức
- `DELETE /ad/blogs/{id}` - Xóa tin tức
- `POST /ad/blogs/{id}/toggle-active` - Bật/tắt trạng thái

## Tính năng

### Admin
1. **Quản lý tin tức**: Xem danh sách tất cả tin tức với phân trang
2. **Tìm kiếm**: Tìm kiếm theo tiêu đề và nội dung
3. **Lọc**: Lọc theo trạng thái (hoạt động/không hoạt động)
4. **Sắp xếp**: Sắp xếp theo tiêu đề, ngày tạo, ngày cập nhật
5. **Tạo mới**: Tạo tin tức với tiêu đề, nội dung và hình ảnh
6. **Chỉnh sửa**: Cập nhật thông tin tin tức
7. **Xóa**: Xóa tin tức (bao gồm cả hình ảnh)
8. **Bật/tắt**: Chuyển đổi trạng thái hiển thị

### Client
1. **Danh sách tin tức**: Hiển thị tin tức dạng grid với phân trang
2. **Tìm kiếm**: Tìm kiếm tin tức
3. **Chi tiết tin tức**: Xem nội dung đầy đủ
4. **Bài viết liên quan**: Hiển thị 3 tin tức gần đây
5. **Chia sẻ**: Chia sẻ tin tức qua Facebook, Twitter hoặc copy link

## Lưu trữ hình ảnh

Hình ảnh được lưu trong thư mục: `storage/app/public/blog/`

Định dạng tên file: `blog-{id}.jpg` (ví dụ: blog-1.jpg, blog-2.jpg)

## Cách sử dụng

### Tạo tin tức mới (Admin)
1. Đăng nhập vào admin panel
2. Chọn menu "Tin tức" trên sidebar
3. Click nút "Thêm tin tức"
4. Điền thông tin:
   - Tiêu đề (bắt buộc)
   - Nội dung (bắt buộc)
   - Upload hình ảnh (tùy chọn)
   - Chọn trạng thái hoạt động
5. Click "Lưu tin tức"

### Xem tin tức (Client)
1. Truy cập menu "Tin tức" trên header
2. Xem danh sách hoặc tìm kiếm tin tức
3. Click vào tin tức để xem chi tiết

## Cách triển khai tính năng Blog

### Bước 1: Chạy Migration
Tạo bảng `blogs` trong database:
```bash
php artisan migrate
```

Nếu muốn migrate chỉ file blog:
```bash
php artisan migrate --path=/database/migrations/2025_11_17_114825_create_blogs_table.php
```

### Bước 2: Tạo dữ liệu mẫu (Tùy chọn)
Chạy seeder để tạo 5 tin tức mẫu:
```bash
php artisan db:seed --class=BlogSeeder
```

### Bước 3: Tạo thư mục lưu trữ hình ảnh
Tạo thư mục để lưu hình ảnh blog:
```bash
# Windows PowerShell
New-Item -ItemType Directory -Force -Path "storage\app\public\blog"

# Linux/Mac
mkdir -p storage/app/public/blog
```

### Bước 4: Đảm bảo symbolic link
Tạo symbolic link từ `public/storage` đến `storage/app/public`:
```bash
php artisan storage:link
```

### Bước 5: Kiểm tra routes
Xác nhận các routes đã được tạo:
```bash
php artisan route:list --name=blogs
```

Kết quả sẽ hiển thị 10 routes:
- Client: `/blogs`, `/blogs/{id}`
- Admin: `/ad/blogs`, `/ad/blogs/create`, `/ad/blogs/{id}`, `/ad/blogs/{id}/edit`, v.v.

### Bước 6: Truy cập tính năng

**Client - Xem tin tức:**
- Danh sách tin tức: `http://your-domain/blogs`
- Chi tiết tin tức: `http://your-domain/blogs/{id}`
- Menu "Tin tức" đã có trong header

**Admin - Quản lý tin tức:**
- Đăng nhập: `http://your-domain/admin/login`
- Quản lý tin tức: `http://your-domain/ad/blogs`
- Menu "Tin tức" đã có trong sidebar admin

## Rollback (Nếu cần)

Để xóa bảng blogs:
```bash
php artisan migrate:rollback --step=1
```

Hoặc rollback toàn bộ:
```bash
php artisan migrate:rollback
```

## Kiểm tra sau khi triển khai

1. ✅ Kiểm tra bảng `blogs` đã được tạo trong database
2. ✅ Thư mục `storage/app/public/blog` tồn tại
3. ✅ Symbolic link `public/storage` hoạt động
4. ✅ Truy cập được trang `/blogs` (client)
5. ✅ Truy cập được trang `/ad/blogs` (admin)
6. ✅ Có thể tạo tin tức mới và upload hình ảnh
7. ✅ Menu "Tin tức" hiển thị trên cả client và admin

## Seeder

Để tạo dữ liệu mẫu:
```bash
php artisan db:seed --class=BlogSeeder
```

Seeder sẽ tạo 5 tin tức mẫu với nội dung tiếng Việt về hoa và cây cảnh.

## Lưu ý quan trọng
- Hình ảnh được validate: jpeg, png, jpg, gif, tối đa 2MB
- Khi xóa tin tức, hình ảnh cũng sẽ được xóa khỏi storage
- Chỉ tin tức có trạng thái "active" mới hiển thị trên client
- Menu "Tin tức" đã được thêm vào cả desktop và mobile navigation
- Đảm bảo quyền ghi (write permission) cho thư mục `storage/app/public/blog`
- Trên production server, đảm bảo chạy `php artisan storage:link`
