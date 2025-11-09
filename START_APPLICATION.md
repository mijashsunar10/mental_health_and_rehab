# Complete Application Startup Guide

## Overview
Your application requires multiple services running simultaneously for full functionality:
- Laravel Application Server
- Laravel Reverb (WebSocket for real-time chat)
- Queue Worker (for background jobs, emails, notifications)
- Vite (for frontend asset compilation)
- MySQL Database (via XAMPP)

---

## Prerequisites Checklist

Before starting, ensure:
- [ ] XAMPP is running (Apache & MySQL)
- [ ] Database `mental_health_and_rehab` exists
- [ ] `.env` file is properly configured
- [ ] Composer dependencies installed: `composer install`
- [ ] NPM dependencies installed: `npm install`
- [ ] Database migrated: `php artisan migrate`

---

## Option 1: Run Everything Manually (Recommended for Development)

### Terminal 1: Laravel Development Server
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab
php artisan serve
```
**Purpose**: Serves your Laravel application
**Access**: http://localhost:8000

---

### Terminal 2: Laravel Reverb (WebSocket Server)
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab
php artisan reverb:start
```
**Purpose**: Real-time chat and notifications
**Runs on**: ws://localhost:8080
**Required for**: Chat system, live notifications

**Alternative with debug mode**:
```bash
php artisan reverb:start --debug
```

---

### Terminal 3: Queue Worker
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab
php artisan queue:work --tries=3
```
**Purpose**: Processes background jobs (emails, notifications, payments)
**Required for**:
- Purchase confirmation emails
- Payment processing
- Appointment notifications
- Any queued jobs

**Alternative with verbose output**:
```bash
php artisan queue:work --verbose --tries=3
```

**Alternative to watch for code changes** (auto-restart):
```bash
php artisan queue:listen --tries=3
```

---

### Terminal 4: Vite Dev Server
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab
npm run dev
```
**Purpose**: Compiles and hot-reloads frontend assets (CSS, JS)
**Runs on**: http://localhost:5173
**Required for**: Tailwind CSS, JavaScript, live reload during development

---

## Option 2: Run Everything with One Command (Using Composer Script)

Your `composer.json` has a `dev` script, but it doesn't include Reverb. Here's how to use it:

### Terminal 1: Reverb
```bash
php artisan reverb:start
```

### Terminal 2: Everything Else
```bash
composer dev
```

This runs:
- Laravel server
- Queue worker
- Vite
- Laravel Pail (logs)

---

## Option 3: Using a Process Manager (Production-like)

### Install Concurrently (if not already installed)
```bash
npm install -g concurrently
```

### Create a start script

Add this to your `package.json` under `"scripts"`:
```json
"start:all": "concurrently -n \"laravel,reverb,queue,vite\" -c \"blue,magenta,yellow,green\" \"php artisan serve\" \"php artisan reverb:start\" \"php artisan queue:work --tries=3\" \"npm run dev\""
```

Then run:
```bash
npm run start:all
```

---

## Quick Start Commands (Copy & Paste)

### First Time Setup
```bash
# Navigate to project
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env  # If .env doesn't exist
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Daily Development Startup

**Open 4 Terminal Windows:**

**Terminal 1 - Laravel Server:**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab && php artisan serve
```

**Terminal 2 - Reverb (Chat):**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab && php artisan reverb:start
```

**Terminal 3 - Queue Worker:**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab && php artisan queue:work
```

**Terminal 4 - Vite (Frontend):**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mental_health_and_rehab && npm run dev
```

---

## Production Build Commands

When deploying to production:

```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Restart queue workers
php artisan queue:restart
```

---

## Useful Management Commands

### Clear All Caches
```bash
php artisan optimize:clear
```
This runs:
- `config:clear`
- `cache:clear`
- `route:clear`
- `view:clear`
- `event:clear`

### Restart Services
```bash
# Restart queue workers
php artisan queue:restart

# Restart Reverb
php artisan reverb:restart

# Restart everything (stop all terminals and restart)
```

### Monitor Queue Jobs
```bash
# See failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

### Monitor Logs
```bash
# Real-time logs (in separate terminal)
php artisan pail

# Or tail Laravel logs
tail -f storage/logs/laravel.log
```

---

## Troubleshooting

### Port Already in Use

**Laravel Server (8000)**:
```bash
php artisan serve --port=8001
```

**Reverb (8080)**:
Update `.env`:
```env
REVERB_PORT=8081
```

**Vite (5173)**:
Update `vite.config.js`:
```js
server: {
    port: 5174
}
```

### Queue Not Processing
```bash
# Check queue connection in .env
QUEUE_CONNECTION=database

# Make sure queue jobs table exists
php artisan queue:table
php artisan migrate

# Restart queue worker
php artisan queue:restart
php artisan queue:work
```

