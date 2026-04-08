<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        $user1 = User::create([
            'name' => 'Jan Kowalski',
            'email' => 'jan@example.com',
            'password' => bcrypt('password123'),
            'theme' => 'light',
        ]);

        $user2 = User::create([
            'name' => 'Maria Nowak',
            'email' => 'maria@example.com',
            'password' => bcrypt('password123'),
            'theme' => 'dark',
        ]);

        $user3 = User::create([
            'name' => 'Piotr Lewandowski',
            'email' => 'piotr@example.com',
            'password' => bcrypt('password123'),
            'theme' => 'light',
        ]);

        // Create sample posts
        Post::create([
            'title' => 'Wprowadzenie do Laravel 12',
            'slug' => 'wprowadzenie-do-laravel-12',
            'lead' => 'Dowiedz się, jakie nowe funkcje przynosi Laravel 12 i jak z nich korzystać.',
            'content' => '<p>Laravel 12 to kolejna wersja popularnego frameworku PHP. W tym artykule omówimy główne zmiany i ulepszenia.</p><p>Nowe funkcje obejmują lepszą wydajność, ulepszoną obsługę asynchroniczności i wiele innych.</p>',
            'author' => 'Jan Kowalski',
            'user_id' => $user1->id,
            'is_published' => true,
            'meta_description' => 'Poznaj najnowszą wersję Laravel i jej możliwości.',
        ]);

        Post::create([
            'title' => 'Best Practices w Tailwind CSS',
            'slug' => 'best-practices-tailwind-css',
            'lead' => 'Naucz się najlepszych praktyk pisania czystego kodu w Tailwind CSS.',
            'content' => '<p>Tailwind CSS to utility-first framework CSS, który zmienia sposób stylizacji aplikacji.</p><p>W tym poradniku nauczymy się jak pisać skalowalne i łatwe w utrzymaniu style.</p>',
            'author' => 'Maria Nowak',
            'user_id' => $user2->id,
            'is_published' => true,
            'meta_description' => 'Praktyczne porady do Tailwind CSS dla twojego projektu.',
        ]);

        Post::create([
            'title' => 'Asynchroniczne programowanie w PHP',
            'slug' => 'asynchroniczne-programowanie-php',
            'lead' => 'Odkryj, jak pisać asynchroniczny kod w PHP za pomocą ReactPHP.',
            'content' => '<p>Programowanie asynchroniczne pozwala na wykonywanie wielu operacji jednocześnie.</p><p>ReactPHP to biblioteka umożliwiająca asynchroniczne programowanie w PHP.</p>',
            'author' => 'Piotr Lewandowski',
            'user_id' => $user3->id,
            'is_published' => true,
            'meta_description' => 'Asynchroniczne operacje w PHP - kompletny poradnik.',
        ]);

        Post::create([
            'title' => 'Testowanie w Pest Framework',
            'slug' => 'testowanie-pest-framework',
            'lead' => 'Naucz się pisać testy w nowoczesnym frameworku Pest.',
            'content' => '<p>Pest to nowoczesny framework testowania dla PHP, oparty na PHPUnit.</p><p>Oferuje prostszą i bardziej przyjazną składnię do pisania testów.</p>',
            'author' => 'Jan Kowalski',
            'user_id' => $user1->id,
            'is_published' => true,
            'meta_description' => 'Kompletny przewodnik po Pest Framework.',
        ]);

        Post::create([
            'title' => 'Bezpieczeństwo w Laravel',
            'slug' => 'bezpieczeństwo-laravel',
            'lead' => 'Poznaj najważniejsze techniki bezpieczeństwa w Laravel.',
            'content' => '<p>Laravel zawiera wiele wbudowanych mechanizmów bezpieczeństwa.</p><p>CSRF,SQL Injection, XSS - wszystkie są chronione z odpowiednimi narzędziami.</p>',
            'author' => 'Maria Nowak',
            'user_id' => $user2->id,
            'is_published' => true,
            'meta_description' => 'Bezpieczeństwo Laravel - najlepsze praktyki.',
        ]);
    }
}
