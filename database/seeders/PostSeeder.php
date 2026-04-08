<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        Post::firstOrCreate(
            ['slug' => 'moj-pierwszy-post'],
            [
                'title' => 'Mój Pierwszy Post',
                'lead' => 'Witaj na moim blogu! To jest mój pierwszy artykuł.',
                'content' => 'To jest zawartość mojego pierwszego postu. Możesz tutaj rozwijać swoje pomysły i dzielić się wiedzą z innymi programistami.',
                'author' => 'Jan Kowalski',
                'photo' => '📝',
                'is_published' => true,
                'category' => 'Laravel',
                'user_id' => $users->first()->id,
            ]
        );

        Post::firstOrCreate(
            ['slug' => 'laravel-12-tutorial'],
            [
                'title' => 'Laravel 12 - Complete Tutorial',
                'lead' => 'Naucz się wszystkiego o najnowszej wersji Laravel',
                'content' => 'Laravel 12 wprowadza wiele nowych funkcji i ulepszeń. W tym poradniku dowiesz się jak je wykorzystać w swoich projektach. Od autentykacji aż po zaawansowane techniki optymalizacji.',
                'author' => 'Maria Nowak',
                'photo' => '🚀',
                'is_published' => true,
                'category' => 'Laravel',
                'user_id' => $users->where('name', 'Maria Nowak')->first()->id ?? $users->last()->id,
            ]
        );

        Post::firstOrCreate(
            ['slug' => 'react-best-practices'],
            [
                'title' => 'React Best Practices 2024',
                'lead' => 'Poznaj najlepsze praktyki tworzenia aplikacji React',
                'content' => 'Czy używasz React? Sprawdź jakie są najnowsze best practices w komuności React. Od hooks, aż po state management - wszystko co powinieneś wiedzieć.',
                'author' => 'Admin User',
                'photo' => '⚛️',
                'is_published' => true,
                'category' => 'React',
                'user_id' => $users->last()->id,
            ]
        );
    }
}

