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

## 💰 Chi Phí Google Maps API

### Giá Miễn Phí Hàng Tháng
Google cung cấp **$200 credit miễn phí** mỗi tháng cho tất cả APIs.

### Bảng Giá Chi Tiết

Dự án sử dụng 3 APIs sau:

#### 1. Maps JavaScript API
- **Giá**: $7 cho 1,000 lượt load map
- **Miễn phí**: 28,500 lượt load/tháng
- **Công dụng**: Hiển thị bản đồ trên trang booking

#### 2. Places API (Autocomplete)
- **Giá**: $2.83 cho 1,000 requests  
- **Miễn phí**: ~70,700 requests/tháng
- **Công dụng**: Gợi ý địa chỉ tự động khi khách hàng nhập điểm đón/đến

#### 3. Distance Matrix API ⚠️
- **Giá**: $5 cho 1,000 requests
- **Miễn phí**: 40,000 requests/tháng
- **Công dụng**: Tính khoảng cách và thời gian di chuyển

### Ước Tính Chi Phí Thực Tế

#### Scenario 1: Website mới/nhỏ (100 bookings/ngày)
```
📊 Tính toán:
- Map loads:        100 × 30 = 3,000/tháng   → $21
- Autocomplete:     400 × 30 = 12,000/tháng  → $34
- Distance Matrix:  100 × 30 = 3,000/tháng   → $15
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TỔNG CHI PHÍ:                                  ~$70/tháng
                                               
✅ HOÀN TOÀN MIỄN PHÍ (dưới $200 credit)
```

#### Scenario 2: Website phát triển (500 bookings/ngày)
```
📊 Tính toán:
- Map loads:        500 × 30 = 15,000/tháng   → $105
- Autocomplete:   2,000 × 30 = 60,000/tháng   → $170
- Distance Matrix:  500 × 30 = 15,000/tháng   → $75
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TỔNG CHI PHÍ:                                  ~$350/tháng

⚠️ VƯỢT CREDIT: Phải trả $150/tháng (350 - 200)
```

#### Scenario 3: Website lớn (1,500 bookings/ngày)
```
📊 Tính toán:
- Map loads:      1,500 × 30 = 45,000/tháng   → $315
- Autocomplete:   6,000 × 30 = 180,000/tháng  → $509
- Distance Matrix: 1,500 × 30 = 45,000/tháng  → $225
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TỔNG CHI PHÍ:                                  ~$1,049/tháng

❌ VƯỢT CREDIT: Phải trả $849/tháng (1,049 - 200)
```

### 💡 Cách Giảm Chi Phí

#### 1. Cache Kết Quả Distance Matrix
Lưu kết quả tính khoảng cách vào database để tránh tính lại:

```php
// Pseudo code
$cacheKey = "distance_{$pickup}_{$dropoff}";
$cached = Cache::get($cacheKey);

if (!$cached) {
    $distance = callGoogleDistanceAPI($pickup, $dropoff);
    Cache::put($cacheKey, $distance, 7 * 24 * 60); // Cache 7 ngày
}
```

**Tiết kiệm**: 50-70% chi phí Distance Matrix API

#### 2. Tối Ưu Autocomplete
- Chỉ gọi API sau khi gõ >= 3 ký tự
- Debounce 1-2 giây (đã implement)
- Giới hạn số lượng kết quả trả về

**Tiết kiệm**: 30-40% chi phí Autocomplete

#### 3. Lazy Load Map
Chỉ load map khi người dùng scroll đến section booking:

```javascript
// Sử dụng Intersection Observer
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
        loadGoogleMapsScript();
    }
});
```

**Tiết kiệm**: 20-30% chi phí Maps JavaScript API

#### 4. Sử dụng Static Maps cho Preview
Thay vì load interactive map, dùng Static Maps API (rẻ hơn 10 lần):

```html
<img src="https://maps.googleapis.com/maps/api/staticmap?..." />
```

**Tiết kiệm**: Giảm 90% chi phí nếu không cần interaction

### 📊 Monitoring & Alerts

