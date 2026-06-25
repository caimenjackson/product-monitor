# Product Monitor

<img width="1794" height="1025" alt="Screenshot_25-6-2026_35622_product-monitor test" src="https://github.com/user-attachments/assets/f3a1a6ce-6a9d-4dbb-be37-07c7e622e6dc" />


A Laravel 11 web application for tracking food product batches throughout the day — logging cook times, expiry countdowns, sales, and waste for kitchen operations.

## Features

- Track cooked batches per product with automatic expiry timers
- Log fresh sales, expired sales, and waste per batch
- Daily product reset via scheduled command (`products:reset`)
- PDF export of the daily product control sheet
- Username/password authentication (no email required)

## Requirements

- PHP 8.2+
- [Laravel Herd](https://herd.laravel.com/) (or any local PHP environment)
- Composer

No database server is required — the app uses SQLite by default.

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/caimenjackson/batchtrack
cd batchtrack
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

The default `.env.example` is configured for SQLite. No database changes are needed.

### 4. Run migrations and seed products

```bash
php artisan migrate
php artisan db:seed
```

This creates all tables and seeds the default product list for today.

### 5. Create a user

```bash
php artisan tinker
```

Then inside tinker:

```php
DB::table('users')->insert([
    'username' => 'admin',
    'password' => bcrypt('yourpassword'),
    'created_at' => now(),
    'updated_at' => now(),
]);
exit
```

### 6. Serve the application

With Herd, place the project in your Herd sites directory and visit `http://product-monitor.test`.

Or use the built-in dev server:

```bash
php artisan serve
```

Then visit `http://localhost:8000`.

## Daily Reset

Products are scoped to a specific date. Each day, run the following command to carry yesterday's product list forward to today with zeroed quantities:

```bash
php artisan products:reset
```

To automate this, schedule it via your system's task scheduler (Windows Task Scheduler or cron) to run at 5:00 AM daily:

```
php /path/to/artisan products:reset
```

Or if using Laravel's built-in scheduler, add it to `routes/console.php`:

```php
Schedule::command('products:reset')->dailyAt('05:00');
```

And run the scheduler via cron:

```
* * * * * php /path/to/artisan schedule:run
```

## Usage

| Action | Description |
|--------|-------------|
| **Cook** | Log a batch of a product as cooked — starts the expiry timer |
| **Sell** | Record units sold (automatically tracks fresh vs expired) |
| **Waste** | Record discarded units |
| **Export PDF** | Download the daily product control sheet |

## Database

The app defaults to SQLite (`database/database.sqlite`). To switch to MySQL, update your `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_monitor
DB_USERNAME=your_username
DB_PASSWORD=your_password

SESSION_DRIVER=database
CACHE_STORE=database
```

Then run `php artisan migrate`.
