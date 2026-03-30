# 🎬 MCU Database Web

> **Marvel Cinematic Universe Database** — Bách khoa toàn thư điện ảnh Marvel phiên bản web interactive

[![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat-square&logo=php)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3-EF4223?style=flat-square&logo=codeigniter)](https://codeigniter.com)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## ✨ **Tính Năng**

- 🎞️ **40+ Phim MCU** đầy đủ thông tin (6 Phases)
- 📊 **Timeline Interactif** — Xem phim theo thứ tự thời gian
- 🔍 **Tìm kiếm & Lọc** — Phase, loại (movie/series), đánh giá
- 👥 **Nhân vật MCU** — Thông tin 8+ nhân vật chính
- 💎 **Infinity Stones Tracker** — Easter egg khi cuộn qua các phim
- 🎨 **UI/UX Hiện đại** — Smooth animations, dark theme, responsive
- ⚡ **API REST** — Fetch data động từ backend

---

## 🚀 **Cài Đặt**

### **Yêu Cầu**
- PHP 7.4+
- MySQL 5.7+
- Apache với mod_rewrite

### **Bước 1: Clone Repository**
```bash
git clone https://github.com/nmdai679/MCU_DataBase_Web.git
cd MCU_DataBase_Web
Bước 2: Cấu Hình Database
Tạo database: CREATE DATABASE mcu_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
Import file: database/mcu_database.sql vào phpMyAdmin hoặc MySQL CLI
Chỉnh sửa file application/config/database.php với thông tin kết nối
Bước 3: Khởi Chạy
bash
# Nếu có PHP local server
php -S localhost:8000

# Hoặc upload lên Apache server
# Truy cập: http://localhost/MCU_DataBase_Web
📁 Cấu Trúc Dự Án
Code
MCU_DataBase_Web/
├── application/
│   ├── controllers/
│   │   ├── Welcome.php       # Main controller
│   │   └── Api.php           # API endpoints
│   ├── models/
│   │   └── Mcu_model.php     # Database queries
│   ├── views/
│   │   └── main.php          # SPA view
│   └── config/
│       └── database.php      # Database config
├── assets/
│   ├── css/
│   │   ├── style.css         # Main styles
│   │   └── style-part2.css   # Additional styles
│   ├── js/
│   │   ├── script.js         # Main logic
│   │   └── script-part2.js   # API & Render
│   └── images/
│       └── posters/          # Movie posters
├── database/
│   └── mcu_database.sql      # Schema & seed data
├── system/                   # CodeIgniter framework
├── index.php                 # Front controller
├── .htaccess                 # Apache rewrite rules
└── README.md                 # This file
🔌 API Endpoints
Method	Endpoint	Mô Tả
GET	/api/movies	Lấy tất cả 40 phim
GET	/api/movies/{slug}	Chi tiết phim cụ thể
GET	/api/characters	Lấy 8+ nhân vật chính
GET	/api/phases	Lấy 6 phases MCU
Ví dụ Response:

JSON
{
  "status": "success",
  "count": 40,
  "data": [
    {
      "id": 1,
      "title": "Iron Man",
      "year": 2008,
      "rating": 8.0,
      "poster_url": "assets/images/posters/iron-man.jpg",
      "phase_num": 1,
      "description": "Tony Stark chế tạo bộ giáp..."
    }
  ]
}
🎨 Công Nghệ Sử Dụng
Frontend
HTML5 / CSS3
Glassmorphism effect
CSS Grid & Flexbox
Custom CSS properties
Animations & transitions
Vanilla JavaScript (No frameworks)
Fetch API
IntersectionObserver
Event handling
Backend
PHP 7.4+
CodeIgniter 3 (MVC framework)
MySQL with InnoDB
📊 Database Schema
Bảng: movies (40 records)
SQL
- id (PK)
- slug (UNIQUE)
- title, year, duration
- rating, box_office
- director, cast_list
- description, tagline
- bg_color, poster_url
- type (ENUM: movie/series/special)
- view_order (timeline)
- phase_id (FK → phases)
Bảng: characters (8 records)
SQL
- id (PK)
- slug (UNIQUE)
- name, alter_ego
- status (ENUM: active/deceased/unknown/special)
- status_label, bg_color, avatar_initials
- phase_1 to phase_6 (TINYINT: presence flags)
Bảng: phases (6 records)
SQL
- id (PK)
- phase_num (UNIQUE: 1-6)
- ten_phase, saga
- years, mo_ta (description)
- film_count, phase_hue (CSS hue)
🐛 Troubleshooting
Q: Ảnh poster không hiển thị?

Code
✓ Kiểm tra folder: assets/images/posters/
✓ File names phải match database (poster_url field)
✓ File permissions: 644
Q: API trả về error?

Code
✓ Database connection (application/config/database.php)
✓ Mod_rewrite enabled trên Apache
✓ Check error logs: tail -f application/logs/*.php
Q: Infinity Stones Tracker không xuất hiện?

Code
✓ Tracker cần ≥2 gem tags để hiển thị
✓ Kiểm tra console: document.querySelectorAll('.tl-tag--gem').length
💡 Hướng Phát Triển
 User authentication & login
 Watchlist / Bookmark phim
 User ratings & reviews
 Recommendation system
 Admin dashboard
 Multi-language support (i18n)
 Dark/Light mode toggle
 Export to PDF
📚 Học Từ Dự Án
Dự án này minh họa:

✅ MVC pattern với CodeIgniter 3
✅ RESTful API design
✅ Vanilla JS (không sử dụng frameworks)
✅ Advanced CSS (Grid, Custom properties, animations)
✅ MySQL relationships & queries
✅ SPA (Single Page Application)
✅ IntersectionObserver API
✅ Responsive design
🤝 Đóng Góp
Mọi pull request đều được chào đón! Vui lòng:

Fork repository
Tạo branch: git checkout -b feature/amazing-feature
Commit changes: git commit -m 'Add amazing feature'
Push to branch: git push origin feature/amazing-feature
Open Pull Request
📄 License
MIT License — Tự do sử dụng cho mục đích học tập & thương mại. Xem LICENSE file để chi tiết.

👨‍💻 Tác Giả
nmdai679 — HCMUT Student

GitHub: @nmdai679
Project: PHP - CodeIgniter 3
⭐ Nếu bạn thích dự án này, vui lòng cho 1 ⭐!
Code
Made with ❤️ by nmdai679