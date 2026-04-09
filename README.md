# Modern Laravel Blog Platform

A clean, high-performance content management system built with Laravel 12 and Filament v5. Designed with focus on responsive user experience, social interactions, and modular architecture.

## Stack

- **Backend:** PHP 8.2+, Laravel 12
- **Admin Panel:** Filament 5
- **Frontend:** Tailwind CSS 4, Vite
- **Database:** SQLite (default), compatible with MySQL/PostgreSQL
- **Testing:** Pest 4

## Key Features

- **Authentication:** Custom, secure session flow with email verification support.
- **Social Interactions:** Profiles with follow/unfollow functionality, post bookmarks, comments, and likes.
- **Content Discovery:** Public posts list featuring advanced search, category indexing, and tag filtering.
- **Content Moderation:** Draft vs. published post visibility, managed directly from the back-office.
- **Localization:** Built-in multi-language mapping and routing (English & Polish).
- **UI/UX:** Responsive UI seamlessly supporting Light and Dark modes.

## Local Setup

1. **Clone the repository:**
   ```bash
   git clone <repo-url>
   cd blog-2
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Initialize database:**
   ```bash
   php artisan migrate --seed
   ```

5. **Start development server:**
   ```bash
   php artisan serve
   ```
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
composer run serve
```

In a second terminal run frontend watcher + queue listener:

```bash
composer run dev
```

App URL for this setup:

```text
http://127.0.0.1:9001
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

- `/` - home with top weekly posts
- `/blog` - posts list
- `/posts` - legacy redirect to `/blog`
- `/posts/{slug}` - post details
- `/contact` - contact page
- `/bookmarks` - user bookmarks (verified users)
- `/account/settings` - profile settings
- `/admin` - Filament panel (admin users)
- `/sitemap.xml` - sitemap
