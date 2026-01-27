# 🗺️ OpenStreetMap Integration - 100% MIỄN PHÍ

## ✅ Hoàn thành chuyển đổi từ Google Maps sang OpenStreetMap

**Branch:** `feature/OpenStreetMap`

---

## 🎯 Tổng quan

Đã chuyển đổi hoàn toàn từ **Google Maps APIs** (cần billing) sang **OpenStreetMap APIs** (miễn phí 100%).

### Các API được sử dụng:

| API | Mục đích | Chi phí | Rate Limit |
|-----|----------|---------|------------|
| **Nominatim** | Geocoding (địa chỉ → tọa độ) | $0 | ~1 req/giây |
| **OSRM** | Routing & Distance | $0 | Không giới hạn |

---

## 🚀 Ưu điểm

### ✅ So với Google Maps:

| Tiêu chí | Google Maps | OpenStreetMap |
|----------|-------------|---------------|
| **Chi phí** | $200 free/tháng, sau đó charge | **$0 - Miễn phí hoàn toàn** |
| **API Key** | Bắt buộc | **Không cần** |
| **Billing Account** | Bắt buộc (thẻ tín dụng) | **Không cần** |
| **Setup phức tạp** | Phải enable 3 APIs | **Copy & paste code** |
| **Data Việt Nam** | Tốt | **Tốt (community maintain)** |
| **Rate Limit** | Theo quota | **Nominatim: ~1 req/s** |

### 💡 Khi nào dùng OpenStreetMap?

- ✅ Website traffic nhỏ/vừa (< 10,000 requests/tháng)
- ✅ Không muốn setup billing
- ✅ Không có thẻ tín dụng
- ✅ Budget = $0
- ✅ Dữ liệu Việt Nam (OSM có data tốt)

---

## 📝 Các thay đổi đã thực hiện

### 1. File: [src/resources/views/home.blade.php](src/resources/views/home.blade.php)

**Đã thay đổi:**

#### ❌ Xóa:
```html
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=...&libraries=places"></script>
```

#### ✅ Thêm:
```html
<!-- Leaflet CSS (optional, for future map display) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
```

### 2. JavaScript Logic

#### ❌ Xóa: Google Maps APIs
- `google.maps.places.Autocomplete`
- `google.maps.DistanceMatrixService`

#### ✅ Thêm: OpenStreetMap APIs

**A. Nominatim Geocoding:**
```javascript
// Tìm tọa độ từ địa chỉ
const response = await fetch(
    `https://nominatim.openstreetmap.org/search?` +
    `format=json&q=${encodeURIComponent(address)}&` +
    `countrycodes=vn&limit=1`,
    {
        headers: { 'User-Agent': 'XeHo247DaNang/1.0' }
    }
);
```

**B. OSRM Distance Calculation:**
```javascript
// Tính khoảng cách giữa 2 tọa độ
const osrmUrl = `https://router.project-osrm.org/route/v1/driving/` +
    `${lon1},${lat1};${lon2},${lat2}` +
    `?overview=false`;
