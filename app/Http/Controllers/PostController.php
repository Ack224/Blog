<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // Filtr search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('lead', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        // Filtr category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $posts = $query->paginate(9);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->with('tags')
            ->firstOrFail();
        
        // Pobierz komentarze z paginacją
        $comments = $post->comments()
            ->whereNull('parent_id')
            ->with('replies')
            ->paginate(5);
        
        // Pobierz 3 losowe posty inne niż obecny
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
            'relatedPosts' => $relatedPosts,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'lead' => ['nullable', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $post = new Post;

        $post->title = $parameters['title'];
        $post->slug = $parameters['slug'];
        $post->lead = $parameters['lead'] ?? null;
        $post->author = $parameters['author'];
        $post->content = $parameters['content'];

        // Post::create($parameters);

        $post->save();

        return redirect()->route('posts.index');
    }

    public function storeComment(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'author' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string', 'min:3'],
        ]);

        $post->comments()->create($validated);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Komentarz został dodany!');
    }

    public function storeReply(Request $request, int $postId, int $commentId)
    {
        $post = Post::findOrFail($postId);
        $parentComment = Comment::findOrFail($commentId);

        $validated = $request->validate([
            'author' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string', 'min:3'],
        ]);

        $post->comments()->create([
            ...$validated,
            'parent_id' => $commentId,
        ]);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Odpowiedź została dodana!');
    }

    public function likeComment(Request $request, int $postId, int $commentId)
    {
        $post = Post::findOrFail($postId);
        $comment = Comment::findOrFail($commentId);

        $comment->increment('likes_count');

        return redirect()->route('posts.show', $post->slug);
    }

    public function edit(int $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $id],
            'lead' => ['nullable', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['nullable', 'string'],
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post został zaktualizowany!');
    }

    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post został usunięty!');
    }
}