### Reverb Not Connecting
```bash
# Check .env configuration
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=599304
REVERB_APP_KEY=2gylv31nwyk4fww3jime
REVERB_APP_SECRET=lcm8v5nmitgufjwobfu8
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

# Clear config
php artisan config:clear

# Restart Reverb
php artisan reverb:restart
```

### Database Connection Issues
```bash
# Check MySQL is running in XAMPP
# Update .env database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mental_health_and_rehab
DB_USERNAME=root
DB_PASSWORD=

# Test connection
php artisan migrate:status
```

---

## Feature-Specific Requirements

### Chat System
**Required Services:**
- ✅ Reverb (`php artisan reverb:start`)
- ✅ Laravel Server (`php artisan serve`)
- ✅ Vite (`npm run dev`) - for Echo/Pusher JS

**Test**: Visit chat page, send message in one tab, see it appear in another

---

### Video Calls (Jitsi)
**Required Services:**
- ✅ Laravel Server (`php artisan serve`)

**Configuration**: Already configured in `.env` (JaaS or free Jitsi)

**Test**: Visit video call route, camera/mic should load

---

### Package Purchases & Payments
**Required Services:**
- ✅ Laravel Server (`php artisan serve`)
- ✅ Queue Worker (`php artisan queue:work`) - for confirmation emails

**Configuration**: Stripe keys in `.env`

**Test**: Purchase a package, check email confirmation

---

### Appointments & Notifications
**Required Services:**
- ✅ Laravel Server (`php artisan serve`)
- ✅ Queue Worker (`php artisan queue:work`)
- ✅ Reverb (`php artisan reverb:start`) - for live notifications

---

### AI Chatbot (Ollama)
**Required Services:**
- ✅ Laravel Server (`php artisan serve`)
- ✅ Ollama Service (external)

**Start Ollama**:
```bash
ollama serve
```

**Test**:
```bash
curl http://127.0.0.1:11434/api/generate -d '{
  "model": "llama3.2:3b",
  "prompt": "Hello"
}'
```

---

## Shell Script for Easy Startup (macOS/Linux)

Create `start.sh` in your project root:

```bash
#!/bin/bash

# Start all services for Mental Health & Rehab App

echo "🚀 Starting Mental Health & Rehab Application..."
echo ""

# Navigate to project directory
cd "$(dirname "$0")"

# Check if XAMPP is running
if ! pgrep -x "mysqld" > /dev/null; then
    echo "⚠️  Warning: MySQL doesn't appear to be running. Please start XAMPP."
    exit 1
fi

echo "✅ MySQL is running"
echo ""

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear

echo ""
echo "📋 Services will start in separate terminal windows:"
echo "   1. Laravel Server (http://localhost:8000)"
echo "   2. Reverb WebSocket (ws://localhost:8080)"
echo "   3. Queue Worker"
echo "   4. Vite Dev Server (http://localhost:5173)"
echo ""
echo "Press Ctrl+C in each terminal to stop services"
echo ""

# Start services in new terminal windows (macOS)
osascript -e 'tell application "Terminal" to do script "cd '"$(pwd)"' && php artisan serve"'
sleep 2
osascript -e 'tell application "Terminal" to do script "cd '"$(pwd)"' && php artisan reverb:start"'
sleep 2
osascript -e 'tell application "Terminal" to do script "cd '"$(pwd)"' && php artisan queue:work"'
sleep 2
osascript -e 'tell application "Terminal" to do script "cd '"$(pwd)"' && npm run dev"'

echo "✅ All services started!"
echo ""
echo "🌐 Access your application at: http://localhost:8000"
```

Make it executable:
```bash
chmod +x start.sh
./start.sh
```

---

## Summary: Minimum Required Commands

For **all features to work**, you need these **4 commands running simultaneously**:

1. **Laravel Server**: `php artisan serve`
2. **Reverb**: `php artisan reverb:start`
3. **Queue Worker**: `php artisan queue:work`
4. **Vite**: `npm run dev`

**Plus**: XAMPP (MySQL) must be running

---

## Quick Reference Card

```
┌─────────────────────────────────────────────────────────┐
│         MENTAL HEALTH & REHAB - QUICK START            │
├─────────────────────────────────────────────────────────┤
│ Terminal 1: php artisan serve                          │
│ Terminal 2: php artisan reverb:start                   │
│ Terminal 3: php artisan queue:work                     │
│ Terminal 4: npm run dev                                │
├─────────────────────────────────────────────────────────┤
│ App: http://localhost:8000                             │
│ WebSocket: ws://localhost:8080                         │
│ Vite: http://localhost:5173                            │
└─────────────────────────────────────────────────────────┘
```

Save this guide and use it every time you start development!
