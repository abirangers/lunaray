# 🚀 Pre-Deployment Checklist - Lunaray Beauty Factory
## Hostinger Shared Hosting Deployment Guide

**Target Environment**: Hostinger Shared Hosting
**Deployment Type**: Database Migration (NOT fresh)
**Queue Strategy**: Database + Cron Job
**Timeline**: 1 Week Fast Track
**Created**: 2025-11-05

---

## 📊 Deployment Overview

### Your Configuration:
- ✅ **Hosting**: Hostinger Shared Hosting (with SSH)
- ✅ **Queue**: `database` + cron job (every minute)
- ✅ **Email**: Skip for now (add later if needed)
- ✅ **Database**: Migrate existing data (users, articles, products)
- ✅ **Media**: Upload existing files from `storage/app/public/`
- ✅ **OAuth**: You will update Google credentials yourself
- ✅ **Chatbot**: You will configure n8n webhook URL yourself

### Timeline:
```
Day 1-2: Security & Code Changes (Phase 1)
Day 3: Database & Media Migration (Phase 2)
Day 4: Deployment to Hostinger (Phase 3)
Day 5: Testing & Fixes (Phase 4)
Day 6-7: Optimization & Monitoring (Phase 5)
```

---

## 📋 Phase 1: Security & Code Changes (Day 1-2)

**Estimated Time**: 4-6 hours
**Priority**: 🔴 CRITICAL

### Step 1.1: Security Audit (30 minutes)

#### Check Exposed Credentials
```bash
# Check if .env is in .gitignore
cat .gitignore | grep .env

# Check git history for exposed secrets
git log --all --full-history -- .env
```

**Action Items**:
- [ ] Verify `.env` is in `.gitignore`
- [ ] Verify no `.env` committed to git history
- [ ] If found in history: Clean git history (see instructions below)

**Clean Git History** (if needed):
```bash
# Backup first!
git clone your-repo lunaray-backup

# Remove .env from history using BFG
# Download: https://rtyley.github.io/bfg-repo-cleaner/
java -jar bfg.jar --delete-files .env

# Clean up
git reflog expire --expire=now --all
git gc --prune=now --aggressive

# Force push (WARNING: Team members need to re-clone)
git push origin --force --all
```

---

### Step 1.2: Remove Ngrok Code (5 minutes)

**Status**: ✅ **DONE** (Already cleaned in previous step)

Files cleaned:
- ✅ `app/Providers/AppServiceProvider.php` - Ngrok detection removed
- ✅ `bootstrap/app.php` - Trust all proxies removed

**Verification**:
```bash
# Verify no ngrok references
grep -r "ngrok" app/ bootstrap/ config/
# Should return: No results
```

---

### Step 1.3: Configure Queue for Hostinger (15 minutes)

#### Update Environment Configuration

**File**: `.env`

```bash
# Change from sync to database queue
QUEUE_CONNECTION=database
```

**Verify Queue Table Exists**:
```bash
php artisan queue:table
php artisan migrate
```

**Test Queue Locally**:
```bash
# Terminal 1: Start queue worker
php artisan queue:work --once

# Terminal 2: Dispatch test job
php artisan tinker
>>> dispatch(function() { \Log::info('Queue test!'); });

# Check logs
tail -f storage/logs/laravel.log
```

**Action Items**:
- [ ] Change `QUEUE_CONNECTION=database` in `.env`
- [ ] Run `php artisan queue:table` (if not exists)
- [ ] Run `php artisan migrate`
- [ ] Test queue locally
- [ ] Verify job processes successfully

---

### Step 1.4: Update Media Conversions (30 minutes)

Media conversions will use queue, so they need proper configuration.

**Files to Update**:
1. `app/Models/User.php`
2. `app/Models/Article.php`
3. `app/Models/Product.php`
4. `app/Models/ProductCategory.php`
5. `app/Models/Hero.php` (if exists)

**Current Code** (Example from Article.php):
```php
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('thumb')
        ->width(300)
        ->height(200);

    $this->addMediaConversion('medium')
        ->width(800)
        ->height(600);
}
```

**Two Options**:

**Option A: Queued (Recommended for Hostinger with Cron)** ✅
```php
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('thumb')
        ->width(300)
        ->height(200)
        ->queued(); // ← Will process via cron job

    $this->addMediaConversion('medium')
        ->width(800)
        ->height(600)
        ->queued(); // ← Will process via cron job
}
```

**Option B: Non-Queued (If cron fails)**
```php
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('thumb')
        ->width(300)
        ->height(200)
        ->nonQueued(); // ← Process immediately (user waits)
}
```

**RECOMMENDATION**: Use **Option A (Queued)** since you're using cron job.

**Action Items**:
- [ ] Update `User.php` - Add `->queued()` to avatar conversions
- [ ] Update `Article.php` - Add `->queued()` to featured conversions
- [ ] Update `Product.php` - Add `->queued()` to products conversions
- [ ] Update `ProductCategory.php` - Add `->queued()` to category conversions
- [ ] Update `Hero.php` - Add `->queued()` (if exists)
- [ ] Test image upload locally with queue worker running
- [ ] Verify conversions are created

---

### Step 1.5: Update Cache & Session Configuration (10 minutes)

**File**: `.env`

**Current** (Local Development):
```env
CACHE_STORE=database  # or file
SESSION_DRIVER=database
```

**Production** (Hostinger Compatible):
```env
# Cache Configuration
CACHE_STORE=file  # File cache is faster than database on shared hosting
CACHE_PREFIX=lunaray_cache

# Session Configuration
SESSION_DRIVER=database  # Keep database for sessions
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_SECURE_COOKIE=true  # HTTPS only
SESSION_SAME_SITE=lax
```

**Ensure Sessions Table Exists**:
```bash
php artisan session:table
php artisan migrate
```

**Action Items**:
- [ ] Set `CACHE_STORE=file` in `.env`
- [ ] Set `SESSION_DRIVER=database` in `.env`
- [ ] Run `php artisan session:table` (if not exists)
- [ ] Run `php artisan migrate`
- [ ] Test login/logout locally
- [ ] Verify session persists

---

### Step 1.6: Prepare Production `.env` Template (30 minutes)

Create production-ready `.env` file.

