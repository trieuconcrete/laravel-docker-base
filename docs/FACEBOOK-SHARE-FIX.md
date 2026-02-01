# 🔧 Fix Facebook Share Preview - XeHo247.vn

## ❌ Vấn đề hiện tại:
- Facebook hiển thị: "Welcome to nginx!" 
- Không load được Open Graph image và description
- Cache cũ của Facebook

## ✅ Giải pháp:

### Bước 1: Clear Facebook Cache (BẮT BUỘC)

**Truy cập Facebook Sharing Debugger:**
```
https://developers.facebook.com/tools/debug/
```

**Các bước:**
1. Nhập URL: `https://xeho247.vn`
2. Click **"Debug"**
3. Xem preview cũ (sẽ thấy "Welcome to nginx")
4. Click **"Scrape Again"** (nút màu xanh)
5. Đợi 2-3 giây
6. Xem preview mới - phải thấy:
   - ✅ Title: "Thuê Tài Xế Lái Xe Hộ Đà Nẵng 24/7 - An Toàn, Uy Tín"
   - ✅ Description: "Dịch vụ thuê tài xế lái xe hộ chuyên nghiệp..."
   - ✅ Image: Logo Xế Hộ 24/7

### Bước 2: Verify Open Graph Tags

**Current OG Tags (ĐÃ CÓ SẴN):**
```html
<meta property="og:type" content="website">
<meta property="og:url" content="https://xeho247.vn">
<meta property="og:title" content="Thuê Tài Xế Lái Xe Hộ Đà Nẵng 24/7 - An Toàn, Uy Tín">
<meta property="og:description" content="Dịch vụ thuê tài xế lái xe hộ chuyên nghiệp tại Đà Nẵng. Phục vụ 24/7, tài xế đến trong 10 phút. Giá từ 150k. Hotline: 0559 304 993">
<meta property="og:image" content="https://xeho247.vn/images/logo.jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Xế Hộ 24/7 - Đà Nẵng">
<meta property="og:locale" content="vi_VN">
```

**Test OG Tags:**
```bash
curl -s https://xeho247.vn | grep "og:"
```

### Bước 3: Test Share Again

Sau khi clear cache:

1. **Vào Facebook** 
2. **Tạo post mới**
3. **Paste link:** `https://xeho247.vn`
4. **Đợi 2-3 giây** để Facebook load preview
5. **Xem preview mới:**
   - Phải hiển thị đúng title, description, image
   - Không còn "Welcome to nginx"

---

## 🎯 Nếu vẫn hiển thị sai:

### Option 1: Create OG Image (Recommended)

**Tại sao cần:**
- Logo hiện tại (250x250) quá nhỏ cho Facebook
- Facebook khuyến nghị: 1200x630px
- Hiển thị đẹp hơn khi share

**Tạo OG Image:**

1. **Dùng Canva (Free):**
   - Truy cập: https://www.canva.com/
   - Template: "Facebook Post" (1200x630)
   - Design:
     ```
     Background: Black gradient
     Logo: Xế Hộ 24/7 (center)
     Text: "Thuê Tài Xế Đà Nẵng 24/7"
     Hotline: 0559 304 993 (gold color)
     ```
   - Export: JPG, max quality
   - Filename: `og-image.jpg`

2. **Upload vào server:**
   ```bash
   # Từ local
   scp og-image.jpg cloudfly-hpl:/var/www/webroot/xeho247danang/src/public/images/
   
   # Hoặc dùng script
   ./deploy-xeho247.sh
   # Chọn option upload file
   ```

3. **Update home.blade.php:**
   ```html
   <!-- Change from -->
   <meta property="og:image" content="https://xeho247.vn/images/logo.jpeg">
   
   <!-- To -->
   <meta property="og:image" content="https://xeho247.vn/images/og-image.jpg">
   <meta property="og:image:width" content="1200">
   <meta property="og:image:height" content="630">
   ```

4. **Deploy:**
   ```bash
   ./deploy-xeho247.sh
   # Chọn option 1: Full Deploy
   ```

5. **Clear Facebook cache lại**

### Option 2: Force Facebook Re-scrape

Nếu Facebook vẫn cache cũ:

1. **Thêm query parameter:**
   ```
   Share: https://xeho247.vn?v=1
   ```

2. **Change OG URL trong code:**
   ```html
   <meta property="og:url" content="https://xeho247.vn?v=2026">
   ```

3. **Wait 24 hours** - Facebook sẽ tự động refresh

---

## 🧪 Testing Tools

### 1. Facebook Sharing Debugger
```
https://developers.facebook.com/tools/debug/
```
- Xem preview như Facebook thấy
- Clear cache
- Check lỗi OG tags

### 2. Open Graph Check
```
https://www.opengraph.xyz/
```
- Validate OG tags
- Preview trên nhiều platforms

### 3. LinkedIn Post Inspector (bonus)
```
https://www.linkedin.com/post-inspector/
```
- Test share trên LinkedIn

### 4. Twitter Card Validator
```
https://cards-dev.twitter.com/validator
```
- Test Twitter cards

---

## ✅ Checklist

```
☐ 1. Clear Facebook cache tại: https://developers.facebook.com/tools/debug/
☐ 2. Click "Scrape Again" 
☐ 3. Verify preview hiển thị đúng
☐ 4. Test share post mới trên Facebook
☐ 5. Check image hiển thị rõ ràng
☐ 6. (Optional) Tạo OG image 1200x630px
☐ 7. (Optional) Update og:image trong code
☐ 8. Monitor shares trong 24h
```

---

## 📊 Expected Result

**Trước khi fix:**
```
❌ XEHO247.VN
❌ Welcome to nginx!
❌ No image
```

**Sau khi fix:**
```
✅ Thuê Tài Xế Lái Xe Hộ Đà Nẵng 24/7 - An Toàn, Uy Tín
✅ Dịch vụ thuê tài xế lái xe hộ chuyên nghiệp tại Đà Nẵng...
✅ Logo image (250x250) hoặc OG image (1200x630)
```

---

## 🚨 Common Issues

### Issue 1: "Could not scrape URL"
**Fix:**
- Check website accessible: `curl -I https://xeho247.vn`
- Check không bị firewall block Facebook IPs
- Check robots.txt không block Facebook bot

### Issue 2: Image không load
**Fix:**
- Check image URL trả về 200: `curl -I https://xeho247.vn/images/logo.jpeg`
- Image phải > 200x200px
- Image không quá nặng (< 8MB)
- Dùng absolute URL (có https://)

### Issue 3: Cached quá lâu
**Fix:**
- Đợi 24 giờ
- Thêm ?v=timestamp vào URL
- Share với URL khác nhau mỗi lần

---

**Last Updated:** 2026-01-31
**Status:** Facebook cache cũ - Cần clear bằng Sharing Debugger
