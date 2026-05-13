# 📊 BÁO CÁO CHI PHÍ GOOGLE MAPS API — Xeho247 Đà Nẵng

> **Ngày báo cáo:** 15/03/2026
> **Project:** Xeho247danang
> **Billing Account:** Google Cloud Console

---

## 1. TỔNG QUAN CÁC API ĐANG SỬ DỤNG

Dự án Xeho247 sử dụng **3 Google Maps APIs** + 1 API phụ:

| # | API | Mục đích | Cách gọi |
|---|-----|----------|----------|
| 1 | **Maps JavaScript API** | Hiển thị bản đồ khi load trang | `<script>` tag, tự động load |
| 2 | **Places API** (Autocomplete) | Gợi ý địa chỉ khi user gõ điểm đón/trả | `google.maps.places.Autocomplete` |
| 3 | **Distance Matrix API** | Tính khoảng cách & thời gian lái xe | `google.maps.DistanceMatrixService` |
| 4 | **Gemini for Google Cloud API** | AI/khác | Số lượng nhỏ (4 requests) |

---

## 2. USAGE HIỆN TẠI (Tháng 03/2026)

Dữ liệu từ Google Cloud Console ngày 15/03/2026:

| API | Requests | Errors (%) | Latency trung bình | Latency 95% |
|-----|----------|------------|---------------------|-------------|
| **Places API** | 154 | 3% | 34ms | 67ms |
| **Distance Matrix API** | 13 | 0% | 176ms | 253ms |
| **Gemini for Cloud API** | 4 | 0% | 49ms | 943ms |

### 💰 Chi phí tháng 03/2026: **$0.00** ✅

Tất cả đều nằm trong **free tier** (10,000 requests miễn phí/tháng cho mỗi API).

---

## 3. BẢNG GIÁ CHI TIẾT TỪNG API

### 3.1. Maps JavaScript API (Dynamic Maps)

Mỗi lần user load trang web = 1 billable event.

| Tier | Số lượng/tháng | Giá/1,000 loads (USD) |
|------|---------------|----------------------|
| 🆓 **Miễn phí** | 0 – 10,000 | **$0.00** |
| Essentials | 10,001 – 100,000 | **$7.00** |
| | 100,001 – 500,000 | **$5.60** |
| | 500,001 – 1,000,000 | **$4.20** |

> **Ví dụ:** 50,000 loads/tháng = 10,000 × $0 + 40,000 × $7/1000 = **$280**

---

### 3.2. Places API — Autocomplete (Per Request)

Mỗi keystroke khi user gõ địa chỉ = 1 request (nếu không dùng Session Token).

| Tier | Số lượng/tháng | Giá/1,000 requests (USD) |
|------|---------------|-------------------------|
| 🆓 **Miễn phí** | 0 – 10,000 | **$0.00** |
| Essentials | 10,001 – 100,000 | **$2.83** |
| | 100,001 – 500,000 | **$2.27** |
| | 500,001 – 1,000,000 | **$1.70** |

> ⚠️ **Lưu ý quan trọng:** Code hiện tại KHÔNG dùng Session Token.
> Mỗi lần user gõ 1 ký tự = 1 request riêng biệt.
> Trung bình 1 lần gõ địa chỉ = **5–10 requests**.
> Nếu dùng Session Token, nhiều keystroke sẽ gộp thành 1 session = tiết kiệm đáng kể.

---

### 3.3. Distance Matrix API

Mỗi lần tính khoảng cách giữa điểm đón và điểm trả = 1 element.

| Tier | Số lượng/tháng | Giá/1,000 elements (USD) |
|------|---------------|-------------------------|
| 🆓 **Miễn phí** | 0 – 10,000 | **$0.00** |
| Essentials | 10,001 – 100,000 | **$5.00** |
| | 100,001 – 500,000 | **$4.00** |
| Pro (Advanced) | 5,001 – 100,000 | **$10.00** |

> Code hiện tại dùng tier **Essentials** (chỉ tính khoảng cách + thời gian, không traffic model).

---

### 3.4. Gemini for Google Cloud API

| Tier | Giá |
|------|-----|
| Input tokens | Tùy model (thường $0.075–$0.15/1M tokens) |
| Output tokens | Tùy model (thường $0.30–$0.60/1M tokens) |

> Chỉ có 4 requests, chi phí không đáng kể.

---

## 4. CÁCH GOOGLE TÍNH TIỀN

### 4.1. Cơ chế Free Tier

