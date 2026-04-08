<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->with('user');

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
            ->with(['tags', 'user', 'comments.user'])
            ->firstOrFail();

        // Pobierz komentarze z paginacją
        $comments = $post->comments()
            ->whereNull('parent_id')
            ->with(['replies.user', 'user'])
            ->paginate(5);

        // Pobierz 3 losowe posty inne niż obecny
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->with('user')
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
        $post->user_id = Auth::id();

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post został utworzony!');
    }

    public function storeComment(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'author' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string', 'min:3'],
        ]);

        $validated['user_id'] = Auth::id();

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

        $validated['user_id'] = Auth::id();
        $validated['parent_id'] = $commentId;

        $post->comments()->create($validated);

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

        if (!Gate::allows('update-post', $post)) {
            abort(403, 'Nie masz uprawnień do edycji tego posta.');
        }

        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        if (!Gate::allows('update-post', $post)) {
            abort(403, 'Nie masz uprawnień do edycji tego posta.');
        }

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

        if (!Gate::allows('delete-post', $post)) {
            abort(403, 'Nie masz uprawnień do usunięcia tego posta.');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post został usunięty!');
    }
}

