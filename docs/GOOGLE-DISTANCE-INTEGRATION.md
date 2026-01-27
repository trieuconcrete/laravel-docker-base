# Tích Hợp Google Distance Matrix API

## Tổng Quan
Dự án đã được tích hợp thành công Google Distance Matrix API để tính toán khoảng cách và giá cước tự động khi khách hàng nhập điểm đón và điểm đến.

## Các Chức Năng Đã Triển Khai

### 1. Google Distance Matrix API
- ✅ Tích hợp Google Maps API để tính khoảng cách giữa điểm đón và điểm đến
- ✅ Tự động gợi ý địa chỉ với Google Places Autocomplete (giới hạn trong Việt Nam)
- ✅ Tính toán thời gian thực khi người dùng nhập địa chỉ (debounce 1 giây)

### 2. Tính Giá Tự Động
- ✅ Áp dụng bảng giá "BẢNG GIÁ THUÊ TÀI XẾ LÁI XE HỘ" có sẵn trên website
- ✅ Phân biệt giá ban ngày (6h-23h59) và ban đêm (0h-5h59):
  - Ban ngày: 150.000đ mở cửa (0-5km), +15.000đ/km cho 5-30km
  - Ban đêm: 200.000đ mở cửa (0-5km), +15.000đ/km cho 5-30km
- ✅ Tự động tính giá dựa trên quãng đường

### 3. Xử Lý Khoảng Cách > 30km
- ✅ Hiển thị thông báo: "📞 Liên hệ hotline 0559 304 993 để thỏa thuận giá cả"
- ✅ Ghi chú: "Khoảng cách trên 30km, vui lòng liên hệ để được báo giá chính xác"

### 4. Hiển Thị Thông Tin
- ✅ Vùng hiển thị thông tin đẹp mắt với hiệu ứng animation
- ✅ Hiển thị đầy đủ: Quãng đường, Giá ước tính, Ghi chú chi tiết
- ✅ Vị trí: Ngay phía dưới input "Điểm đến"

## Cấu Hình

### 1. File .env
Đã thêm biến môi trường cho Google Maps API Key:
```
GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here
```

### 2. Hướng Dẫn Lấy API Key

**Bước 1: Truy cập Google Cloud Console**
- Vào https://console.cloud.google.com/
- Đăng nhập bằng tài khoản Google

**Bước 2: Tạo Project mới (nếu chưa có)**
- Click "Select a project" → "New Project"
- Nhập tên project (ví dụ: "Xe Ho Da Nang")
- Click "Create"

**Bước 3: Enable APIs**
- Vào "APIs & Services" → "Library"
- Tìm và enable các API sau:
  - ✅ Distance Matrix API
  - ✅ Places API
  - ✅ Maps JavaScript API

**Bước 4: Tạo API Key**
- Vào "APIs & Services" → "Credentials"
- Click "Create Credentials" → "API Key"
- Copy API Key đã tạo

**Bước 5: Bảo Mật API Key (Khuyến Nghị)**
- Click vào API key vừa tạo
- Trong "API restrictions", chọn "Restrict key"
- Chọn các API: Distance Matrix API, Places API, Maps JavaScript API
- Trong "Website restrictions", thêm domain của bạn (ví dụ: *.xeho247danang.vn/*)
- Click "Save"

**Bước 6: Cập Nhật .env**
```bash
GOOGLE_MAPS_API_KEY=AIzaSy...your_actual_key_here
```

### 3. File Đã Thay Đổi

**src/resources/views/home.blade.php**
- Thêm Google Maps JavaScript API trong `<head>`
- Thêm CSS cho distance-price-info display
- Thêm HTML cho distance và price display
- Thêm JavaScript logic cho:
  - Google Places Autocomplete
  - Distance Matrix API calculation
  - Price calculation dựa trên bảng giá
  - Event handlers với debounce

## Cách Sử Dụng

1. Người dùng nhập "Điểm đón" (có autocomplete)
2. Người dùng nhập "Điểm đến" (có autocomplete)
3. Sau 1 giây (debounce), hệ thống tự động:
   - Gọi Google Distance Matrix API
   - Tính khoảng cách
   - Tính giá tiền dựa trên thời gian (ngày/đêm)
   - Hiển thị thông tin với animation đẹp mắt

## Bảng Giá Áp Dụng

### Ban Ngày (6h - 23h59)
- 0-5km: 150.000đ (giá mở cửa)
- 5-30km: 150.000đ + 15.000đ/km
- >30km: Liên hệ hotline

### Ban Đêm (0h - 5h59)
- 0-5km: 200.000đ (giá mở cửa)
- 5-30km: 200.000đ + 15.000đ/km
- >30km: Liên hệ hotline

## Ví Dụ Tính Giá

### Ban Ngày
- 3km: 150.000đ (giá mở cửa)
- 10km: 150.000đ + (10-5) × 15.000đ = 225.000đ
- 20km: 150.000đ + (20-5) × 15.000đ = 375.000đ
- 35km: "Liên hệ hotline 0559 304 993"

### Ban Đêm
- 3km: 200.000đ (giá mở cửa)
- 10km: 200.000đ + (10-5) × 15.000đ = 275.000đ
- 20km: 200.000đ + (20-5) × 15.000đ = 425.000đ
- 35km: "Liên hệ hotline 0559 304 993"

## Test Cases

### Test 1: Khoảng cách ngắn (< 5km)
- Input: Sân bay Đà Nẵng → Cầu Rồng
- Expected: ~3km, giá 150.000đ (ngày) / 200.000đ (đêm)

### Test 2: Khoảng cách trung bình (5-30km)
- Input: Sân bay Đà Nẵng → Hội An
- Expected: ~25km, giá 450.000đ (ngày) / 500.000đ (đêm)

### Test 3: Khoảng cách dài (> 30km)
- Input: Đà Nẵng → Huế
- Expected: ~100km, message "Liên hệ hotline"

### Test 4: Địa chỉ không hợp lệ
- Input: "abc123xyz" → "def456uvw"
- Expected: Hiển thị error message

## Ghi Chú Kỹ Thuật

1. **Debounce**: Sử dụng setTimeout với 1 giây để tránh gọi API quá nhiều
2. **Animation**: CSS animation `slideDown` cho UX mượt mà
3. **Error Handling**: Xử lý các trường hợp lỗi từ Google API
4. **Responsive**: Giao diện tự động điều chỉnh trên mobile
5. **Performance**: Chỉ gọi API khi cả 2 trường đều có giá trị

## Hỗ Trợ

Nếu có vấn đề, kiểm tra:
1. API Key đã được cấu hình chính xác trong .env
2. API Key đã enable đủ 3 APIs cần thiết
3. Domain đã được thêm vào whitelist (nếu có restrictions)
4. Console log trong trình duyệt để xem lỗi chi tiết

## Tác Giả
- Ngày tích hợp: 24/01/2026
- Framework: Laravel + Google Maps API
- Dịch vụ: Xế Hộ 24/7 - Đà Nẵng