#### Xem Usage Hiện Tại
```
🔗 Google Cloud Console - APIs Dashboard
https://console.cloud.google.com/apis/dashboard

Theo dõi:
- Số lượng requests từng API
- Chi phí tích lũy theo ngày
- Trend tăng/giảm
```

#### Set Budget Alerts
```
🔗 Google Cloud Console - Billing
https://console.cloud.google.com/billing

Cài đặt cảnh báo:
1. Vào "Budgets & alerts"
2. Click "Create budget"
3. Set ngưỡng: $50, $100, $150
4. Nhận email khi gần đạt ngưỡng
```

#### Xem Billing Reports
```
🔗 Billing Reports
https://console.cloud.google.com/billing/reports

Xem chi tiết:
- Chi phí từng API theo tháng
- So sánh tháng trước/tháng này
- Dự đoán chi phí cuối tháng
- Export CSV để báo cáo
```

### 📋 Report Cho Khách Hàng

#### Mẫu Report Tháng

```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
📊 BÁO CÁO CHI PHÍ GOOGLE MAPS API
Tháng: [MM/YYYY]
Dự án: Xế Hộ 24/7 - Đà Nẵng
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📈 THỐNG KÊ SỬ DỤNG:
├─ Tổng số bookings:        [XXX] lượt
├─ Map loads:                [XXX] requests
├─ Autocomplete:             [XXX] requests
└─ Distance calculation:     [XXX] requests

💰 CHI PHÍ:
├─ Maps JavaScript API:      $XX.XX
├─ Places API:               $XX.XX
├─ Distance Matrix API:      $XX.XX
├─ Tổng chi phí:             $XXX.XX
├─ Google Credit (miễn phí): -$200.00
└─ Số tiền phải trả:         $XX.XX

📊 SO SÁNH:
├─ Tháng trước:              $XX.XX
└─ Tăng/giảm:                [+/-]XX%

💡 KHUYẾN NGHỊ:
[Gợi ý tối ưu dựa trên usage thực tế]

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

#### Script Tự Động Export Report

```php
<?php
// File: app/Console/Commands/ExportGoogleMapsReport.php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportGoogleMapsReport extends Command
{
    protected $signature = 'report:google-maps {month?}';
    
    public function handle()
    {
        $month = $this->argument('month') ?? now()->format('Y-m');
        
        // 1. Lấy số liệu từ Google Cloud Console API
        // 2. Lấy số bookings từ database
        // 3. Tính toán chi phí
        // 4. Export ra file PDF/Excel
        
        $this->info("✅ Report đã được tạo: storage/reports/google-maps-{$month}.pdf");
    }
}
```

### 🎯 Khuyến Nghị Cho Khách Hàng

| Số Bookings/Ngày | Chi Phí/Tháng | Khuyến Nghị |
|------------------|---------------|-------------|
| < 300            | $0 (miễn phí) | ✅ Dùng Google Maps - tối ưu nhất |
| 300 - 1,000      | $100 - $300   | ⚠️ Implement caching để giảm chi phí |
| 1,000 - 2,000    | $300 - $700   | ⚠️ Cân nhắc hybrid (Google + OSM) |
| > 2,000          | > $700        | ❌ Chuyển sang OpenStreetMap hoàn toàn |

### ⚠️ Lưu Ý Quan Trọng

1. **Yêu cầu billing account**: Phải liên kết thẻ tín dụng/ghi nợ (Visa/Mastercard)
2. **Verification charge**: Google có thể charge $1 để verify thẻ, sau đó refund lại
3. **Auto-charge**: Nếu vượt $200, Google sẽ tự động charge vào thẻ
4. **Set spending limit**: Có thể giới hạn chi tiêu tối đa để tránh surprise bill

### 🔗 Links Hữu Ích

- **Pricing Calculator**: https://mapsplatform.google.com/pricing/
- **Usage Dashboard**: https://console.cloud.google.com/google/maps-apis/metrics
- **Billing Console**: https://console.cloud.google.com/billing
- **API Documentation**: https://developers.google.com/maps/documentation

## Tác Giả
- Ngày tích hợp: 24/01/2026
- Framework: Laravel + Google Maps API
- Dịch vụ: Xế Hộ 24/7 - Đà Nẵng
- Cập nhật chi phí: 12/02/2026