```

**C. Address Autocomplete:**
- Dùng HTML5 `<datalist>` + Nominatim search
- Gợi ý địa chỉ khi gõ (debounce 1 giây)

### 3. Logic tính giá (Không đổi)

✅ **Giữ nguyên 100%** logic tính giá theo bảng giá:
- Ban ngày (6h-23h59): 150.000đ mở cửa + 15.000đ/km
- Ban đêm (0h-5h59): 200.000đ mở cửa + 15.000đ/km
- >30km: Liên hệ hotline

---

## 🧪 Testing

### File test: [test-openstreetmap.html](test-openstreetmap.html)

**Chức năng test:**
1. ✅ Geocoding (địa chỉ → tọa độ)
2. ✅ Distance calculation (2 địa điểm)
3. ✅ Price calculation (logic tính giá)

**Cách test:**
```bash
open test-openstreetmap.html
```

### Test cases đề xuất:

| Test Case | Input | Expected Output |
|-----------|-------|-----------------|
| **Khoảng cách ngắn** | Sân bay → Cầu Rồng | ~5km, 150.000đ |
| **Khoảng cách vừa** | Sân bay → Hội An | ~25km, 450.000đ |
| **Khoảng cách xa** | Đà Nẵng → Huế | ~100km, "Liên hệ hotline" |
| **Địa chỉ sai** | "abc123xyz" | Error message |

---

## 🚨 Lưu ý quan trọng

### 1. Nominatim Rate Limit

**Giới hạn:** ~1 request/giây

**Giải pháp:**
- ✅ Đã implement debounce 1 giây
- ✅ User phải gõ xong mới gọi API
- 💡 **Nâng cao:** Cache kết quả geocoding trong database
- 💡 **Production:** Host Nominatim server riêng (nếu traffic cao)

### 2. User-Agent bắt buộc

Nominatim yêu cầu header `User-Agent`:
```javascript
headers: {
    'User-Agent': 'XeHo247DaNang/1.0'
}
```

### 3. CORS

- ✅ Nominatim API: Hỗ trợ CORS
- ✅ OSRM API: Hỗ trợ CORS
- ✅ Gọi trực tiếp từ browser OK

---

## 📊 So sánh chi phí

### Giả sử: 10,000 requests/tháng

| Scenario | Google Maps | OpenStreetMap |
|----------|-------------|---------------|
| **Chi phí** | $0 (trong $200 free) | **$0** |
| **Setup** | 30 phút | **5 phút** |
| **Cần thẻ?** | Có | **Không** |
| **Risk bị charge** | Có (nếu vượt quota) | **Không bao giờ** |

### Giả sử: 100,000 requests/tháng

| Scenario | Google Maps | OpenStreetMap |
|----------|-------------|---------------|
| **Chi phí** | ~$400-500/tháng | **$0** hoặc host riêng ~$10/tháng |
| **Khuyến nghị** | Dùng Google (có budget) | Host Nominatim riêng |

---

## 🔧 Cách chạy production

### Option 1: Dùng public APIs (Recommended cho traffic nhỏ)

✅ **Đã implement** - Không cần làm gì thêm!

**Ưu điểm:**
- Miễn phí 100%
- Không cần setup gì

**Nhược điểm:**
- Rate limit ~1 req/s

### Option 2: Host Nominatim riêng (Cho traffic cao)

**Khi nào cần:**
- Traffic > 10,000 requests/ngày
- Cần autocomplete nhanh hơn

**Chi phí:**
- VPS: ~$5-10/tháng (DigitalOcean, Vultr)
- Data: ~10GB cho Vietnam data

**Hướng dẫn:**
```bash
# 1. Thuê VPS Ubuntu 20.04 (2GB RAM, 20GB disk)

# 2. Install Nominatim
docker run -it \
  -e PBF_URL=https://download.geofabrik.de/asia/vietnam-latest.osm.pbf \
  -p 8080:8080 \
  mediagis/nominatim:4.0

# 3. Update code trỏ về VPS
# Thay: https://nominatim.openstreetmap.org
# Bằng: https://your-vps-ip:8080
```

---

## 🎨 UI/UX không đổi

✅ **Giữ nguyên 100%:**
- Giao diện form đặt xe
- Vùng hiển thị khoảng cách & giá
- Animation và styling
- User experience

Người dùng **không nhận ra** sự khác biệt!

---

## 📱 Tương thích

| Browser | Nominatim | OSRM | Status |
|---------|-----------|------|--------|
| Chrome | ✅ | ✅ | OK |
| Firefox | ✅ | ✅ | OK |
| Safari | ✅ | ✅ | OK |
| Edge | ✅ | ✅ | OK |
| Mobile | ✅ | ✅ | OK |

---

## 🔄 Rollback về Google Maps (nếu cần)

Đơn giản! Chỉ cần:

```bash
# Checkout lại branch main
git checkout main