```
┌─────────────────────────────────────────────────────┐
│  Google Maps Platform — Free Tier                    │
│                                                      │
│  Mỗi billing account được:                          │
│  ✅ $200 credit miễn phí / tháng                    │
│  ✅ Tự động áp dụng, không cần đăng ký             │
│  ✅ Reset mỗi đầu tháng                             │
│  ❌ KHÔNG cộng dồn sang tháng sau                   │
│                                                      │
│  Ngoài ra, mỗi API có free cap riêng:              │
│  • Maps JS: 10,000 loads miễn phí                   │
│  • Places Autocomplete: 10,000 requests miễn phí   │
│  • Distance Matrix: 10,000 elements miễn phí       │
└─────────────────────────────────────────────────────┘
```

### 4.2. Quy trình tính tiền

```
User gõ địa chỉ "123 Nguyễn Văn..."
        │
        ▼
┌──────────────────┐
│ Keystroke "1"    │──→ Places API request #1   ─┐
│ Keystroke "12"   │──→ Places API request #2    │
│ Keystroke "123"  │──→ Places API request #3    ├─ 7 requests
│ Keystroke "123 " │──→ Places API request #4    │  cho 1 lần
│ Keystroke "123 N"│──→ Places API request #5    │  gõ địa chỉ
│ ... (debounce)   │                             │
│ Chọn gợi ý      │──→ Places API request #6-7  ─┘
└──────────────────┘
        │
        ▼ (Khi cả pickup + dropoff có giá trị)
┌──────────────────────────┐
│ Distance Matrix API      │──→ 1 element
│ Tính: khoảng cách + time │
└──────────────────────────┘
        │
        ▼
┌──────────────────────────┐
│ Client-side calculation  │
│ Tính giá xe (không API)  │
│ • 0-5km: 150k/200k      │
│ • >5km: +15k/km          │
└──────────────────────────┘
```

### 4.3. Chu kỳ thanh toán

- **Tính theo tháng dương lịch** (1st – cuối tháng)
- **Trừ tiền tự động** vào thẻ tín dụng đã liên kết
- **Invoice** phát hành đầu tháng sau
- **Threshold billing**: Nếu chi tiêu đạt threshold ($50, $200, $500...) sẽ charge sớm

---

## 5. ƯỚC TÍNH CHI PHÍ THEO QUY MÔ

### Giả định:
- Mỗi booking: ~8 Places requests (gõ 2 địa chỉ) + 1 Distance Matrix + 1 Map load
- Mỗi lượt xem trang (không booking): 1 Map load + 2 Places requests

### Bảng ước tính:

| Quy mô | Bookings/tháng | Page views/tháng | Places API | Distance Matrix | Maps JS | **Tổng/tháng** |
|--------|---------------|-----------------|------------|-----------------|---------|---------------|
| 🟢 **Hiện tại** | ~13 | ~150 | 154 req | 13 elem | ~150 | **$0.00** |
| 🟢 **Nhỏ** | 100 | 1,000 | ~2,800 | ~100 | ~1,000 | **$0.00** |
| 🟢 **Vừa** | 500 | 5,000 | ~14,000 | ~500 | ~5,000 | **~$11.32** |
| 🟡 **Khá** | 2,000 | 15,000 | ~46,000 | ~2,000 | ~15,000 | **~$136.88** |
| 🟠 **Lớn** | 5,000 | 30,000 | ~100,000 | ~5,000 | ~30,000 | **~$394.70** |
| 🔴 **Rất lớn** | 10,000 | 60,000 | ~200,000 | ~10,000 | ~60,000 | **~$821.10** |

### Chi tiết tính cho quy mô "Khá" (2,000 bookings/tháng):

```
Places API:     46,000 requests
                10,000 × $0.00  = $0.00    (free cap)
                36,000 × $2.83  = $101.88
                                  --------
                Subtotal:         $101.88

Distance Matrix: 2,000 elements
                 2,000 × $0.00  = $0.00    (free cap)
                                  --------
                 Subtotal:        $0.00

Maps JavaScript: 15,000 loads
                 10,000 × $0.00 = $0.00    (free cap)
                 5,000 × $7.00  = $35.00
                                  --------
                 Subtotal:        $35.00

─────────────────────────────────
TỔNG:                             $136.88/tháng
                                  (~3.4 triệu VNĐ)
```

---

## 6. SO SÁNH VỚI PHƯƠNG ÁN THAY THẾ

| Tiêu chí | Google Maps | OpenStreetMap + OSRM | Mapbox |
|----------|-------------|---------------------|--------|
| **Chi phí** | $0–$800+/tháng | **$0 (miễn phí 100%)** | $0–$300+/tháng |
| **Free tier** | $200/tháng | Không giới hạn | 50,000 req/tháng |
| **Cần thẻ tín dụng** | ✅ Bắt buộc | ❌ Không cần | ❌ Không cần |
| **Chất lượng VN** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Autocomplete VN** | Rất tốt | Khá tốt (Nominatim) | Tốt |
| **Tính khoảng cách** | Rất chính xác | Tốt (OSRM) | Tốt |
| **Tốc độ** | Nhanh (34ms) | Trung bình (100-300ms) | Nhanh |
| **Độ ổn định** | 99.99% | Phụ thuộc server | 99.9% |
| **Giới hạn** | Theo billing | Usage policy (1 req/s) | Theo plan |

