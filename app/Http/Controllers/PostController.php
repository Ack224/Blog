<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'tag' => ['nullable', 'string', 'max:100'],
        ]);

        $posts = Post::query()
            ->with(['user', 'tags'])
            ->withCount(['likedByUsers', 'bookmarkedBy'])
            ->published()
            ->search($validated['q'] ?? null)
            ->inCategory($validated['category'] ?? null)
            ->withTag($validated['tag'] ?? null)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categories = Post::query()
            ->published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $tags = Tag::query()
            ->whereHas('posts', function ($query): void {
                $query->published();
            })
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'filters' => [
                'q' => $validated['q'] ?? '',
                'category' => $validated['category'] ?? '',
                'tag' => $validated['tag'] ?? '',
            ],
        ]);
    }

    public function show(string $slug)
    {
        $query = Post::where('slug', $slug)
            ->with([
                'user',
                'tags',
                'comments' => function ($query): void {
                    $query
                        ->approved()
                        ->whereNull('parent_id')
                        ->with([
                            'user',
                            'likedByUsers',
                            'replies' => function ($replyQuery): void {
                                $replyQuery->approved()->with(['user', 'likedByUsers'])->latest();
                            },
                        ])
                        ->latest();
                },
            ])
            ->withCount(['likedByUsers', 'bookmarkedBy']);

        if (auth()->check()) {
            $query->where(function ($visibleQuery): void {
                $visibleQuery
                    ->where('is_published', true)
                    ->orWhere('user_id', auth()->id());
            });
        } else {
            $query->where('is_published', true);
        }

        $post = $query->firstOrFail();

        $isBookmarked = auth()->check()
            ? auth()->user()->bookmarks()->where('post_id', $post->id)->exists()
            : false;

        $isLiked = auth()->check()
            ? auth()->user()->likedPosts()->where('post_id', $post->id)->exists()
            : false;

        // Get 3 random related posts
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where('is_published', true)
            ->with('user')
            ->withCount(['likedByUsers', 'bookmarkedBy'])
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'isBookmarked' => $isBookmarked,
            'isLiked' => $isLiked,
        ]);
    }

    public function create()
    {
        $this->authorize('create-post', Post::class);

        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create-post', Post::class);

        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'lead' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'custom_category' => ['nullable', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'max:3072'],
            'is_published' => ['boolean'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ]);

        $resolvedCategory = trim((string) ($parameters['custom_category'] ?? ''));
        if ($resolvedCategory === '') {
            $resolvedCategory = $parameters['category'] ?? null;
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $parameters['title'],
            'slug' => $parameters['slug'],
            'lead' => $parameters['lead'] ?? null,
            'content' => $parameters['content'],
            'category' => $resolvedCategory,
            'photo' => $photoPath,
            'is_published' => $parameters['is_published'] ?? false,
            'meta_description' => $parameters['meta_description'] ?? null,
            'user_id' => auth()->id(),
            'author' => auth()->user()->name,
        ]);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post został utworzony!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update-post', $post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update-post', $post);

        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,'.$post->id],
            'lead' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'custom_category' => ['nullable', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'max:3072'],
            'is_published' => ['boolean'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ]);

        $resolvedCategory = trim((string) ($parameters['custom_category'] ?? ''));
        if ($resolvedCategory === '') {
            $resolvedCategory = $parameters['category'] ?? null;
        }

        $photoPath = $post->photo;
        if ($request->hasFile('photo')) {
            if ($post->photo) {
                Storage::disk('public')->delete($post->photo);
            }

            $photoPath = $request->file('photo')->store('posts', 'public');
        }

        $post->update([
            'title' => $parameters['title'],
            'slug' => $parameters['slug'],
            'lead' => $parameters['lead'] ?? null,
            'content' => $parameters['content'],
            'category' => $resolvedCategory,
            'photo' => $photoPath,
            'is_published' => $parameters['is_published'] ?? false,
            'meta_description' => $parameters['meta_description'] ?? null,
        ]);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post został zaktualizowany!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete-post', $post);

        if ($post->photo) {
            Storage::disk('public')->delete($post->photo);
        }

        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Post został usunięty!');
    }

    public function storeComment(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'content' => ['required', 'string', 'min:3'],
        ]);

        if (auth()->check()) {
            $isApproved = auth()->id() === $post->user_id;

            // Authenticated user
            $post->comments()->create([
                'user_id' => auth()->id(),
                'author' => auth()->user()->name,
                'email' => auth()->user()->email,
                'content' => $validated['content'],
                'is_approved' => $isApproved,
            ]);

            $message = $isApproved
                ? 'Komentarz został dodany!'
                : 'Komentarz oczekuje na moderacje.';
        } else {
            // Guest - can still comment if form allows
            return redirect()->back()->with('error', 'Musisz być zalogowany aby dodać komentarz!');
        }

        return redirect()->route('posts.show', $post->slug)->with('success', $message);
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:3'],
        ]);

        $post = $comment->post;
        $isApproved = auth()->id() === $post->user_id;

        $post->comments()->create([
            'user_id' => auth()->id(),
            'author' => auth()->user()->name,
            'email' => auth()->user()->email,
            'content' => $validated['content'],
            'is_approved' => $isApproved,
            'parent_id' => $comment->id,
        ]);

        $message = $isApproved
            ? 'Odpowiedz zostala dodana.'
            : 'Odpowiedz oczekuje na moderacje.';

        return redirect()->route('posts.show', $post->slug)->with('success', $message);
    }

    public function toggleLike(Comment $comment)
    {
        $alreadyLiked = $comment->likedByUsers()
            ->where('users.id', auth()->id())
            ->exists();

        DB::transaction(function () use ($comment, $alreadyLiked): void {
            if ($alreadyLiked) {
                $comment->likedByUsers()->detach(auth()->id());
                $comment->decrement('likes_count');

                return;
            }

            $comment->likedByUsers()->syncWithoutDetaching([auth()->id()]);
            $comment->increment('likes_count');
        });

        return back()->with('success', $alreadyLiked ? 'Usunieto polubienie komentarza.' : 'Polubiono komentarz.');
    }
}
