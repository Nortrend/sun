<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\StoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    public function index()
    {
        $comments = CommentResource::collection(Comment::latest()->get())->resolve();
        return inertia('Admin/Comment/Index', compact('comments'));
    }

    public function show(Comment $comment)
    {
        $comment = CommentResource::make($comment)->resolve();
        return inertia('Admin/Comment/Show', compact('comment'));
    }

    public function create()
    {
        $types = CommentService::availableTypes();

        // Получаем посты и статьи
        $posts = \App\Models\Post::select('id', 'title')->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'type' => 'Post',
            ];
        });

        $articles = \App\Models\Article::select('id', 'title')->get()->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'type' => 'Article',
            ];
        });

        // Объединяем их в один список
        $commentables = $posts->concat($articles)->values();

        // Получаем комментарии
        $comments = \App\Models\Comment::select('id', 'content')->get();

        return inertia('Admin/Comment/Create', [
            'types' => $types,
            'commentables' => $commentables,
            'comments' => $comments,
        ]);
    }


    public function store(StoreRequest $request)
    {
//        $this->commentService->store($request->validated());
//        return redirect()->route('admin.comments.index')->with('success', 'Комментарий успешно создан');
        $category = $this->commentService->store($request->validated());
        return CommentResource::make($category)->resolve();
    }
}
