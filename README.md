# Advanced Blog Platform 🚀

> A premium multi-user blog platform built with Laravel 12, featuring user authentication, post management, real-time comments, and social features.

Perfect for developers who want a professional blog for their portfolio!

## ✨ Features

### 🔐 Authentication & Authorization
- **User Registration & Login** - Secure account creation with validation
- **Session-based Auth** - Laravel's default guard using cookies/sessions
- **Post Ownership** - Only post authors can edit/delete their posts with Gates-based authorization
- **Protected Routes** - Separate middleware for authenticated and guest users

### 📝 Advanced Blog Features
- **Rich Post Management** - Create, edit, delete posts with metadata (title, slug, lead, content, category)
- **Post Categories** - Organize posts by topic
- **Tags System** - Polymorphic tagging with related posts display
- **Reading Time Estimate** - Automatic calculation based on word count
- **Beautiful Cards** - Modern gradient avatars and hover effects

### 💬 Comment System
- **Nested Comments** - Main comments with infinite nested replies
- **Auto User Population** - Comments linked to authenticated users
- **Like System** - Users can like comments and replies
- **Pagination** - Up to 5 comments per page

### 👥 Social Features
- **Follow Authors** - Users can follow other bloggers
- **Author Profiles** - See follower count and collected posts
- **User Avatars** - Gradient avatars generated from user initials
- **Follower Stats** - Display in author card and sidebar

### 🔖 Bookmarking System
- **Save Posts** - Users can bookmark favorite articles
- **Toggle Bookmarks** - Add/remove from bookmarks with one click
- **Personal Collection** - (Extensible for bookmarks page)

### 🎨 UI/UX
- **Modern Design** - Tailwind CSS v4 with custom gradients
- **Responsive Layout** - Works perfectly on mobile, tablet, and desktop
- **Sticky Author Sidebar** - Quick access to author info while scrolling
- **Smooth Transitions** - Hover effects and transition animations
- **Polish & Polish** - Clean typography and visual hierarchy
- **Filament Admin Panel** - Manage content via admin dashboard

## 🛠 Tech Stack

| Layer | Technologies |
|-------|---------------|
| **Backend** | Laravel 12, PHP 8.4 |
| **Frontend** | Blade Templates, Tailwind CSS 4, Alpine.js |
| **Database** | SQLite (default, can use MySQL/PostgreSQL) |
| **Admin** | Filament v5 |
| **Testing** | Pest Framework 4 |
| **Build** | Vite 5, npm |

## 📦 Installation

### Prerequisites
- PHP 8.4+
- Node.js 18+
- Composer
- Laravel Herd (or alternative dev environment)

### Setup Steps

```bash
# 1. Clone the repository
git clone <your-repo-url>
cd blog

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Create database & run migrations
php artisan migrate

# 5. Setup storage link (for file uploads)
php artisan storage:link

# 6. Install Laravel Boost (optional)
php artisan boost:install

# 7. Build assets
npm run build
```

## 🚀 Running the Application

### Development Mode
```bash
# Option 1: Using composer script (recommended)
composer run dev

# Option 2: Manual startup
php artisan serve         # Terminal 1
npm run dev              # Terminal 2
```

Server runs on: **http://localhost:8000**

### Production Build
```bash
npm run build
php artisan optimize:clear
```

## 📚 Usage Guide

### For Users

#### Creating an Account
1. Click "Zarejestruj się" in navigation
2. Enter name, email, password (min 8 characters)
3. Confirm password and submit
4. Automatically logged in!

#### Writing a Post
1. Click "➕ Nowy Post" in navigation
2. Fill in post details:
   - **Title**: Post headline
   - **Slug**: URL-friendly identifier (auto-suggested)
   - **Lead**: Short summary
   - **Content**: Full post content
   - **Author**: Your name
   - **Category**: (Optional) Topic classification
3. Save and view instantly!

#### Interacting with Content
- **Search & Filter**: Find posts by title/content or category
- **Comments**: Add thoughts (requires login)
- **Replies**: Respond to specific comments
- **Like Comments**: Show appreciation
- **Follow Authors**: Get notified of new posts (in progress)
- **Bookmark Posts**: Save to read later

### For Admins

#### Filament Admin Panel
```
URL: http://localhost:8000/admin
```

Features:
- Manage all posts
- Monitor comments
- User management
- Content reporting

## 🗄️ Database Schema

### Key Tables
- `users` - User accounts with auth data
- `posts` - Blog articles with user_id foreign key
- `comments` - Nested comments linked to posts/users
- `followers` - Many-to-many relationship for following (user ID pairs)
- `bookmarks` - Many-to-many for saved posts
- `tags` & `taggables` - Polymorphic tagging system

## 🔒 Security

✅ CSRF protection on all forms (`@csrf`)
✅ Password hashing with Laravel's default algorithm
✅ SQL injection prevention via Eloquent ORM
✅ User authorization gates for post editing/deletion
✅ XSS prevention in comments (consider HTML sanitization)

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/PostTest.php

# Run with coverage
php artisan test --coverage
```

## 📝 Code Quality

### Formatting
```bash
vendor/bin/pint
```

### Standards
- PSR-12 code style
- Naming conventions followed
- Seeders for demo data
- Factory classes for testing

## 🚀 Future Enhancements

Potential features to add:
- [ ] Email notifications for comments
- [ ] Post drafts & scheduling
- [ ] Advanced search with full-text indexing
- [ ] Dark mode toggle
- [ ] Author following feed
- [ ] Bookmark collections
- [ ] Comment moderation
- [ ] Social media sharing optimizations
- [ ] Analytics dashboard
- [ ] API endpoints for mobile app

## 📁 Project Structure

```
blog-2/
├── app/
│   ├── Models/           # Post, User, Comment, Bookmark, etc.
│   ├── Http/
│   │   ├── Controllers/  # AuthController, PostController, etc.
│   │   └── Middleware/   #  Auth middleware
│   └── Providers/        # Route providers, Gates
├── resources/
│   ├── views/
│   │   ├── posts/        # Post CRUD views
│   │   ├── auth/         # Login/Register forms
│   │   └── components/   # Reusable Blade components
│   └── css/              # Tailwind styles
├── routes/               # web.php with all routes
├── database/
│   ├── migrations/       # Schema files
│   └── seeders/          # Sample data
├── config/               # Laravel config
└── public/               # Static assets
```

## 💡 Tips & Best Practices

1. **Always authenticate before posting**: The app requires login to create content
2. **Use meaningful post slugs**: They're permanent URLs - choose wisely
3. **Tag your posts**: Helps readers find related content
4. **Moderate comments**: Remove spam/inappropriate content via admin panel
5. **Backup database**: Use `php artisan backup:run` regularly

## 🐛 Troubleshooting

### "No Application Encryption Key"
```bash
php artisan key:generate
```

### "CORS/Session Issues"
```bash
php artisan session:table
php artisan migrate
```

### "Assets Not Loading"
```bash
npm run build
php artisan storage:link
```

### "Database Locked"
Close any open database connections and restart:
```bash
php artisan migrate:reset
php artisan migrate
```

## 🔗 Useful Links

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Blade Template Syntax](https://laravel.com/docs/blade)

## 📄 License

MIT License - Feel free to use this project for your portfolio!

## 👨‍💻 Author

Built with ❤️ for developers who want a professional blog platform.

---

**Happy blogging! 🎉**

Questions? Check the Laravel docs or Filament guides for more info.
