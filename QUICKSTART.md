# 🚀 Quick Start - Laravel 12 với Docker

## Cài đặt nhanh

### Phương án 1: Cài Laravel mới (Khuyến nghị)

```bash
cd laravel-docker-base
make install-laravel
```

**Hoặc:**

```bash
cd laravel-docker-base
chmod +x setup.sh
./setup.sh
```

### Phương án 2: Đã có source Laravel

```bash
# 1. Copy source vào src/
cp -r /path/to/your/laravel/* ./src/

# 2. Chạy setup
make setup
```

---

## 🌐 Truy cập

- **Application**: http://localhost:8000
- **Mailhog**: http://localhost:8025

---

## 📝 Lệnh cơ bản

```bash
make up          # Khởi động
make down        # Dừng
make logs        # Xem logs
make shell       # Vào container
make migrate     # Chạy migration
make help        # Xem tất cả lệnh
```

---

## 🗄️ Database

- **Host**: localhost:3307
- **Database**: laravel
- **Username**: laravel
- **Password**: secret

---

## 📂 Cấu trúc

```
laravel-docker-base/
├── docker/          # Docker configs
│   ├── nginx/
│   └── php/
├── src/            # Laravel source ở đây
├── Makefile
└── docker-compose.yml
```

---

## 🆘 Troubleshooting

```bash
# Xem logs
make logs

# Restart
make restart

# Fix permissions
make perm

# Clear cache
make cache-clear
```

---

## 📚 Đọc thêm

- **README.md** - Hướng dẫn đầy đủ
- **INSTALL.md** - Cài đặt chi tiết