> 💡 **Khuyến nghị:** Với quy mô hiện tại (<200 requests/tháng), **Google Maps miễn phí**.
> Nếu scale lên >5,000 bookings/tháng, nên cân nhắc **chuyển sang OpenStreetMap**.

---

## 7. KHUYẾN NGHỊ TỐI ƯU CHI PHÍ

### 🔴 Ưu tiên cao (Tiết kiệm lớn)

#### 7.1. Thêm Autocomplete Session Token
Hiện tại mỗi keystroke = 1 request ($2.83/1000). Dùng Session Token sẽ gộp thành 1 session.

**Tiết kiệm ước tính:** Giảm ~70-80% Places API requests

```javascript
// TRƯỚC (hiện tại) — mỗi keystroke = 1 request
const autocomplete = new google.maps.places.Autocomplete(input);

// SAU (khuyến nghị) — cả session = 1 billable event
const sessionToken = new google.maps.places.AutocompleteSessionToken();
const autocomplete = new google.maps.places.Autocomplete(input, {
    sessionToken: sessionToken
});
```

#### 7.2. Bật HTTP Referrer Restriction
Tránh bị người khác lấy API key và dùng (bạn sẽ bị tính tiền).

```
Google Cloud Console → APIs & Services → Credentials
→ Click API key → Application restrictions
→ HTTP referrers → Thêm:
   *.xeho247.com/*
   localhost/*
```

### 🟡 Ưu tiên trung bình

#### 7.3. Cache kết quả Distance Matrix
Nếu user tính đi tính lại cùng route, không cần gọi API lần 2.

#### 7.4. Set Budget Alert
```
Google Cloud Console → Billing → Budgets & alerts
→ Create budget: $50/tháng
→ Alert: 50%, 80%, 100%
```

#### 7.5. Giới hạn API Key Quota
```
Google Cloud Console → APIs & Services → Credentials
→ Click API key → API restrictions
→ Đặt quota/ngày cho mỗi API (vd: 1,000 requests/ngày)
```

### 🟢 Ưu tiên thấp (Khi scale)

#### 7.6. Chuyển sang OpenStreetMap
Config đã sẵn sàng (`MAP_SERVICE_PROVIDER=openstreetmap`), nhưng code chưa kiểm tra config này — Maps JS luôn load bất kể setting.

#### 7.7. Server-side proxy
Chuyển API calls lên server để:
- Cache responses
- Rate limit per user
- Ẩn API key khỏi client

---

## 8. MONITORING & ALERTS

### Dashboard
```
https://console.cloud.google.com/apis/dashboard?project=xeho247danang
```

### Billing
```
https://console.cloud.google.com/billing
```

### Quota & Usage
```
https://console.cloud.google.com/apis/api/places-backend.googleapis.com/quotas
https://console.cloud.google.com/apis/api/distance-matrix-backend.googleapis.com/quotas
https://console.cloud.google.com/apis/api/maps-backend.googleapis.com/quotas
```

### Đặt Budget Alert (Khuyến nghị)

| Alert Level | Ngưỡng | Hành động |
|-------------|--------|-----------|
| 🟢 Info | $20 (50%) | Theo dõi |
| 🟡 Warning | $40 (80%) | Kiểm tra usage |
| 🔴 Critical | $50 (100%) | Cân nhắc giảm traffic hoặc chuyển OSM |

---

## 9. TÓM TẮT

| Mục | Giá trị |
|-----|---------|
| **Chi phí hiện tại** | **$0.00/tháng** ✅ |
| **Ngưỡng miễn phí** | ~1,000 bookings/tháng |
| **Ngưỡng $200/tháng** | ~3,000 bookings/tháng |
| **Rủi ro lớn nhất** | API key bị abuse (không có referrer restriction) |
| **Tối ưu hiệu quả nhất** | Thêm Session Token → giảm 70-80% Places cost |
| **Phương án backup** | OpenStreetMap (miễn phí 100%, config đã sẵn sàng) |

---

> 📅 **Cập nhật lần cuối:** 15/03/2026
> 📋 **Nguồn giá:** [Google Maps Platform Pricing](https://developers.google.com/maps/billing-and-pricing/pricing)
> 🔗 **Tài liệu liên quan:** [GOOGLE-DISTANCE-INTEGRATION.md](GOOGLE-DISTANCE-INTEGRATION.md) | [OPENSTREETMAP-INTEGRATION.md](OPENSTREETMAP-INTEGRATION.md) | [FIX-GOOGLE-API-ERROR.md](FIX-GOOGLE-API-ERROR.md)
