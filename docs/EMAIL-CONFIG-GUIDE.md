# 📧 Hướng Dẫn Cấu Hình Email Gmail Cho Production

## 🎯 Tổng Quan

Để gửi email thông báo booking cho admin, bạn cần cấu hình Gmail SMTP. Hướng dẫn này áp dụng cho **server production**.

---

## 📋 Bước 1: Tạo App Password Từ Gmail

### 1.1. Bật 2-Step Verification

1. Truy cập: **https://myaccount.google.com/security**
2. Tìm "**2-Step Verification**" → Click **Get started**
3. Làm theo hướng dẫn để enable (cần số điện thoại)

### 1.2. Tạo App Password

1. Sau khi enable 2-Step Verification, truy cập:
   👉 **https://myaccount.google.com/apppasswords**

2. Hoặc: **Google Account** → **Security** → **2-Step Verification** → **App passwords** (ở cuối trang)

3. Tạo password mới:
   - **Select app**: Mail
   - **Select device**: Other (Custom name)
   - Nhập tên: `Laravel Production` hoặc `Xe Ho Website`
   - Click **Generate**

4. **Copy 16-digit password** hiển thị (dạng: `xxxx xxxx xxxx xxxx`)
   - Loại bỏ dấu cách khi paste vào `.env`
   - Ví dụ: `abcd efgh ijkl mnop` → Dùng `abcdefghijklmnop`

---

## 🔧 Bước 2: Cấu Hình .env Trên Server

SSH vào server và edit file `.env`:

```bash
nano /path/to/your/laravel/.env
```

### Thay đổi các dòng sau:

```bash
# Thay đổi từ log/mailhog sang smtp
MAIL_MAILER=smtp

# Gmail SMTP settings
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com           # ← Email Gmail của bạn
MAIL_PASSWORD=abcdefghijklmnop              # ← App Password 16 ký tự (không có dấu cách)
MAIL_ENCRYPTION=tls

# Sender info
MAIL_FROM_ADDRESS="noreply@xeho247danang.vn"
MAIL_FROM_NAME="Xế Hộ 24/7 - Đà Nẵng"

# Admin email nhận thông báo
ADMIN_EMAIL="your-real-email@gmail.com"      # ← Email nhận thông báo booking
```

### Ví dụ cụ thể:

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=contact@xeho247danang.vn
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@xeho247danang.vn"
MAIL_FROM_NAME="Xế Hộ 24/7 - Đà Nẵng"
ADMIN_EMAIL="admin@xeho247danang.vn"
```

---

## 🧪 Bước 3: Test Gửi Email

### 3.1. Clear cache Laravel

```bash
php artisan config:clear
php artisan cache:clear
```

### 3.2. Test gửi email bằng Tinker

```bash
php artisan tinker
```

Trong Tinker, chạy:

```php
use App\Models\DriverBooking;
use App\Mail\BookingNotification;
use Illuminate\Support\Facades\Mail;

$booking = DriverBooking::latest()->first();
if ($booking) {
    Mail::to('admin@xeho247danang.vn')->send(new BookingNotification($booking));
    echo '✅ Email sent successfully!';
} else {
    echo 'No booking found';
}
```

Hoặc test đơn giản hơn:

```php
Mail::raw('Test email from Laravel', function ($message) {
    $message->to('your-email@gmail.com')
            ->subject('Test Email');
});
echo 'Email sent!';
```

### 3.3. Kiểm tra inbox

- Check inbox của `ADMIN_EMAIL`
- Check cả spam folder
- Nếu không nhận được, check logs: `storage/logs/laravel.log`

---

## 🚨 Xử Lý Lỗi Thường Gặp

### ❌ Lỗi: "Invalid credentials"

**Nguyên nhân:**
- Sai email hoặc App Password
- Chưa enable 2-Step Verification
- App Password đã bị revoke

**Giải pháp:**
1. Kiểm tra lại email trong `MAIL_USERNAME`
2. Tạo App Password mới
3. Đảm bảo không có dấu cách trong password

---

### ❌ Lỗi: "Connection timeout"

**Nguyên nhân:**
- Server block port 587
- Firewall blocking

**Giải pháp:**
```bash
# Test kết nối SMTP
telnet smtp.gmail.com 587

# Hoặc dùng port 465 với SSL
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

---

### ❌ Lỗi: "Less secure app access"

**Nguyên nhân:**
- Gmail block app chưa verify

**Giải pháp:**
- **PHẢI dùng App Password**, không dùng password Gmail thật
- Enable 2-Step Verification trước

---

## 🔐 Bảo Mật

### ✅ Best Practices:

1. **Không commit .env vào git:**
   ```bash
   # Kiểm tra .gitignore có chứa:
   .env
   .env.*
   ```

2. **Dùng email riêng cho từng app:**
   - Tạo App Password khác nhau cho dev/staging/production

3. **Revoke App Password khi không dùng:**
   - Vào https://myaccount.google.com/apppasswords
   - Xóa password cũ

4. **Set quyền file .env:**
   ```bash
   chmod 600 .env
   chown www-data:www-data .env
   ```

5. **Sử dụng Queue để gửi email:**
   ```php
   // In controller
   Mail::to($adminEmail)->queue(new BookingNotification($booking));
   ```

---

## 📊 Giám Sát Email

### Check logs nếu email fail:

```bash
tail -f storage/logs/laravel.log
```

### Queue logs (nếu dùng queue):

```bash
php artisan queue:work --verbose
```

---

## 🌟 Nâng Cao: Dùng Service Chuyên Nghiệp

Thay vì Gmail, nên dùng email service chuyên nghiệp cho production:

### **Mailgun** (Recommended)
- 5,000 emails free/month
- Delivery rate cao hơn Gmail
- Có tracking và analytics

```bash
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.xeho247danang.vn
MAILGUN_SECRET=your-mailgun-api-key
```

### **SendGrid**
- 100 emails free/day
- Dashboard đẹp

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
```

### **Amazon SES**
- $0.10 per 1,000 emails
- Rất rẻ, phù hợp website lớn

---

## 📝 Checklist Triển Khai

- [ ] Enable 2-Step Verification cho Gmail
- [ ] Tạo App Password từ Google Account
- [ ] Cập nhật `.env` trên server với thông tin đúng
- [ ] Clear cache Laravel: `php artisan config:clear`
- [ ] Test gửi email thành công
- [ ] Check email trong inbox (và spam)
- [ ] Set quyền file `.env` đúng: `chmod 600`
- [ ] Backup App Password an toàn
- [ ] Monitor logs trong vài ngày đầu

---

## 🆘 Hỗ Trợ

Nếu gặp vấn đề:

1. Check log: `storage/logs/laravel.log`
2. Test SMTP connection: `telnet smtp.gmail.com 587`
3. Verify App Password mới nhất
4. Kiểm tra firewall server

---

**Lưu ý:** File config mẫu đầy đủ xem tại: `docs/.env.email-config-example`