**File**: `.env.production` (NEW FILE - don't commit!)

```env
# ==========================================
# LUNARAY BEAUTY FACTORY - PRODUCTION CONFIG
# ==========================================
# Created: 2025-11-05
# Environment: Hostinger Shared Hosting
# ==========================================

# Application
APP_NAME="Lunaray Beauty Factory"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY_ON_SERVER
APP_DEBUG=false
APP_URL=https://lunaray.com

# Timezone
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id

# Database (Get from Hostinger Control Panel)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_lunaray
DB_USERNAME=u123456789_user
DB_PASSWORD=YOUR_SECURE_PASSWORD_FROM_HOSTINGER

# Cache & Session (NO REDIS ON SHARED HOSTING)
CACHE_STORE=file
CACHE_PREFIX=lunaray_cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

# Queue (DATABASE with CRON)
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=public

# Logging
LOG_CHANNEL=daily
LOG_LEVEL=error
LOG_DAILY_DAYS=14
LOG_DEPRECATIONS_CHANNEL=null

# Mail (SKIP FOR NOW - Add later if needed)
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@lunaray.com"
MAIL_FROM_NAME="${APP_NAME}"

# Google OAuth (UPDATE THESE WITH PRODUCTION CREDENTIALS)
GOOGLE_CLIENT_ID=your-production-client-id
GOOGLE_CLIENT_SECRET=your-production-client-secret
GOOGLE_REDIRECT_URI=https://lunaray.com/auth/google/callback

# n8n Chatbot (UPDATE WITH YOUR WEBHOOK URL)
N8N_WEBHOOK_URL=https://your-n8n-instance.com/webhook/chatbot

# Broadcasting (Not used, but required)
BROADCAST_CONNECTION=log

# AWS (Not used, but required)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

# Vite
VITE_APP_NAME="${APP_NAME}"

# ==========================================
# SECURITY NOTES
# ==========================================
# 1. Generate new APP_KEY: php artisan key:generate
# 2. Update Google OAuth redirect URI in Google Cloud Console
# 3. Update n8n webhook URL
# 4. NEVER commit this file to git!
# ==========================================
```

**Action Items**:
- [ ] Create `.env.production` file
- [ ] Fill in placeholder values (what you know now)
- [ ] Add to `.gitignore` (verify)
- [ ] Document what needs to be updated on server:
  - [ ] APP_KEY (generate on server)
  - [ ] Database credentials (from Hostinger)
  - [ ] Google OAuth credentials (you will update)
  - [ ] n8n webhook URL (you will update)

---

### Step 1.7: Add HTTPS Forcing (5 minutes)

**File**: `app/Providers/AppServiceProvider.php`

**Current Code** (Already done):
```php
public function boot(): void
{
    // Force HTTPS in production environment
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

**Status**: ✅ **ALREADY IMPLEMENTED**

**Verification**:
```bash
# Check code exists
grep -A 3 "Force HTTPS" app/Providers/AppServiceProvider.php
```

---

### Step 1.8: Optimize Composer Dependencies (10 minutes)

**Remove Development Dependencies** for production build:

```bash
# Install production dependencies only
composer install --optimize-autoloader --no-dev

# Verify no dev packages
composer show --installed | grep phpunit
# Should return: Nothing (phpunit removed)

# Re-install dev dependencies for local work
composer install
```

**Action Items**:
- [ ] Test `composer install --no-dev` locally
- [ ] Verify application still works
- [ ] Document this command for production deployment
- [ ] Re-install dev dependencies: `composer install`

---

### Step 1.9: Build Production Assets (15 minutes)

**Build optimized frontend assets**:

```bash
# Build production assets
npm run build

# Verify build output
ls -lh public/build/assets/

# Check bundle sizes
du -sh public/build/assets/app-*.js
du -sh public/build/assets/app-*.css

# Expected output:
# app-abc123.js: 200-500 KB (minified)
# app-def456.css: 50-150 KB (minified)
```

**Verify Manifest**:
```bash
cat public/build/manifest.json
# Should contain all asset paths
```

**Action Items**:
- [ ] Run `npm run build`
- [ ] Verify `public/build/` directory created
- [ ] Verify `public/build/manifest.json` exists
- [ ] Check bundle sizes are reasonable (<1MB)
- [ ] Test production build locally: `php artisan serve`
- [ ] Verify assets load correctly in browser
- [ ] **DO NOT delete build/ folder** - will upload to production

---

### Step 1.10: Test Application Locally with Production Config (30 minutes)

**Simulate production environment**:

```bash
# 1. Backup current .env
cp .env .env.backup

# 2. Copy production config
cp .env.production .env

# 3. Update database credentials (keep local DB for testing)
# Edit .env: Update DB_* to your local database

# 4. Generate APP_KEY
php artisan key:generate

# 5. Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 6. Run migrations (should be no-op if DB is current)
php artisan migrate --force

# 7. Start queue worker in background
php artisan queue:work &

# 8. Start application
php artisan serve
```

**Test Checklist**:
- [ ] Homepage loads (`http://localhost:8000`)
- [ ] Login works (both Google OAuth and Staff login)
- [ ] Admin dashboard accessible
- [ ] Article CRUD works
- [ ] Product CRUD works
- [ ] Image upload works (check queue processes conversion)
- [ ] Chatbot accessible (may not work without n8n webhook)
- [ ] No errors in `storage/logs/laravel.log`

**Verify Queue Processing**:
```bash
# Check queue jobs
php artisan queue:monitor

# Check failed jobs
php artisan queue:failed

# If jobs stuck, process manually:
php artisan queue:work --once
```

**After Testing**:
```bash
# Restore original .env
mv .env.backup .env

# Stop queue worker
pkill -f "queue:work"

# Clear caches
php artisan config:clear
```

**Action Items**:
- [ ] Test full application with production config
- [ ] Document any issues found
- [ ] Fix issues before proceeding
- [ ] Restore local `.env` after testing

---

## 📋 Phase 2: Database & Media Migration (Day 3)

**Estimated Time**: 2-3 hours
**Priority**: 🔴 CRITICAL

### Step 2.1: Export Local Database (30 minutes)

**Export database with mysqldump**:

```bash
# Export database
mysqldump -u root -p lunaray > lunaray_backup_$(date +%Y%m%d).sql

# Verify export
ls -lh lunaray_backup_*.sql
# Should be several MB (not 0 bytes)

# Check first few lines
head -20 lunaray_backup_*.sql
# Should show MySQL dump header
```

**Compress for faster upload**:
```bash
# Compress database dump
gzip lunaray_backup_$(date +%Y%m%d).sql

# Result: lunaray_backup_20251105.sql.gz
ls -lh lunaray_backup_*.sql.gz
```

**Action Items**:
- [ ] Export local database to SQL file
- [ ] Compress with gzip
- [ ] Verify file size (should be 1-10 MB)
- [ ] Keep backup safe (don't delete after upload)

---

### Step 2.2: Prepare Media Files for Upload (30 minutes)

**Package media files**:

```bash
# Navigate to storage directory
cd storage/app/public

# Check size
du -sh .
# Note the size (important for upload time estimation)

# Create compressed archive
tar -czf ../../../media_backup_$(date +%Y%m%d).tar.gz .

# Verify archive
cd ../../..
ls -lh media_backup_*.tar.gz

# Test archive integrity
tar -tzf media_backup_*.tar.gz | head -20
```

**What's included**:
- User avatars
- Article featured images
- Product images
- Category images
- Hero images
- Any other uploaded media

**Action Items**:
- [ ] Create compressed archive of `storage/app/public/`
- [ ] Verify archive integrity
- [ ] Note file size (for upload time estimation)
- [ ] Keep backup safe

---

### Step 2.3: Clean Sensitive Data (Optional but Recommended) (30 minutes)

**Option A: Clean sensitive user data**

If you want to remove real user emails/passwords before production:

```sql
-- Export to SQL first, then run these updates:

-- Update user emails
UPDATE users
SET email = CONCAT('user_', id, '@example.com')
WHERE email NOT LIKE '%@lunaray.com';

-- Clear Google tokens
UPDATE users
SET google_token = NULL,
    google_refresh_token = NULL;

-- Clear remember tokens
UPDATE users
SET remember_token = NULL;

-- Update phone numbers (if any)
UPDATE users
SET phone = NULL;
```

**Option B: Keep all data as-is**

Skip this step if you want to preserve real user data.

**Action Items**:
- [ ] Decide: Clean sensitive data or keep as-is?
- [ ] If cleaning: Run SQL updates on exported dump
- [ ] Document what was cleaned (for your records)

---

### Step 2.4: Verify Data Integrity (15 minutes)

**Check critical data counts**:

```bash
# MySQL CLI
mysql -u root -p lunaray

# Check counts
SELECT COUNT(*) AS total_users FROM users;
SELECT COUNT(*) AS total_articles FROM articles;
SELECT COUNT(*) AS total_products FROM products;
SELECT COUNT(*) AS total_categories FROM product_categories;
SELECT COUNT(*) AS total_media FROM media;

# Check roles
SELECT name, COUNT(*) AS user_count
FROM roles r
JOIN model_has_roles mr ON r.id = mr.role_id
GROUP BY r.name;

# Exit
exit;
```

**Document counts** (compare after import to verify):
```
Users: _____
Articles: _____
Products: _____
Categories: _____
Media Files: _____
Admins: _____
Content Managers: _____
```

**Action Items**:
- [ ] Document all data counts
- [ ] Save counts for post-import verification
- [ ] Verify no critical data missing

---

## 📋 Phase 3: Deployment to Hostinger (Day 4)

**Estimated Time**: 3-4 hours
**Priority**: 🔴 CRITICAL

### Step 3.1: Setup Hostinger Database (30 minutes)

**Via Hostinger Control Panel**:

1. **Login to Hostinger**
   - Go to: https://hpanel.hostinger.com

2. **Create Database**
   - Navigate: Hosting → Advanced → Databases
   - Click: "Create New Database"
   - Database Name: `lunaray` (or similar)
   - Username: Auto-generated (e.g., `u123456789_lunaray`)
   - Password: Generate strong password
   - Click: "Create"

3. **Note Credentials**
   ```
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=u123456789_lunaray
   DB_USERNAME=u123456789_user
   DB_PASSWORD=your_generated_password
   ```

4. **Access phpMyAdmin**
   - Click: "Manage" on your database
   - Opens: phpMyAdmin interface
   - Keep this tab open (will use for import)

**Action Items**:
- [ ] Create production database via Hostinger panel
- [ ] Save database credentials securely
- [ ] Test phpMyAdmin access
- [ ] Verify database is empty (no tables)

---

### Step 3.2: Upload Files to Hostinger (1-2 hours)

**Method A: Via Git (Recommended if SSH available)** ✅

```bash
# SSH into Hostinger
ssh u123456789@yourdomain.com

# Navigate to public_html
cd domains/lunaray.com/public_html

# Clone repository
git clone https://github.com/your-username/lunaray.git .

# Verify files
ls -la

# Should see: app/ bootstrap/ config/ database/ public/ etc.
```

**Method B: Via FTP (If no SSH)**

1. **Download FTP Client**: FileZilla or WinSCP
2. **Get FTP Credentials** from Hostinger panel (Hosting → FTP Accounts)
3. **Connect via FTP**
4. **Upload all files** except:
   - ❌ `.git/` folder (too many files, not needed)
   - ❌ `node_modules/` (will install on server)
   - ❌ `.env` (will create on server)
   - ❌ `storage/logs/*.log` (not needed)
   - ❌ `vendor/` (will install on server, but can upload if no SSH)

**Files to Upload**:
```
✅ app/
✅ bootstrap/
✅ config/
✅ database/
✅ public/
✅ resources/
✅ routes/
✅ storage/ (structure only, no logs)
✅ composer.json
✅ composer.lock
✅ package.json
✅ package-lock.json
✅ artisan
✅ .htaccess (if exists)
```

**Action Items**:
- [ ] Choose upload method (Git or FTP)
- [ ] Upload all application files
- [ ] Verify file structure on server
- [ ] DO NOT upload `.env` yet (will create separately)

---

### Step 3.3: Install Dependencies (30 minutes)

**If SSH available**:

```bash
# SSH into server
ssh u123456789@yourdomain.com

# Navigate to app directory
cd domains/lunaray.com/public_html

# Install Composer dependencies (production only)
composer install --optimize-autoloader --no-dev

# This will take 5-10 minutes
# Watch for any errors

# Verify vendor/ directory created
ls -la vendor/

# Should see: laravel/, spatie/, etc.
```

**If NO SSH available**:

You'll need to upload `vendor/` folder via FTP:
1. Run `composer install --no-dev` locally
2. Compress `vendor/` folder: `tar -czf vendor.tar.gz vendor/`
3. Upload `vendor.tar.gz` via FTP
4. Extract on server via Hostinger File Manager or create PHP extract script

**Action Items**:
- [ ] Install Composer dependencies on server
- [ ] Verify `vendor/` directory exists
- [ ] Check for any installation errors
- [ ] Verify Laravel framework installed

---

### Step 3.4: Create Production `.env` File (15 minutes)

**Via SSH**:

```bash
# Create .env file
nano .env

# Or copy from example
cp .env.example .env
nano .env
```

**Via Hostinger File Manager**:
1. Go to: File Manager
2. Navigate to: `public_html/`
3. Click: "New File" → Name: `.env`
4. Click: Edit
5. Paste production `.env` content (from Phase 1.6)

**Update with Hostinger-specific values**:
```env
# Database (from Step 3.1)
DB_DATABASE=u123456789_lunaray
DB_USERNAME=u123456789_user
DB_PASSWORD=your_hostinger_password

# APP_URL (your actual domain)
APP_URL=https://lunaray.com

# Generate APP_KEY (see next step)
```

**Action Items**:
- [ ] Create `.env` file on server
- [ ] Paste production config
- [ ] Update database credentials
- [ ] Update APP_URL
- [ ] Save file
- [ ] Verify file exists and has correct permissions (644)

---

### Step 3.5: Generate APP_KEY (5 minutes)

**Via SSH**:

```bash
# Generate new APP_KEY
php artisan key:generate

# Verify .env updated
grep APP_KEY .env
# Should show: APP_KEY=base64:randomstring
```

**Via PHP Script** (if no SSH):

Create temporary file `generate-key.php` in `public/` directory:

```php
<?php
// generate-key.php (DELETE AFTER USE!)
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('key:generate');

echo "APP_KEY generated! Check your .env file.\n";
echo "DELETE THIS FILE NOW!\n";
```

Access: `https://lunaray.com/generate-key.php`

**Action Items**:
- [ ] Generate APP_KEY on server
- [ ] Verify `.env` updated with new key
- [ ] Delete `generate-key.php` if created
- [ ] Verify APP_KEY is long random string

---

### Step 3.6: Set File Permissions (10 minutes)

**Via SSH**:

```bash
# Set directory permissions
chmod -R 755 /home/u123456789/domains/lunaray.com/public_html

# Set storage permissions (writable)
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Set specific subdirectories
chmod 775 storage/app/
chmod 775 storage/app/public/
chmod 775 storage/framework/
chmod 775 storage/framework/cache/
chmod 775 storage/framework/sessions/
chmod 775 storage/framework/views/
chmod 775 storage/logs/

# Verify permissions
ls -la storage/
```

**Via Hostinger File Manager**:
1. Right-click each directory → Properties → Permissions
2. Set storage/ directories to: **775** (rwxrwxr-x)
3. Set bootstrap/cache/ to: **775**

**Action Items**:
- [ ] Set storage/ permissions to 775
- [ ] Set bootstrap/cache/ permissions to 775
- [ ] Verify Laravel can write to these directories
- [ ] Check no permission errors in logs

---

### Step 3.7: Import Database (30 minutes)

**Via phpMyAdmin**:

1. **Open phpMyAdmin** (from Hostinger panel)
2. **Select Database**: Click your database (e.g., `u123456789_lunaray`)
3. **Click "Import" tab**
4. **Choose File**: Browse to `lunaray_backup_20251105.sql.gz`
5. **Format**: Auto-detect (should detect gzip)
6. **Click "Go"**
7. **Wait**: 1-5 minutes depending on size
8. **Verify**: Check "Tables" tab - should show all tables

**Expected Tables**:
```
articles
article_category
cache
cache_locks
categories
chat_messages
chat_sessions
failed_jobs
heroes
jobs
media
migrations
model_has_permissions
model_has_roles
password_reset_tokens
permissions
personal_access_tokens
products
product_categories
rich_texts
role_has_permissions
roles
sessions
user_activities
users
```

**Verify Data**:
```sql
-- Click "SQL" tab, run these queries:

SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM articles;
SELECT COUNT(*) FROM products;
SELECT COUNT(*) FROM media;

-- Compare with counts from Phase 2.4
```

**Action Items**:
- [ ] Upload SQL dump to server (if not already)
- [ ] Import via phpMyAdmin
- [ ] Verify all tables created
- [ ] Verify data counts match local database
- [ ] Check for any import errors

---

### Step 3.8: Upload Media Files (30-60 minutes)

**Via SSH** (if available):

```bash
# Upload media archive to server
scp media_backup_20251105.tar.gz u123456789@yourdomain.com:~/

# SSH into server
ssh u123456789@yourdomain.com

# Navigate to storage/app/public/
cd domains/lunaray.com/public_html/storage/app/public/

# Extract archive
tar -xzf ~/media_backup_20251105.tar.gz

# Verify files
ls -la
# Should see: avatars/, featured/, products/, etc.

# Set permissions
chmod -R 775 .

# Clean up archive
rm ~/media_backup_20251105.tar.gz
```

**Via FTP** (if no SSH):

1. Extract `media_backup_20251105.tar.gz` locally
2. Upload entire `storage/app/public/` folder via FTP
3. This may take 30-60 minutes depending on file count and size

**Action Items**:
- [ ] Upload media files to server
- [ ] Extract to `storage/app/public/`
- [ ] Verify folder structure matches local
- [ ] Set permissions to 775
- [ ] Test image URLs in browser

---

### Step 3.9: Create Storage Symlink (5 minutes)

**Via SSH**:

```bash
# Create symbolic link
php artisan storage:link

# Verify symlink created
ls -la public/storage
# Should show: storage -> ../storage/app/public
```

**Via PHP Script** (if no SSH):

Create `create-symlink.php` in `public/`:

```php
<?php
// create-symlink.php (DELETE AFTER USE!)
$target = '../storage/app/public';
$link = __DIR__ . '/storage';

if (file_exists($link)) {
    echo "Storage link already exists!\n";
} else {
    if (symlink($target, $link)) {
        echo "Storage link created successfully!\n";
    } else {
        echo "Failed to create storage link. Check permissions.\n";
    }
}
echo "DELETE THIS FILE NOW!\n";
```

Access: `https://lunaray.com/create-symlink.php`

**Test Storage Link**:
```bash
# Visit in browser (should show image):
https://lunaray.com/storage/products/1/product-image.jpg
```

**Action Items**:
- [ ] Create storage symlink
- [ ] Verify symlink exists: `public/storage` → `storage/app/public`
- [ ] Test image URL loads in browser
- [ ] Delete PHP script if created

---

### Step 3.10: Run Migrations (10 minutes)

**Via SSH**:

```bash
# Run migrations (should be no-op since DB already imported)
php artisan migrate --force

# Expected output:
# "Nothing to migrate" or "All migrations already run"
```

**If any new migrations**:
```bash
# Check migration status
php artisan migrate:status

# Run pending migrations
php artisan migrate --force
```

**Action Items**:
- [ ] Run `php artisan migrate --force`
- [ ] Verify no errors
- [ ] Check migration status
- [ ] Verify all tables exist

---

### Step 3.11: Cache Configuration (5 minutes)

**Via SSH**:

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache for production (IMPORTANT!)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Verify caches created
ls -la bootstrap/cache/
# Should see: config.php, routes-v7.php, packages.php, services.php
```

**Action Items**:
- [ ] Clear all caches
- [ ] Cache config, routes, views
- [ ] Verify cache files created
- [ ] Test application loads

---

### Step 3.12: Setup Cron Jobs (15 minutes)

**Via Hostinger Control Panel**:

1. **Navigate**: Advanced → Cron Jobs
2. **Click**: "Create New Cron Job"

**Cron Job 1: Laravel Scheduler** (REQUIRED)
```
Frequency: Every minute (*/1 * * * *)
Command: cd /home/u123456789/domains/lunaray.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

**Cron Job 2: Queue Worker** (REQUIRED for media conversions)
```
Frequency: Every minute (*/1 * * * *)
Command: cd /home/u123456789/domains/lunaray.com/public_html && php artisan queue:work --stop-when-empty --max-time=50 >> /dev/null 2>&1
```

**Notes**:
- `--stop-when-empty`: Exit when queue is empty (prevents hanging processes)
- `--max-time=50`: Max 50 seconds (prevents timeout on shared hosting)
- Both run every minute via cron
- Laravel scheduler decides what actually runs when

**Verify Cron Jobs**:
```bash
# Via SSH, check cron is running
crontab -l

# Should see both cron jobs listed
```

**Action Items**:
- [ ] Create Laravel scheduler cron job
- [ ] Create queue worker cron job
- [ ] Verify both jobs are active
- [ ] Wait 1-2 minutes and check logs: `storage/logs/laravel.log`
- [ ] Verify no cron errors

---

### Step 3.13: Configure PHP Settings (10 minutes)

**Create `.user.ini` in `public/` directory**:

```ini
; .user.ini - PHP configuration overrides
; These may or may not apply depending on Hostinger plan

; Upload limits
upload_max_filesize = 20M
post_max_size = 25M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M

; Error reporting (production)
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /home/u123456789/domains/lunaray.com/public_html/storage/logs/php_errors.log

; Session
session.gc_maxlifetime = 7200

; Timezone
date.timezone = Asia/Jakarta
```

**Via Hostinger Control Panel**:
1. Navigate: Advanced → PHP Configuration
2. Set PHP version: **8.2** or **8.3**
3. Adjust settings if available:
   - upload_max_filesize: 20M
   - post_max_size: 25M
   - memory_limit: 256M

**Action Items**:
- [ ] Create `.user.ini` in `public/` directory
- [ ] Set PHP version to 8.2+ via Hostinger panel
- [ ] Adjust PHP settings if available
- [ ] Test file upload (max 20MB)
- [ ] Verify settings applied: `php -i | grep upload_max_filesize`

---

### Step 3.14: Setup SSL Certificate (10 minutes)

**Via Hostinger Control Panel**:

1. **Navigate**: SSL → Manage
2. **Select**: Free Let's Encrypt SSL
3. **Click**: "Install SSL"
4. **Wait**: 5-10 minutes for activation
5. **Enable**: "Force HTTPS" (redirect all HTTP to HTTPS)

**Verify SSL**:
```bash
# Visit in browser
https://lunaray.com

# Should show:
# - 🔒 Padlock icon (secure)
# - Valid certificate
# - No mixed content warnings
```

**Test HTTP to HTTPS Redirect**:
```bash
# Visit HTTP version (should redirect to HTTPS)
http://lunaray.com
```

**Action Items**:
- [ ] Install free SSL certificate via Hostinger
- [ ] Enable Force HTTPS
- [ ] Verify HTTPS works
- [ ] Verify HTTP redirects to HTTPS
- [ ] Check for mixed content warnings (none should appear)

---

## 📋 Phase 4: Testing & Verification (Day 5)

**Estimated Time**: 3-4 hours
**Priority**: 🔴 CRITICAL

### Step 4.1: Basic Functionality Tests (30 minutes)

**Test Homepage**:
- [ ] Visit `https://lunaray.com`
- [ ] Verify homepage loads without errors
- [ ] Check hero section displays correctly
- [ ] Verify product slider works
- [ ] Check all images load (no broken images)
- [ ] Test responsive design (mobile, tablet, desktop)

**Test Navigation**:
- [ ] Click all navigation links
- [ ] Verify pages load correctly
- [ ] Check footer links
- [ ] Test breadcrumb navigation

**Check Console for Errors**:
- [ ] Open browser DevTools (F12)
- [ ] Check Console tab (should be no red errors)
- [ ] Check Network tab (all requests 200 OK)

---

### Step 4.2: Authentication Tests (30 minutes)

**Google OAuth Login**:
- [ ] Click "Login with Google"
- [ ] Verify redirect to Google
- [ ] Login with Google account
- [ ] Verify redirect back to site
- [ ] Check user is logged in
- [ ] Check profile page accessible

**Staff Login**:
- [ ] Visit `https://lunaray.com/staff/login`
- [ ] Login with admin credentials
- [ ] Verify redirect to admin dashboard
- [ ] Check admin navigation visible

**Logout**:
- [ ] Click logout
- [ ] Verify redirect to homepage
- [ ] Check user is logged out

**Action Items**:
- [ ] Test Google OAuth (may need to update redirect URI first)
- [ ] Test staff login
- [ ] Test logout
- [ ] Verify session persists across page loads
- [ ] Check no authentication errors in logs

---

### Step 4.3: Admin Dashboard Tests (30 minutes)

**Dashboard Access**:
- [ ] Login as admin
- [ ] Visit admin dashboard
- [ ] Verify statistics display correctly
- [ ] Check all admin navigation links work

**Article Management**:
- [ ] Go to Articles list
- [ ] Verify all articles display
- [ ] Create new test article
- [ ] Upload featured image
- [ ] Publish article
- [ ] Edit article
- [ ] Delete test article

**Product Management**:
- [ ] Go to Products list
- [ ] Verify all products display
- [ ] Create new test product
- [ ] Upload product image
- [ ] Verify categories dropdown works
- [ ] Save product
- [ ] Test drag & drop reordering (if available)
- [ ] Delete test product

**User Management** (if admin):
- [ ] Go to Users list
- [ ] Verify all users display
- [ ] Check roles display correctly
- [ ] View user profile

**Action Items**:
- [ ] Test all admin CRUD operations
- [ ] Verify bulk actions work
- [ ] Check search/filter/pagination
- [ ] Verify no errors in admin panel

---

### Step 4.4: Media Upload Tests (30 minutes)

**Test Image Uploads**:
- [ ] Upload user avatar (small: <1MB)
- [ ] Upload article featured image (medium: 1-5MB)
- [ ] Upload product image (large: 5-10MB)
- [ ] Verify upload succeeds

**Verify Queue Processing**:
```bash
# SSH into server
ssh u123456789@yourdomain.com

# Check queue jobs
cd domains/lunaray.com/public_html
php artisan queue:monitor

# Check for failed jobs
php artisan queue:failed

# Check logs
tail -50 storage/logs/laravel.log
```

**Verify Conversions Created**:
- [ ] Wait 1-2 minutes after upload (cron runs every minute)
- [ ] Check media conversions generated:
  - Thumb (300x200)
  - Medium (800x600)
  - Large (1200x800)
- [ ] Verify images display on frontend
- [ ] Test different conversion sizes load correctly

**Action Items**:
- [ ] Test image uploads in all contexts
- [ ] Verify queue processes jobs (check cron logs)
- [ ] Verify conversions are created
- [ ] Check no failed queue jobs
- [ ] Test image URLs load in browser

---

### Step 4.5: Chatbot Tests (15 minutes)

**Test Floating Chat**:
- [ ] Click Luna avatar (bottom-right)
- [ ] Verify chat panel opens
- [ ] Send test message

**Expected Behavior**:
- If n8n webhook configured: Message sends, receives response
- If n8n webhook NOT configured: Error message or timeout

**Check Logs**:
```bash
# Check chatbot errors
tail -50 storage/logs/laravel.log | grep -i chatbot
```

**Action Items**:
- [ ] Test chat functionality
- [ ] If errors: Document for later (update n8n webhook URL)
- [ ] Verify guest chat works (logout first, then test)
- [ ] Check rate limiting works (try sending 70 messages)

---

### Step 4.6: Public Pages Tests (30 minutes)

**Articles Page**:
- [ ] Visit articles index
- [ ] Verify all articles display
- [ ] Click article to view details
- [ ] Verify featured image displays
- [ ] Check rich text content renders correctly
- [ ] Test category filtering (if available)

**Products Page** (if public):
- [ ] Visit products page
- [ ] Verify product slider works
- [ ] Check category tabs work
- [ ] Verify product images load
- [ ] Test autoplay (if enabled)

**Profile Page**:
- [ ] Login as regular user
- [ ] Visit profile page
- [ ] Update profile information
- [ ] Upload avatar
- [ ] Verify changes saved

**Action Items**:
- [ ] Test all public-facing pages
- [ ] Verify SEO meta tags present
- [ ] Check Open Graph tags (for social sharing)
- [ ] Test responsive design on mobile

---

### Step 4.7: Performance Tests (30 minutes)

**Test Page Load Speed**:

1. **Google PageSpeed Insights**
   - Visit: https://pagespeed.web.dev/
   - Enter: `https://lunaray.com`
   - Run test
   - **Target**: 70+ score (mobile), 90+ score (desktop)

2. **GTmetrix**
   - Visit: https://gtmetrix.com/
   - Enter: `https://lunaray.com`
   - Run test
   - **Target**: Grade A or B, <3 seconds load time

**Check Metrics**:
- [ ] First Contentful Paint: <1.8s (good), <3s (acceptable)
- [ ] Largest Contentful Paint: <2.5s (good), <4s (acceptable)
- [ ] Total Page Size: <3MB (good), <5MB (acceptable)
- [ ] Number of Requests: <50 (good), <100 (acceptable)

**If Performance Poor**:
- Consider setting up Cloudflare CDN (Phase 5)
- Optimize images further
- Enable compression

**Action Items**:
- [ ] Run PageSpeed Insights test
- [ ] Run GTmetrix test
- [ ] Document scores
- [ ] Note any performance issues
- [ ] Plan optimizations if needed (Phase 5)

---

### Step 4.8: Error Log Review (15 minutes)

**Check Laravel Logs**:
```bash
# SSH into server
ssh u123456789@yourdomain.com

cd domains/lunaray.com/public_html

# Check recent errors
tail -100 storage/logs/laravel.log

# Check for specific error types
grep -i "error" storage/logs/laravel.log | tail -20
grep -i "exception" storage/logs/laravel.log | tail -20
grep -i "failed" storage/logs/laravel.log | tail -20
```

**Check PHP Error Logs**:
```bash
# Check PHP errors (if logged)
tail -50 storage/logs/php_errors.log
```

**Common Issues to Look For**:
- Database connection errors
- File permission errors
- Queue job failures
- Missing dependencies
- Configuration errors

**Action Items**:
- [ ] Review all error logs
- [ ] Document any errors found
- [ ] Fix critical errors immediately
- [ ] Plan fixes for minor errors
- [ ] Clear error logs after fixing: `> storage/logs/laravel.log`

---

### Step 4.9: Database Verification (15 minutes)

**Via phpMyAdmin**:

```sql
-- Verify data integrity

-- Check user count
SELECT COUNT(*) as total FROM users;

-- Check admin users exist
SELECT u.name, u.email, r.name as role
FROM users u
JOIN model_has_roles mr ON u.id = mr.model_id
JOIN roles r ON mr.role_id = r.id
WHERE r.name IN ('admin', 'content_manager');

-- Check articles
SELECT COUNT(*) as total FROM articles;
SELECT COUNT(*) as published FROM articles WHERE status = 'published';

-- Check products
SELECT COUNT(*) as total FROM products;
SELECT COUNT(*) as active FROM products WHERE status = 'active';

-- Check media files
SELECT COUNT(*) as total FROM media;

-- Check queue jobs (should be empty if processing)
SELECT COUNT(*) as pending FROM jobs;

-- Check failed jobs (should be 0)
SELECT COUNT(*) as failed FROM failed_jobs;
```

**Compare with Local Database** (from Phase 2.4):
- [ ] User counts match
- [ ] Article counts match
- [ ] Product counts match
- [ ] Media counts match
- [ ] No failed queue jobs

**Action Items**:
- [ ] Verify all data imported correctly
- [ ] Check no data lost during migration
- [ ] Verify relationships intact
- [ ] Check no orphaned records

---

### Step 4.10: Security Verification (15 minutes)

**Check File Permissions**:
```bash
# Via SSH
cd domains/lunaray.com/public_html

# Storage should be 775
ls -la storage/

# .env should be 644 (not 777!)
ls -la .env

# bootstrap/cache should be 775
ls -la bootstrap/cache/
```

**Check Environment**:
```bash
# Verify production environment
grep APP_ENV .env
# Should show: APP_ENV=production

# Verify debug is OFF
grep APP_DEBUG .env
# Should show: APP_DEBUG=false

# Verify APP_KEY is set
grep APP_KEY .env
# Should show long random string
```

**Test Security Headers**:
```bash
# Check security headers (via browser DevTools or curl)
curl -I https://lunaray.com

# Should see:
# X-Frame-Options: SAMEORIGIN
# X-Content-Type-Options: nosniff
# X-XSS-Protection: 1; mode=block
```

**Check HTTPS**:
- [ ] All pages load via HTTPS
- [ ] HTTP redirects to HTTPS
- [ ] No mixed content warnings
- [ ] SSL certificate valid

**Action Items**:
- [ ] Verify file permissions correct
- [ ] Verify production environment active
- [ ] Check security headers present
- [ ] Verify HTTPS enforced
- [ ] Test no sensitive data exposed

---

## 📋 Phase 5: Optimization & Monitoring (Day 6-7)

**Estimated Time**: 4-6 hours
**Priority**: 🟡 HIGH (but can be done post-launch)

### Step 5.1: Setup Cloudflare CDN (30 minutes)

**Sign Up & Add Domain**:
1. Visit: https://cloudflare.com
2. Sign up (free account)
3. Add site: `lunaray.com`
4. Select plan: **Free**

**Update Nameservers**:
1. Cloudflare will provide 2 nameservers:
   ```
   aden.ns.cloudflare.com
   uma.ns.cloudflare.com
   ```
2. Login to your domain registrar (GoDaddy, Namecheap, etc.)
3. Update nameservers to Cloudflare nameservers
4. Wait 1-24 hours for DNS propagation

**Configure Cloudflare Settings**:

**SSL/TLS**:
```
Encryption mode: Full (Strict)
Always Use HTTPS: ON
Automatic HTTPS Rewrites: ON
```

**Speed**:
```
Auto Minify:
  ✅ JavaScript
  ✅ CSS
  ✅ HTML

Brotli: ON
```

**Caching**:
```
Caching Level: Standard
Browser Cache TTL: 4 hours
```

**Page Rules** (3 free rules):
```
Rule 1: *lunaray.com/storage/*
  Cache Level: Cache Everything
  Edge Cache TTL: 1 month

Rule 2: *lunaray.com/build/*
  Cache Level: Cache Everything
  Edge Cache TTL: 1 month

Rule 3: *lunaray.com/media/*
  Cache Level: Cache Everything
  Edge Cache TTL: 1 month
```

**Action Items**:
- [ ] Sign up for Cloudflare (free)
- [ ] Add domain to Cloudflare
- [ ] Update nameservers at registrar
- [ ] Configure SSL/TLS settings
- [ ] Enable auto minify & Brotli
- [ ] Create page rules for static assets
- [ ] Wait for DNS propagation
- [ ] Test site loads via Cloudflare

---

### Step 5.2: Setup Error Tracking - Sentry (30 minutes)

**Sign Up for Sentry**:
1. Visit: https://sentry.io
2. Sign up (free tier: 5,000 errors/month)
3. Create new project: Laravel

**Get DSN**:
```
https://abc123@o123456.ingest.sentry.io/7890123
```

**Install Sentry** (via SSH):
```bash
cd domains/lunaray.com/public_html

composer require sentry/sentry-laravel

php artisan sentry:publish --dsn=your-sentry-dsn

# Clear config cache
php artisan config:clear
php artisan config:cache
```

**Update `.env`**:
```env
SENTRY_LARAVEL_DSN=https://abc123@o123456.ingest.sentry.io/7890123
SENTRY_TRACES_SAMPLE_RATE=0.1
```

**Test Sentry**:
```bash
# Trigger test error
php artisan sentry:test

# Check Sentry dashboard for error
```

**Action Items**:
- [ ] Sign up for Sentry (free tier)
- [ ] Install Sentry package
- [ ] Configure DSN in `.env`
- [ ] Test error tracking works
- [ ] Configure alert rules (email on errors)

---

### Step 5.3: Setup Uptime Monitoring (15 minutes)

**Sign Up for UptimeRobot**:
1. Visit: https://uptimerobot.com
2. Sign up (free tier: 50 monitors)
3. Create new monitor:
   - Monitor Type: HTTPS
   - Friendly Name: Lunaray Beauty Factory
   - URL: `https://lunaray.com`
   - Monitoring Interval: 5 minutes

**Configure Alerts**:
- Email: your-email@example.com
- Alert When: Down

**Action Items**:
- [ ] Sign up for UptimeRobot (free)
- [ ] Add site monitoring
- [ ] Configure email alerts
- [ ] Test alert (pause monitor, wait for email)
- [ ] Resume monitoring

---

### Step 5.4: Database Optimization (30 minutes)

**Add Missing Indexes** (if any):

```sql
-- Via phpMyAdmin SQL tab

-- Check queries without indexes
SHOW TABLE STATUS;

-- Common indexes to add (if missing):

-- Articles
CREATE INDEX idx_articles_status ON articles(status);
CREATE INDEX idx_articles_created_at ON articles(created_at);
CREATE INDEX idx_articles_user_id ON articles(user_id);

-- Products
CREATE INDEX idx_products_category_id_order ON products(category_id, order);
CREATE INDEX idx_products_status ON products(status);

-- Chat Messages
CREATE INDEX idx_chat_messages_session_id ON chat_messages(session_id);
CREATE INDEX idx_chat_messages_created_at ON chat_messages(created_at);

-- Media
CREATE INDEX idx_media_model_type_model_id ON media(model_type, model_id);
```

**Analyze Tables**:
```sql
-- Optimize all tables
ANALYZE TABLE users, articles, products, media;
```

**Action Items**:
- [ ] Review slow queries (if any)
- [ ] Add missing indexes
- [ ] Analyze tables
- [ ] Test query performance improved

---

### Step 5.5: Enable OPcache (5 minutes)

**Via Hostinger Control Panel**:
1. Navigate: Advanced → PHP Configuration
2. Find: OPcache
3. Enable: OPcache (if not already)

**Verify OPcache Enabled**:
```bash
# Via SSH
php -i | grep opcache.enable
# Should show: opcache.enable => On => On
```

**Expected Performance Boost**: 2-3x faster PHP execution

**Action Items**:
- [ ] Enable OPcache via Hostinger panel
- [ ] Verify OPcache active
- [ ] Test page load speed improved

---

### Step 5.6: Implement Cache Warming (30 minutes)

**Create Cache Warming Command**:

**File**: `app/Console/Commands/WarmCache.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Models\Article;
use App\Models\ProductCategory;

class WarmCache extends Command
{
    protected $signature = 'cache:warm';
    protected $description = 'Warm up application cache';

    public function handle()
    {
        $this->info('Warming cache...');

        // Cache featured products
        Cache::remember('products.featured', 3600, function () {
            return Product::with('category', 'media')
                ->where('is_featured', true)
                ->where('status', 'active')
                ->get();
        });

        // Cache all products by category
        $categories = ProductCategory::all();
        foreach ($categories as $category) {
            Cache::remember("products.category.{$category->id}", 3600, function () use ($category) {
                return $category->products()
                    ->with('media')
                    ->where('status', 'active')
                    ->orderBy('order')
                    ->get();
            });
        }

        // Cache featured articles
        Cache::remember('articles.featured', 3600, function () {
            return Article::with('author', 'categories', 'media')
                ->where('is_featured', true)
                ->where('status', 'published')
                ->latest()
                ->take(6)
                ->get();
        });

        // Cache recent articles
        Cache::remember('articles.recent', 3600, function () {
            return Article::with('author', 'categories', 'media')
                ->where('status', 'published')
                ->latest()
                ->take(10)
                ->get();
        });

        $this->info('Cache warmed successfully!');
    }
}
```

**Register Command**:

**File**: `app/Console/Kernel.php`

```php
protected function schedule(Schedule $schedule): void
{
    // Existing schedules...

    // Warm cache every hour
    $schedule->command('cache:warm')->hourly();
}
```

**Test Cache Warming**:
```bash
# Via SSH
php artisan cache:warm
```

**Action Items**:
- [ ] Create `WarmCache` command
- [ ] Add to scheduler
- [ ] Test command works
- [ ] Verify cache populated
- [ ] Monitor cache hit rate

---

### Step 5.7: Setup Backup Automation (30 minutes)

**Create Backup Script**:

**File**: `backup.sh` (in server home directory)

```bash
#!/bin/bash
# Lunaray Beauty Factory - Backup Script

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/u123456789/backups"
APP_DIR="/home/u123456789/domains/lunaray.com/public_html"
DB_NAME="u123456789_lunaray"
DB_USER="u123456789_user"
DB_PASS="your_db_password"

# Create backup directory if not exists
mkdir -p $BACKUP_DIR

# Backup database
echo "Backing up database..."
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_${DATE}.sql.gz

# Backup media files (incremental)
echo "Backing up media files..."
tar -czf $BACKUP_DIR/media_${DATE}.tar.gz -C $APP_DIR/storage/app/public .

# Keep only last 30 days
echo "Cleaning old backups..."
find $BACKUP_DIR -type f -mtime +30 -delete

echo "Backup completed: $DATE"
```

**Make Script Executable**:
```bash
chmod +x ~/backup.sh
```

**Add Cron Job for Backups**:

Via Hostinger Control Panel → Cron Jobs:
```
Frequency: Daily at 2:00 AM (0 2 * * *)
Command: /home/u123456789/backup.sh >> /home/u123456789/backup.log 2>&1
```

**Test Backup**:
```bash
# Run manually
./backup.sh

# Check backups created
ls -lh ~/backups/
```

**Action Items**:
- [ ] Create backup script
- [ ] Update database credentials in script
- [ ] Make script executable
- [ ] Add daily cron job
- [ ] Test backup runs successfully
- [ ] Document backup restoration procedure

---

### Step 5.8: Performance Re-test (30 minutes)

**After All Optimizations, Re-test**:

1. **PageSpeed Insights**
   - URL: https://pagespeed.web.dev/
   - Test: `https://lunaray.com`
   - Compare scores before vs after optimizations

2. **GTmetrix**
   - URL: https://gtmetrix.com/
   - Test: `https://lunaray.com`
   - Compare load times before vs after

**Expected Improvements**:
- Page load: 8-10s → 1-2s (with Cloudflare)
- First Contentful Paint: Improved by 50-70%
- PageSpeed Score: +20-30 points

**Document Results**:
```
BEFORE Optimizations:
- PageSpeed: __/100 (mobile), __/100 (desktop)
- Load Time: __s
- Page Size: __MB

AFTER Optimizations:
- PageSpeed: __/100 (mobile), __/100 (desktop)
- Load Time: __s
- Page Size: __MB

Improvement: __% faster
```

**Action Items**:
- [ ] Re-test with PageSpeed Insights
- [ ] Re-test with GTmetrix
- [ ] Document performance improvements
- [ ] Celebrate if 10x faster! 🎉

---

### Step 5.9: Create Deployment Documentation (1 hour)

**Document Your Deployment**:

**File**: `docs/DEPLOYMENT_NOTES.md`

```markdown
# Deployment Notes - Lunaray Beauty Factory

**Deployed Date**: 2025-11-05
**Deployed By**: [Your Name]
**Environment**: Hostinger Shared Hosting

## Server Details

**Hosting**:
- Provider: Hostinger
- Plan: Business/Premium/Cloud
- Server Location: [Location]

**Domain**:
- Primary: https://lunaray.com
- Nameservers: Cloudflare

**Database**:
- Host: localhost
- Database: u123456789_lunaray
- Username: u123456789_user

## Configuration

**PHP Version**: 8.2
**Laravel Version**: 11.x
**Queue**: Database + Cron Job
**Cache**: File
**Session**: Database

## Cron Jobs

1. Laravel Scheduler: Every minute
2. Queue Worker: Every minute

## Third-Party Services

**Cloudflare CDN**:
- Account: your-email@example.com
- Plan: Free

**Sentry Error Tracking**:
- Account: your-email@example.com
- Plan: Free (5K errors/month)
- DSN: [Sentry DSN]

**UptimeRobot**:
- Account: your-email@example.com
- Check Interval: 5 minutes

**Google OAuth**:
- Client ID: [Your Client ID]
- Redirect URI: https://lunaray.com/auth/google/callback

**n8n Chatbot**:
- Webhook URL: [Your Webhook URL]

## Backup Strategy

**Automated Backups**:
- Database: Daily at 2:00 AM
- Media Files: Daily at 2:00 AM
- Retention: 30 days

**Manual Backup**:
```bash
# Database
mysqldump -u [user] -p [database] > backup.sql

# Media
tar -czf media.tar.gz storage/app/public/
```

## Deployment Procedure

1. Pull latest code: `git pull origin main`
2. Install dependencies: `composer install --no-dev`
3. Run migrations: `php artisan migrate --force`
4. Clear caches: `php artisan config:clear && php artisan cache:clear`
5. Cache config: `php artisan config:cache && php artisan route:cache`
6. Restart queue: (handled by cron)

## Troubleshooting

**Issue**: Queue jobs not processing
**Solution**: Check cron jobs in Hostinger panel, verify `queue:work` cron active

**Issue**: Images not loading
**Solution**: Verify storage symlink exists: `ls -la public/storage`

**Issue**: 500 Internal Server Error
**Solution**: Check logs: `tail -50 storage/logs/laravel.log`

**Issue**: Database connection error
**Solution**: Verify `.env` database credentials match Hostinger panel

## Contact Information

**Developer**: [Your Name]
**Email**: [Your Email]
**Phone**: [Your Phone]

**Hostinger Support**: 24/7 Live Chat
**Emergency**: [Emergency Contact]

## Post-Deployment Checklist

- [x] Application deployed
- [x] Database migrated
- [x] Media files uploaded
- [x] SSL certificate active
- [x] Cron jobs configured
- [x] Cloudflare CDN configured
- [x] Error tracking (Sentry) active
- [x] Uptime monitoring (UptimeRobot) active
- [x] Backups automated
- [x] Performance tested
- [ ] Google OAuth production credentials updated
- [ ] n8n webhook URL configured
- [ ] Team trained on admin panel
- [ ] Documentation updated

## Future Improvements

- [ ] Implement comprehensive test coverage (Phase 8D)
- [ ] Setup staging environment
- [ ] Implement CI/CD pipeline
- [ ] Add email notifications
- [ ] Implement advanced analytics
- [ ] Add more monitoring (New Relic)
- [ ] Consider upgrading to Cloud Hosting for better performance

---

*Last Updated: 2025-11-05*
```

**Action Items**:
- [ ] Create deployment documentation
- [ ] Fill in all details (credentials, dates, etc.)
- [ ] Save securely (don't commit sensitive info to git)
- [ ] Share with team (without sensitive credentials)
- [ ] Update as needed

---

## ✅ Final Checklist - Ready for Production

### Critical Items (Must Complete)

- [ ] **Security**
  - [ ] `.env` not in git
  - [ ] APP_KEY generated for production
  - [ ] APP_DEBUG=false
  - [ ] Google OAuth credentials updated (you handle)
  - [ ] HTTPS enforced
  - [ ] File permissions correct (775 for storage/)

- [ ] **Application**
  - [ ] All files uploaded to Hostinger
  - [ ] Composer dependencies installed (--no-dev)
  - [ ] Database imported successfully
  - [ ] Media files uploaded
  - [ ] Storage symlink created
  - [ ] Migrations run
  - [ ] Caches built (config, route, view)

- [ ] **Configuration**
  - [ ] `.env.production` configured correctly
  - [ ] Queue: database + cron job
  - [ ] Cache: file
  - [ ] Session: database
  - [ ] PHP version: 8.2+
  - [ ] SSL certificate active

- [ ] **Cron Jobs**
  - [ ] Laravel scheduler running (every minute)
  - [ ] Queue worker running (every minute)
  - [ ] Both cron jobs verified active

- [ ] **Testing**
  - [ ] Homepage loads without errors
  - [ ] Authentication works (Google OAuth + Staff)
  - [ ] Admin dashboard accessible
  - [ ] CRUD operations work (articles, products)
  - [ ] Image uploads work
  - [ ] Queue processes jobs
  - [ ] No errors in logs

### High Priority Items (Should Complete)

- [ ] **Optimization**
  - [ ] Cloudflare CDN configured
  - [ ] Page rules for static assets
  - [ ] Auto minify & Brotli enabled
  - [ ] OPcache enabled
  - [ ] Cache warming implemented

- [ ] **Monitoring**
  - [ ] Sentry error tracking active
  - [ ] UptimeRobot monitoring site
  - [ ] Email alerts configured
  - [ ] Log monitoring in place

- [ ] **Backups**
  - [ ] Automated daily backups configured
  - [ ] Backup script tested
  - [ ] Backup retention policy (30 days)
  - [ ] Restoration procedure documented

- [ ] **Performance**
  - [ ] PageSpeed score: 70+ (mobile), 90+ (desktop)
  - [ ] Load time: <3 seconds
  - [ ] No performance bottlenecks

### Medium Priority Items (Can Complete Post-Launch)

- [ ] **Documentation**
  - [ ] Deployment notes created
  - [ ] Troubleshooting guide written
  - [ ] Team training completed
  - [ ] Admin manual created

- [ ] **Future Improvements**
  - [ ] Test coverage (Phase 8D)
  - [ ] Email service integration
  - [ ] Advanced monitoring (New Relic)
  - [ ] CI/CD pipeline
  - [ ] Staging environment

---

## 🎯 Timeline Summary

**Total Estimated Time**: 5-7 days

| Phase | Duration | Tasks |
|-------|----------|-------|
| **Phase 1**: Security & Code Changes | Day 1-2 (4-6 hours) | 10 steps |
| **Phase 2**: Database & Media Migration | Day 3 (2-3 hours) | 4 steps |
| **Phase 3**: Deployment to Hostinger | Day 4 (3-4 hours) | 14 steps |
| **Phase 4**: Testing & Verification | Day 5 (3-4 hours) | 10 steps |
| **Phase 5**: Optimization & Monitoring | Day 6-7 (4-6 hours) | 9 steps |

**Total Steps**: 47 detailed steps with commands and verification

---

## 📞 Support & Resources

### When You Need Help

**Hostinger Support**:
- 24/7 Live Chat (in hPanel)
- Knowledge Base: https://support.hostinger.com

**Laravel Documentation**:
- Deployment: https://laravel.com/docs/11.x/deployment
- Queues: https://laravel.com/docs/11.x/queues

**Community**:
- Laravel Discord: https://discord.gg/laravel
- Stack Overflow: Tag [laravel] [hostinger]

### Emergency Contacts

**Critical Issues** (site down, security breach):
1. Check Hostinger status: https://www.hostingerstatus.com/
2. Check error logs: `storage/logs/laravel.log`
3. Contact Hostinger support immediately
4. Restore from backup if necessary

**Non-Critical Issues**:
1. Document the issue
2. Check logs for errors
3. Search Laravel documentation
4. Ask in Laravel Discord/forums
5. Create GitHub issue (if bug in your code)

---

## 🎉 Post-Deployment

### After Successful Deployment

**Immediate Actions**:
- [ ] Announce launch to team/stakeholders
- [ ] Monitor error logs closely (first 24 hours)
- [ ] Watch uptime monitoring (UptimeRobot)
- [ ] Check performance metrics
- [ ] Verify backups running

**First Week**:
- [ ] Monitor daily active users
- [ ] Check for any recurring errors (Sentry)
- [ ] Review performance trends
- [ ] Gather user feedback
- [ ] Fix any critical issues

**First Month**:
- [ ] Review analytics and usage
- [ ] Optimize based on real data
- [ ] Plan feature improvements
- [ ] Update documentation
- [ ] Consider upgrade to Cloud hosting if traffic high

---

## 🚀 You're Ready to Deploy!

This comprehensive checklist will guide you through every step of deploying Lunaray Beauty Factory to Hostinger shared hosting.

**Remember**:
- Take your time with each step
- Test thoroughly before moving forward
- Document any issues you encounter
- Don't hesitate to ask for help
- Celebrate when you're done! 🎉

**Good luck with your deployment!** 💪

---

*Created: 2025-11-05*
*Version: 1.0*
*Author: Claude Code*
*Project: Lunaray Beauty Factory*
