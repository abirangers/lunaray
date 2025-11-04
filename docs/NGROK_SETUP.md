# 🚀 Ngrok Setup Guide - Lunaray Beauty Factory

## Quick Start untuk Presentasi

### 1️⃣ Install Ngrok

**Option A: Download Manual**
```bash
# Download dari: https://ngrok.com/download
# Extract ke folder (contoh: C:\ngrok\)
# Add ke PATH environment variable
```

**Option B: Install via Winget**
```bash
winget install ngrok
```

**Option C: Install via Chocolatey**
```bash
choco install ngrok
```

### 2️⃣ Setup Authtoken (Gratis)

1. **Sign up** di https://dashboard.ngrok.com/signup
2. **Copy authtoken** dari dashboard
3. **Run command**:
```bash
ngrok config add-authtoken YOUR_AUTHTOKEN_HERE
```

### 3️⃣ Start Ngrok Tunnel

**Cara Mudah (Recommended):**
```bash
# Double click file ini:
start-ngrok.bat
```

**Cara Manual:**
```bash
# Terminal 1: Start Laravel
php artisan serve

# Terminal 2: Start Ngrok
ngrok http 8000
```

### 4️⃣ Copy URL dan Share!

Setelah ngrok running, kamu akan lihat output seperti ini:
```
Session Status                online
Account                       your-email@example.com
Version                       3.x.x
Region                        Asia Pacific (ap)
Forwarding                    https://abc123.ngrok-free.app -> http://localhost:8000
```

**Copy URL HTTPS** (contoh: `https://abc123.ngrok-free.app`) dan share ke atasan!

---

## 📋 Checklist Sebelum Presentasi

- [ ] Ngrok installed dan authtoken configured
- [ ] Laravel server running (`php artisan serve`)
- [ ] Database migrated (`php artisan migrate`)
- [ ] Seeder run untuk test data (`php artisan db:seed`)
- [ ] Ngrok tunnel active dan URL copied
- [ ] Test akses dari browser lain (incognito/private mode)
- [ ] Test fitur chat (guest dan authenticated)
- [ ] Test artikel creation dan viewing
- [ ] Test user profile management

---

## 🎯 Tips untuk Presentasi

### 1. **Persiapan Data**
```bash
# Reset database dan seed fresh data
php artisan migrate:fresh --seed

# Atau seed specific data
php artisan db:seed --class=ArticleSeeder
php artisan db:seed --class=UserSeeder
```

### 2. **Clear Cache**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### 3. **Test Credentials**
Gunakan credentials dari `TESTING_CREDENTIALS.md`:
- **Admin**: admin@lunaray.com / password
- **Content Manager**: contentmanager@lunaray.com / password
- **User**: user@lunaray.com / password

### 4. **Demo Flow Suggestion**

**A. Guest Experience:**
1. Buka ngrok URL
2. Show landing page
3. Browse articles
4. Test guest chat (tanpa login)
5. Show chat features (copy, reset, etc)

**B. User Experience:**
1. Login as user
2. View profile
3. Chat with bot
4. View articles with view count

**C. Content Manager:**
1. Login as content manager
2. Show admin dashboard
3. Create/edit article
4. Manage content
5. View analytics

**D. Admin Features:**
1. Login as admin
2. User management
3. System settings
4. Chat logs/analytics

---

## 🔧 Troubleshooting

### Problem: Ngrok not found
**Solution**: Add ngrok to PATH or use full path
```bash
C:\ngrok\ngrok.exe http 8000
```

### Problem: Port 8000 already in use
**Solution**: Use different port
```bash
php artisan serve --port=8001
ngrok http 8001
```

### Problem: Ngrok session expired
**Solution**: Free plan has 8-hour session limit. Restart ngrok:
```bash
# Stop and restart
stop-ngrok.bat
start-ngrok.bat
```

### Problem: CSRF token mismatch
**Solution**: Already handled! Chatbot API routes excluded from CSRF.

### Problem: Mixed content (HTTP/HTTPS)
**Solution**: Already handled! Proxy trust configured.

---

## 🌟 Advanced: Custom Domain (Paid Plan)

Jika punya ngrok paid plan, bisa pakai custom domain:

```bash
# Start dengan custom domain
ngrok http 8000 --domain=your-custom-domain.ngrok.app
```

Update `.env`:
```env
APP_URL=https://your-custom-domain.ngrok.app
NGROK_ENABLED=true
NGROK_DOMAIN=your-custom-domain.ngrok.app
```

---

## 🛑 Stop Ngrok

**Cara Mudah:**
```bash
# Double click file ini:
stop-ngrok.bat
```

**Cara Manual:**
```bash
# Press Ctrl+C di terminal ngrok
# Atau kill process
taskkill /F /IM ngrok.exe
```

---

## 📊 Monitoring Ngrok

**Ngrok Web Interface:**
- Buka: http://localhost:4040
- Lihat request logs
- Inspect requests/responses
- Replay requests

---

## 🔒 Security Notes

⚠️ **PENTING untuk Presentasi:**

1. **Jangan share credentials** di public
2. **Gunakan test data**, bukan data real
3. **Disable ngrok** setelah presentasi
4. **Change passwords** jika perlu
5. **Monitor access** via ngrok dashboard

---

## 📞 Support

Jika ada masalah:
1. Check ngrok logs: http://localhost:4040
2. Check Laravel logs: `storage/logs/laravel.log`
3. Restart services: `stop-ngrok.bat` → `start-ngrok.bat`

---

## ✅ Ready for Presentation!

Setelah setup selesai:
1. ✅ Ngrok running dengan URL public
2. ✅ Laravel server active
3. ✅ Database ready dengan test data
4. ✅ All features tested
5. ✅ URL shared ke atasan

**Good luck dengan presentasi! 🎉**

