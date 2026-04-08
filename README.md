# Blog 2

Laravel 12 blog platform with social interactions, moderation, newsletter, localization, and Filament admin panel.

## Stack

- PHP 8.2+
- Laravel 12
- Filament 5
- Tailwind CSS 4
- SQLite by default (easy to switch to MySQL/PostgreSQL)
- Pest 4 for tests

## Main Features

- Authentication with email verification flow
- Public posts list with search, category filter, and tag filter
- Draft vs published post visibility rules
- Author profiles with follow/unfollow
- Post bookmarks
- Post likes with counters
- Comment replies and likes
- Comment moderation (approved/pending)
- Newsletter with double opt-in and unsubscribe
- PL/EN locale switch
- Light/dark theme toggle
- Basic SEO improvements (meta tags + sitemap + robots)
- Filament admin access restricted to admin users

## Installation

```bash
git clone https://github.com/zstio-pt/blog-2
cd blog-2
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
```

## Development Run

Run backend server:

```bash
php artisan serve
```

In a second terminal run frontend watcher + queue listener:

```bash
composer run dev
```

## Tests

```bash
php artisan test
```

## Formatting

```bash
vendor/bin/pint
```

## Useful Routes

- `/posts` - posts list
- `/posts/{slug}` - post details
- `/bookmarks` - user bookmarks (verified users)
- `/account/settings` - profile settings
- `/admin` - Filament panel (admin users)
- `/sitemap.xml` - sitemap
