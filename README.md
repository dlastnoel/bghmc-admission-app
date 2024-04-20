
(April 16 - April 21)
# Admission App

### About
This admission app is web-based app that takes in patient management (fetching, creation, updating, deletion) and also for admissions.

### Tech Stack
- Laravel 11
- Vue JS 3
- Tailwind CSS
- Inertia JS

### Requirements
- PHP v8.2
- MySQL
- Composer
- Node
- Git

### Setup and Configuration

1. Cloning and installation

```bash
git clone https://github.com/dlastnoel/bghmc-admission-app.git
cd  bghmc-admission-app
composer install
npm install
```

2. Copy .env.example to .env
   
3. Generate APP_KEY
```bash
php artisan key:generate
```

4. Database setup
```bash
php artisan migrate --seed
```

5. Config and building
```bash
php artisan optimize:clear
php artisan optimize
npm run build
```