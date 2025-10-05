# Hướng dẫn Deploy lên Railway

## Bước 1: Chuẩn bị dự án

Dự án đã được cấu hình sẵn các file cần thiết:
- `Dockerfile` - Cấu hình container PHP với Apache
- `railway.json` - Cấu hình Railway deployment
- `.htaccess` - Cấu hình Apache rewrite rules

## Bước 2: Deploy trên Railway

1. **Tạo tài khoản Railway**: Truy cập [railway.app](https://railway.app)
2. **Kết nối GitHub repository**:
   - Click "Deploy from GitHub repo"
   - Chọn repository `php-flowershop`
3. **Thêm MySQL Database**:
   - Trong dashboard, click "Add Service"
   - Chọn "Database" → "MySQL"
   - Đợi MySQL service khởi tạo xong (có thể mất vài phút)
   - MySQL sẽ tự động tạo database và cung cấp connection string

4. **Kết nối Database với App**:
   - Click vào MySQL service vừa tạo
   - Vào tab "Connect" 
   - Copy các thông tin connection:
     - `MYSQL_HOST` 
     - `MYSQL_DATABASE`
     - `MYSQL_USER` 
     - `MYSQL_PASSWORD`
     - `MYSQL_PORT`

5. **Cấu hình biến môi trường**:
   - Quay lại PHP app service (không phải MySQL service)
   - Vào tab "Variables" của PHP app
   - Thêm các biến từ MySQL database (copy từ bước 4):
     - `DB_HOST` = MYSQL_HOST 
     - `DB_DATABASE` = MYSQL_DATABASE
     - `DB_USERNAME` = MYSQL_USER
     - `DB_PASSWORD` = MYSQL_PASSWORD
     - `DB_PORT` = MYSQL_PORT (thường là 3306)
   - Thêm biến Laravel:
     - `APP_ENV=production`
     - `APP_DEBUG=false`
     - `APP_KEY=` (để trống, sẽ generate sau)
     - `APP_URL=` (Railway sẽ tự động cung cấp)

6. **Deploy ứng dụng**:
   - Railway sẽ tự động build và deploy khi có biến môi trường
   - Đợi deployment hoàn thành (kiểm tra tab "Deployments")

## Bước 3: Sau khi deploy thành công

1. **Truy cập ứng dụng**:
   - Vào tab "Settings" của PHP app service
   - Copy URL public (dạng: https://your-app.railway.app)
   - Mở URL để kiểm tra app

2. **Generate APP_KEY**:
   - Vào tab "Console" (hoặc "Shell") của PHP app service
   - Chạy lệnh:
   ```bash
   php artisan key:generate --force
   ```

3. **Run migrations**:
   ```bash
   php artisan migrate --force
   ```

4. **Seed database** (nếu cần):
   ```bash
   php artisan db:seed --force
   ```

5. **Storage permissions** (nếu có lỗi):
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

## Lưu ý

- Railway sẽ tự động deploy khi có commit mới
- Port mặc định: 80 (đã cấu hình trong Dockerfile)
- File storage: sử dụng local disk (có thể cần cấu hình S3 cho production)

## Troubleshooting

**App không chạy được:**
- Kiểm tra logs trong Railway dashboard → tab "Logs"
- Kiểm tra tất cả biến môi trường đã đúng
- Đảm bảo APP_KEY đã được generate

**Database connection error:**
- Kiểm tra database connection string
- Đảm bảo MySQL service đang chạy
- Kiểm tra các biến DB_* đã đúng

**500 Error:**
- Kiểm tra storage folder có quyền write
- Chạy `php artisan config:clear` và `php artisan cache:clear`
- Kiểm tra logs Laravel tại storage/logs/

**Hình ảnh không hiển thị:**
- Chạy `php artisan storage:link`
- Cấu hình file storage hoặc sử dụng S3 cho production

## Tips

- Railway sẽ tự động deploy lại khi có commit mới push lên GitHub
- Có thể enable auto-deploy từ specific branch
- Sử dụng Railway CLI để deploy từ local: `railway up`