# Hoặc revert commit
git revert HEAD
```

---

## 📈 Monitoring & Analytics

### Theo dõi usage:

**Nominatim:**
- Không có dashboard
- Tự log trong code nếu cần

**OSRM:**
- Public service, không track usage
- Tự log nếu cần

### Đề xuất monitoring:

```javascript
// Log mỗi request
console.log('Geocoding request:', address);
console.log('Distance calculation:', origin, destination);

// Hoặc gửi về server
fetch('/api/log-map-usage', {
    method: 'POST',
    body: JSON.stringify({ type: 'geocoding', address })
});
```

---

## 🆘 Troubleshooting

### Lỗi: "Failed to fetch"

**Nguyên nhân:** CORS hoặc network

**Giải pháp:**
- Check internet connection
- Thử lại sau vài giây
- Nominatim đôi khi maintenance

### Lỗi: "No route found"

**Nguyên nhân:** Không tìm thấy đường đi

**Giải pháp:**
- Check địa chỉ có đúng không
- Thử địa chỉ gần hơn
- Có thể 2 điểm quá xa hoặc không có đường nối

### Lỗi: Rate limit

**Triệu chứng:** 429 Too Many Requests

**Giải pháp:**
- Tăng debounce time lên 2-3 giây
- Implement caching
- Cân nhắc host Nominatim riêng

---

## 🎓 Resources

### Documentation:
- **Nominatim:** https://nominatim.org/release-docs/latest/
- **OSRM:** http://project-osrm.org/docs/v5.24.0/api/
- **Leaflet:** https://leafletjs.com/ (nếu cần hiển thị map)

### Data:
- **Vietnam OSM data:** https://download.geofabrik.de/asia/vietnam.html
- **OSM Wiki:** https://wiki.openstreetmap.org/wiki/Vi:Main_Page

---

## ✅ Checklist hoàn thành

- [x] Xóa Google Maps API dependencies
- [x] Implement Nominatim geocoding
- [x] Implement OSRM distance calculation
- [x] Setup address autocomplete với datalist
- [x] Giữ nguyên logic tính giá
- [x] Giữ nguyên UI/UX
- [x] Tạo file test
- [x] Viết documentation
- [x] Test trên browser

---

## 📊 Kết luận

### ✅ Ưu điểm đã đạt được:

1. **$0 chi phí** - Hoàn toàn miễn phí
2. **Không cần setup phức tạp** - Copy & paste
3. **Không cần API key** - Không lo key leak
4. **Không cần billing** - Không lo bị charge
5. **Chất lượng tương đương** - Data OSM tốt cho VN

### ⚠️ Lưu ý:

- Rate limit Nominatim (~1 req/s)
- Nếu traffic cao, nên host riêng

### 🎯 Khuyến nghị:

**Cho website hiện tại:** ✅ **Dùng OpenStreetMap** (perfect fit!)

**Lý do:**
- Website thuê xe Đà Nẵng = traffic vừa phải
- $0 chi phí = tối ưu cho startup
- Chất lượng đủ tốt cho nhu cầu

---

## 🚀 Next Steps

1. **Merge branch này vào main:**
```bash
git add .
git commit -m "feat: migrate from Google Maps to OpenStreetMap APIs"
git push origin feature/OpenStreetMap
# Sau đó merge PR trên GitHub
```

2. **Deploy lên production:**
```bash
# Deploy như bình thường
# Không cần config API key gì cả!
```

3. **Monitor usage:**
- Theo dõi có lỗi gì không
- Check user experience
- Nếu cần, host Nominatim riêng sau

---

**Tác giả:** GitHub Copilot  
**Ngày:** 24/01/2026  
**Branch:** feature/OpenStreetMap  
**Status:** ✅ Ready for Production
