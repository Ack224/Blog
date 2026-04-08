<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-world/{name}', [HelloController::class, 'index']);
Route::post('/locale/{locale}', [UserController::class, 'switchLocale'])->name('locale.switch');
Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'store'])
    ->name('newsletter.subscribe');
Route::get('/newsletter/confirm/{token}', [NewsletterSubscriptionController::class, 'confirm'])
    ->name('newsletter.confirm');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterSubscriptionController::class, 'unsubscribe'])
    ->name('newsletter.unsubscribe');

Route::get('/sitemap.xml', function () {
    $pages = collect([
        [
            'loc' => route('posts.index'),
            'lastmod' => now()->toDateString(),
        ],
    ]);

    $posts = Post::query()
        ->published()
        ->latest('updated_at')
        ->get(['slug', 'updated_at'])
        ->map(function (Post $post): array {
            return [
                'loc' => route('posts.show', $post->slug),
                'lastmod' => optional($post->updated_at)->toDateString(),
            ];
        });

    return response()
        ->view('sitemap', ['urls' => $pages->merge($posts)])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Public post routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// Guest-only routes (auth not required, redirects if already logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Protected routes (auth required)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::middleware('verified')->group(function () {
        Route::get('/account/settings', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/account/settings', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/follow', [UserController::class, 'follow'])->name('follows.store');
        Route::delete('/users/{user}/follow', [UserController::class, 'unfollow'])->name('follows.destroy');
        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
        Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'store'])->name('bookmarks.store');
        Route::delete('/posts/{post}/bookmark', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::post('/posts/{id}/comments', [PostController::class, 'storeComment'])->name('comments.store');
        Route::post('/comments/{comment}/reply', [PostController::class, 'storeReply'])->name('comments.reply');
        Route::post('/comments/{comment}/like', [PostController::class, 'toggleLike'])->name('comments.like');
        Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])->name('posts.like');
    });
});

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
