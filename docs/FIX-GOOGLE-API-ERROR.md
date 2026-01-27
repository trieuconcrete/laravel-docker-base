# 🔧 HƯỚNG DẪN FIX LỖI "API NOT ACTIVATED"

## ❌ Lỗi hiện tại
```
Google Maps API error: ApiNotActivatedMapError
```

Lỗi này xảy ra vì **API chưa được enable** trong Google Cloud Console.

---

## ✅ GIẢI PHÁP - Enable APIs (5 phút)

### Cách 1: Enable nhanh qua link trực tiếp

Click vào các link sau để enable từng API (đăng nhập Google trước):

1. **Maps JavaScript API** (BẮT BUỘC)
   https://console.cloud.google.com/apis/library/maps-backend.googleapis.com

2. **Places API** (BẮT BUỘC)
   https://console.cloud.google.com/apis/library/places-backend.googleapis.com

3. **Distance Matrix API** (BẮT BUỘC)
   https://console.cloud.google.com/apis/library/distance-matrix-backend.googleapis.com

**Với mỗi link:**
- Chọn đúng Project (project có API key của bạn)
- Click nút **"Enable"** màu xanh
- Chờ vài giây

---

### Cách 2: Enable thủ công trong Console

**Bước 1:** Vào https://console.cloud.google.com/

**Bước 2:** Chọn Project
- Click dropdown góc trên bên trái
- Chọn project đang dùng

**Bước 3:** Vào APIs & Services > Library
- Menu bên trái → "APIs & Services" → "Library"
- Hoặc search "API Library"

**Bước 4:** Search và Enable từng API

Tìm kiếm và enable 3 APIs này:

**1. Maps JavaScript API**
- Search: "Maps JavaScript API"
- Click vào kết quả
- Click nút "Enable" màu xanh
- ✅ Status sẽ chuyển thành "API enabled"

**2. Places API**
- Search: "Places API"
- Click vào kết quả
- Click nút "Enable"
- ✅ Enabled

**3. Distance Matrix API**
- Search: "Distance Matrix API"
- Click vào kết quả  
- Click nút "Enable"
- ✅ Enabled

---

## ⚠️ Yêu cầu Billing Account

Google Maps APIs yêu cầu **billing account** (liên kết thẻ), NHƯNG:
- ✅ Bạn có **$200 miễn phí mỗi tháng**
- ✅ Website nhỏ/vừa thường KHÔNG tốn phí
- ✅ Chỉ bị trừ tiền khi vượt $200/tháng

### Cách setup Billing:

**Bước 1:** Vào Billing
```
https://console.cloud.google.com/billing
```

**Bước 2:** Create Billing Account
- Click "Create Account"
- Nhập thông tin thẻ (Visa/Mastercard)
- Xác nhận

**Bước 3:** Link Billing Account với Project
- Vào Project Settings
- Chọn Billing Account vừa tạo
- Save

**Lưu ý:** Google có thể charge $1 để verify thẻ, sau đó refund lại.

---

## 🧪 Kiểm tra sau khi Enable

**Cách 1: Dùng file test HTML**
```bash
open test-google-api.html
```
- Nếu thấy màu XANH ✅ = Thành công
- Nếu vẫn đỏ ❌ = Chờ 1-2 phút rồi refresh

**Cách 2: Kiểm tra trạng thái APIs**
```
https://console.cloud.google.com/apis/dashboard
```
- Xem danh sách APIs đã enable
- Phải có đủ 3 APIs kể trên

**Cách 3: Test trực tiếp trên website**
```bash
cd /Users/apple/Documents/Work/Projects/laravel-docker-base
# Chạy Docker containers nếu chưa chạy
docker-compose up -d
# Mở website
open http://localhost
```

---

## 🚨 Các lỗi khác có thể gặp

### 1. "Billing Not Enabled Map Error"
➡️ Chưa enable billing → Làm theo hướng dẫn Billing ở trên

### 2. "Referer Not Allowed Map Error"  
➡️ Domain chưa được whitelist
- Vào: https://console.cloud.google.com/apis/credentials
- Click vào API key
- Trong "Application restrictions", chọn "None" hoặc thêm domain

### 3. "Invalid Key Map Error"
➡️ API key không đúng
- Kiểm tra lại file .env
- Tạo API key mới nếu cần

### 4. "Over Quota Map Error"
➡️ Vượt quota miễn phí $200/tháng
- Kiểm tra usage: https://console.cloud.google.com/apis/dashboard
- Cân nhắc tăng budget limit

---

## 📊 Monitoring Usage (Tránh bị charge)

**Xem usage hiện tại:**
```
https://console.cloud.google.com/apis/dashboard
```

**Set budget alert:**
1. Vào: https://console.cloud.google.com/billing
2. "Budgets & alerts"
3. "Create budget"
4. Set limit: $50 hoặc $100
5. Email alert khi đạt 50%, 80%, 100%

---

## 💡 Phương án thay thế (Nếu không muốn dùng Billing)

### Option 1: Dùng OpenStreetMap (Miễn phí 100%)
- Không cần thẻ tín dụng
- Tôi có thể chuyển code sang dùng OSM
- Chất lượng data tốt cho Việt Nam

### Option 2: Mapbox (Free tier)
- 50,000 requests/tháng miễn phí
- Không cần thẻ ban đầu
- API tương tự Google Maps

**Bạn có muốn tôi chuyển sang dùng phương án miễn phí?**

---

## ✅ Checklist hoàn thành

- [ ] Enable Maps JavaScript API
- [ ] Enable Places API
- [ ] Enable Distance Matrix API
- [ ] Setup Billing Account
- [ ] Link Billing với Project
- [ ] Test với file test-google-api.html
- [ ] Website hiển thị khoảng cách và giá

---

## 🆘 Cần hỗ trợ?

**Nếu vẫn gặp lỗi sau khi làm theo hướng dẫn:**

1. Chụp screenshot lỗi trong browser console (F12)
2. Check trạng thái APIs: https://console.cloud.google.com/apis/dashboard
3. Cho tôi biết lỗi cụ thể để hỗ trợ

**Hoặc chọn phương án miễn phí:**
- Tôi sẽ chuyển sang dùng OpenStreetMap API (miễn phí hoàn toàn)
- Không cần thẻ, không giới hạn
- 15-20 phút để implement

---

## 📞 Liên hệ Google Support
Nếu không tự fix được:
https://developers.google.com/maps/support
